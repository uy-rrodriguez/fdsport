<?php
require_once 'controller.php';
require_once 'pca.php';

class profilerCtrl extends Controller {
    private $productProfiles = array();
    private $userProfile = null;
    private $lastProductProfile = null;
    private $forceProcessing = false;

    function __construct($plates) {
        parent::__construct($plates);
    }
    
    public function index() {
        // Force processing
        $this->forceProcessing = true;
        $filename = $this->processProfiling();

        // Render a template
        echo $this->plates->render('profiler', [
            'title' => 'Graphe de profiling',
            'filename' => BASE_URL . '/' . $filename
        ]);
    }

    public function test() {
        echo $this->plates->render('profiler_test', [
            'title' => 'Test de profiling'
        ]);
    }

    public function data() {
        $this->processProfiling();
    }

    public function reset() {
        session_destroy();
        profilingTable::deleteAll();

        // Force processing
        $this->forceProcessing = true;
        $this->processProfiling();
    }

    /**
     * Loads the profiling for products from the database and stores it as attribute.
     * Creates a new user profile in session if it doesn't exists.
     */
    public function loadProfilingData() {
        // Load product profiles from DB
        $profilesDB = profilingTable::getProfilings();

        if (count($profilesDB) <= 0) {
            $staticProducts = $this->initStaticProducts();
            foreach ($staticProducts as $p) {
                profilingTable::save($this->exportItemProductToDB($p));
            }
            $profilesDB = profilingTable::getProfilings();
        }

        $this->productProfiles = array();
        foreach ($profilesDB as $p) {
            $this->productProfiles[] = $this->importItemProductFromDB($p);
        }

        /*
        $this->productProfiles[0]->setName('Man - Adult - CSP++ - Nice - Rugby');
        $this->productProfiles[1]->setName('Woman - Young - CSP- - Marseille - Football');
        $this->productProfiles[2]->setName('Man - Young adult - CSP~ - Clermont - Rugby');
        $this->productProfiles[3]->setName('Woman - Old adult - CSP+ - Montpellier - Handball');
        $this->productProfiles[4]->setName('Man - Young adult - CSP~ - Lyon - Football');
        */

        // Load user profile from SESSION
        if (! isset($_SESSION['profiling_user'])) {
            $user = new profilingItemUser(0, 'User');
            $_SESSION['profiling_user'] = $user;
        }
        $this->userProfile = $_SESSION['profiling_user'];

        // Load last product profile from SESSION
        if (isset($_SESSION['profiling_last_product_id'])) {
            $productDB = profilingTable::getProfilingById($_SESSION['profiling_last_product_id']);
            if ($productDB)
                $this->lastProductProfile = $this->importItemProductFromDB($productDB);
        }
    }

    /**
     * Gets a profiling item as stored in DB and returns a profilingItemProduct.
     *
     * @param profiling $profiling
     * @return profilingItemProduct
     */
    public function importItemProductFromDB(profiling $profiling) {
        $profilingProduct = new profilingItemProduct(
            $profiling->id,
            $profiling->product
        );

        $profilingData = json_decode($profiling->profil);
        $profilingProduct->setVars((array) $profilingData->vars);
        $profilingProduct->setCoordX($profilingData->coordX);
        $profilingProduct->setCoordY($profilingData->coordY);
        $profilingProduct->setStatic($profilingData->static);
        $profilingProduct->setUnset($profilingData->unset);

        return $profilingProduct;
    }

    /**
     * Gets a profilingItemProduct and returns a profiling item to store in DB.
     *
     * @param profilingItemProduct $profilingProduct
     * @return profiling
     */
    public function exportItemProductToDB(profilingItemProduct $profilingProduct) {
        $profiling = new profiling();
        $profiling->id = $profilingProduct->getId();
        $profiling->product = $profilingProduct->getProduct();

        $profilingData = array(
            'static' => $profilingProduct->isStatic(),
            'unset' => $profilingProduct->isUnset(),
            'coordX' => $profilingProduct->getCoordX(),
            'coordY' => $profilingProduct->getCoordY(),
            'vars' => $profilingProduct->getVars()
        );
        $profiling->profil = json_encode($profilingData);

        return $profiling;
    }

    /**
     * Update the profiling data for the current user using the product information.
     *
     * @param $productID
     */
    public function updateUser($productID) {
        $this->loadProfilingData();

        // Search product data
        $productData = false;
        foreach ($this->productProfiles as $p) {
            if ($p->getProduct()->id == $productID) {
                $productData = $p;
                break;
            }
        }

        $productUnset = ($productData === false);
        if ($productUnset) {
            $product = productTable::getProductById($productID);
            $productData = new profilingItemProduct(0, $product);
        }


        // If the product already had a profiling data, we will move it accordingly to the last visited item
        if ($productUnset === false && $this->lastProductProfile !== null) {
            $this->updateProduct($this->lastProductProfile, $productData);
        }
        else {
            // Do nothing
        }

        // Move user profile
        $this->userProfile->moveToMiddle($productData);
        $_SESSION['profiling_user'] = $this->userProfile;

        // If it is a new product, we store it in the DB
        if ($productUnset) {
            profilingTable::save($this->exportItemProductToDB($productData));
        }


        // Change last product in session
        $_SESSION['profiling_last_product_id'] = $productData->getId();

        // Tell the system that new data exists => NOTICE: this method is not thread-safe
        $_SESSION['profiling_new_data'] = true;
    }

    /**
     * Update the profiling data for the previously visited product using the new product information.
     *
     * @param $previousProductData
     * @param $newProductData
     */
    public function updateProduct($previousProductData, $newProductData) {
        // Move old product profile
        $newProductData->moveToMiddle($previousProductData);

        // Store product data
        profilingTable::save($this->exportItemProductToDB($previousProductData));
        profilingTable::save($this->exportItemProductToDB($newProductData));
    }

    /**
     * Process the profiling data and returns the name of the file where
     * the resulting JSON will be stored.
     *
     * @return string Produced JSON data
     */
    public function processProfiling() {
        $filename = 'profiling.json';

        // Do not process data if no changes have been made
        if ($this->forceProcessing || isset($_SESSION['profiling_new_data'])) {
            $this->forceProcessing = false;
            unset($_SESSION['profiling_new_data']);

            $this->loadProfilingData();

            $allItems = array($this->userProfile);
            $allItems = array_merge($allItems, $this->productProfiles);

            //$allItems = $this->getItems2D($allItems);
            $itemsJSON = $this->getNodesJSON($allItems);


            file_put_contents($filename, $itemsJSON);
        }

        return $filename;
    }

    public function initStaticProducts() {
        $products = array();

        $p = productTable::getProductById(43);
        $products[] = new profilingItemProduct(0, $p); // Maillot Racing 92 domicile 2017-18 Coq Sportif ciel blanc

        $p = productTable::getProductById(3);
        $products[] = new profilingItemProduct(0, $p); // Maillot OM (Femme)

        $p = productTable::getProductById(49);
        $products[] = new profilingItemProduct(0, $p); // Ballon Racing 92 Gilbert

        $p = productTable::getProductById(32);
        $products[] = new profilingItemProduct(0, $p); // Tee-shirt femme US Dunkerque Handball 2016/2017

        $p = productTable::getProductById(29);
        $products[] = new profilingItemProduct(0, $p); // Sweat à capuche OL Bleu

        /*
        for ($i = 1; $i <= 20; $i++) {
            $products[] = new profilingItemProduct(0, $i, 'Produit ' . $i);
        }
        */

        // Define variables
        $variables = array(
            'age_0_15', 'age_16_25', 'age_26_35', 'age_36_55', 'age_55_plus',
            'football', 'rugby', 'handball',
            'homme', 'femme',
            'csp_moins', 'csp_moyen', 'csp_plus', 'csp_plus_plus',
            'nantes', 'paris', 'lille', 'clermont', 'lyon', 'toulouse', 'montpellier', 'marseille', 'nice'
        );

        // Define 5 static products

        // Man - Adult - CSP++ - Nice - Rugby
        $values = array(
            0, 0, 0, 1, 0,
            0, 1, 0,
            1, 0,
            0, 0, 0, 1,
            0, 0, 0, 0, 0, 0, 0, 0, 1
        );
        $products[0]->setName('Man - Adult - CSP++ - Nice - Rugby');
        $products[0]->setStaticVars(array_combine($variables, $values));

        // Woman - Young - CSP- - Marseille - Football
        $values = array(
            0, 1, 0, 0, 0,
            1, 0, 0,
            0, 1,
            1, 0, 0, 0,
            0, 0, 0, 0, 0, 0, 0, 1, 0
        );
        //$products[1]->setName('Woman - Young - CSP- - Marseille - Football');
        $products[1]->setStaticVars(array_combine($variables, $values));

        // Man - Young adult - CSP~ - Clermont - Rugby
        $values = array(
            0, 0, 1, 0, 0,
            0, 1, 0,
            1, 0,
            0, 1, 0, 0,
            0, 0, 0, 1, 0, 0, 0, 0, 0
        );
        //$products[2]->setName('Man - Young adult - CSP~ - Clermont - Rugby');
        $products[2]->setStaticVars(array_combine($variables, $values));

        // Woman - Old adult - CSP+ - Montpellier - Handball
        $values = array(
            0, 0, 0, 0, 1,
            0, 0, 1,
            0, 1,
            0, 0, 1, 0,
            0, 0, 0, 0, 0, 0, 1, 0, 0
        );
        //$products[3]->setName('Woman - Old adult - CSP+ - Montpellier - Handball');
        $products[3]->setStaticVars(array_combine($variables, $values));

        // Man - Young adult - CSP~ - Lyon - Football
        $values = array(
            0, 0, 1, 0, 0,
            1, 0, 0,
            1, 0,
            0, 1, 0, 0,
            0, 0, 0, 0, 1, 0, 0, 0, 0
        );
        //$products[4]->setName('Man - Young adult - CSP~ - Lyon - Football');
        $products[4]->setStaticVars(array_combine($variables, $values));

        // Calculate once the 2D coordinates for static items
        $static = array_slice($products, 0, 5);
        $this->getItems2D($static);

        return $products;
    }

    public function getItems2D($items) {
        $items2D = array();
        $pcaPoints = array();
        foreach ($items as $item) {
            if (! $item->isUnset()) {
                $items2D[] = $item;
                $pcaPoints[] = array_values($item->getVars());
            }
        }

        // Principal Component Analysis to get the coordinates in two dimensions
        $pca = new PCA\PCA($pcaPoints);
        $pca->changeDimension(2);
        $pca->applayingPca();
        $pcaResult = $pca->getNewData();

        foreach ($items2D as $i => $item) {
            $item->setCoordX($pcaResult[$i][0]);
            $item->setCoordY($pcaResult[$i][1]);
        }

        return $items2D;
    }

    public function getNodesJSON($items2D) {
        $nodes = array();
        foreach ($items2D as $i => $item) {
            if (! $item->isUnset()) {

                $label = $item->getName();
                if ($item->getType() == 'product')
                    $label = '(' . $item->getProduct()->id . ') ' . $label;

                $n = array(
                    'id' => $item->getId(),
                    'label' => $label,
                    'x' => 6 * $item->getCoordX(),
                    'y' => $item->getCoordY(),
                    'size' => 1
                );

                if ($item->isStatic()) {
                    $n['size'] = 1;
                    $n['color'] = '#666666';
                }

                if ($item->getType() == 'user') {
                    $n['color'] = '#2222DD';
                }

                $nodes[] = $n;
            }
        }

        $data = array(
            'edges' => array(),
            'nodes' => $nodes
        );

        return json_encode($data);
    }

    /**
     * Returns an array with the N most similar products compared to the product with ID $productId.
     *
     * @param int $productId Product to search for similars
     * @param int $maxItems Maximum number of products in the result list
     * @param int $similarRadius Radius within the products are considered similars
     * @return array List of similar products
     */
    public function getSimilarProducts($productId, $maxItems, $similarRadius) {
        $similars = array();

        // Get central product from DB
        $centralProduct = productTable::getProductById($productId);
        if ($centralProduct) {

            // Get profiles from DB
            $profilesDB = profilingTable::getProfilings();
            $centralProductProfile = profilingTable::getProfilingByProductId($productId);

            if ($centralProductProfile && $profilesDB && count($profilesDB) > 0) {
                $centralProductIndex = 0;
                $productProfiles = array();
                $pcaPoints = array();

                for ($i = 0; $i < count($profilesDB); $i++) {
                    $p = $profilesDB[$i];
                    $productItem = $this->importItemProductFromDB($p);
                    $productProfiles[] = $productItem;
                    $pcaPoints[] = array_values($productItem->getVars());

                    // Store the index of the central product for later
                    if ($productItem->getProduct()->id == $productId)
                        $centralProductIndex = $i;
                }

                // Principal Component Analysis to get the coordinates in orthogonal axes
                $pca = new PCA\PCA($pcaPoints);
                $pca->changeDimension(2);
                $pca->applayingPca();
                $pcaResult = $pca->getNewData();

                // Get PCA coordinates for central product
                $centralProductCoords = $pcaResult[$centralProductIndex];

                // Calculate distance for each product
                foreach ($pcaResult as $i => $pcaCoords) {
                    $sumSquareCoords = 0;
                    foreach ($pcaCoords as $j => $coord) {
                        $dist = $coord - $centralProductCoords[$j];
                        $sumSquareCoords += $dist * $dist;
                    }

                    $distance = sqrt($sumSquareCoords);

                    // Add to $similars each product within a range of $similarRadius
                    if ($distance > 0 && $distance <= $similarRadius) {
                        $similars[] = $productProfiles[$i]->getProduct();
                    }
                }
            }


            // If there are less products than the maximum, whe search similar products
            // looking into some attributes
            if (count($similars) < $maxItems) {
                $products = productTable::getProductsByFilters(
                    $centralProduct->id,
                    $centralProduct->id_team->id,
                    $centralProduct->id_sport->id,
                    $centralProduct->type,
                    $centralProduct->gender,
                    $centralProduct->brand
                );

                $similars = array_merge(
                    $similars,
                    array_slice($products, 0, ($maxItems - count($similars)))
                );
            }
        }

        return $similars;
    }

    public function testSimilarProducts($productId) {
        $similars = $this->getSimilarProducts($productId, 10, 0.9);
        foreach ($similars as $s) {
            echo '<div>(' . $s->id . ') ' . $s->name . '</div>';
        }
    }
}