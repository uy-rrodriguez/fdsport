<?php
require_once 'controller.php';
require_once 'pca.php';

class profiler extends Controller {
    function __construct($plates) {
        //session_destroy();
        parent::__construct($plates);
    }
    
    public function index() {
        $filename = $this->processProfiling();

        // Render a template
        echo $this->plates->render('profiler', [
            'title' => 'Graphe de profiling',
            'filename' => BASE_URL . '/' . $filename
        ]);
    }

    public function data() {
        $this->processProfiling();
    }

    /**
     * Loads the profiling data from the database and stores it in the session.
     */
    public function loadProfilingData() {
        if (! isset($_SESSION['profiling_products'])) {
            $products = $this->getTestProducts();
            $_SESSION['profiling_products'] = $products;
        }

        if (! isset($_SESSION['profiling_user'])) {
            $user = $this->getUserProfile();
            $_SESSION['profiling_user'] = $user;
        }
    }

    /**
     * Update the profiling data for the connected user using the product information.
     *
     * @param $productID
     */
    public function updateUser($productID) {
        $this->loadProfilingData();

        // Search product data
        $products = $_SESSION['profiling_products'];
        $productData = false;
        foreach ($products as $p) {
            if ($p->getId() == $productID) {
                $productData = $p;
                break;
            }
        }

        if ($productData === false) {
            $productData = new profilingItemProduct($productID, 'Produit ' . $productID);
            $_SESSION['profiling_products'][] = $productData;
        }

        // Search user data
        $userData = $_SESSION['profiling_user'];

        // Move user profile
        $userData->moveToMiddle($productData);
        $_SESSION['profiling_user'] = $userData;
    }

    /**
     * Update the profiling data for the previously visited product using the new product information.
     *
     * @param $previousProductID
     * @param $newProductID
     */
    public function updateProduct($previousProductID, $newProductID) {
        $this->loadProfilingData();

        // Search product data
        $products = $_SESSION['profiling_products'];
        $previousProductData = false;
        $newProductData = false;
        foreach ($products as $p) {
            if ($p->getId() == $previousProductID) {
                $previousProductData = $p;
            }
            else if ($p->getId() == $newProductID) {
                $newProductData = $p;
            }

            if ($previousProductData !== false && $newProductData !== false)
                break;
        }

        if ($previousProductData === false) {
            $previousProductData = new profilingItemProduct($previousProductID, 'Produit ' . $previousProductID);
            $_SESSION['profiling_products'][] = $previousProductData;
        }

        if ($newProductData === false) {
            $newProductData = new profilingItemProduct($newProductID, 'Produit ' . $newProductID);
            $_SESSION['profiling_products'][] = $newProductData;
        }

        // Move old product profile
        $previousProductData->moveToMiddle($newProductData);
    }

    /**
     * Process the profiling data and returns the name of the file where
     * the resulting JSON will be stored.
     *
     * @return string Produced JSON data
     */
    public function processProfiling() {
        $this->loadProfilingData();

        $user = $_SESSION['profiling_user'];
        $products = $_SESSION['profiling_products'];

        $allItems = array($user);
        $allItems = array_merge($allItems, $products);

        //$allItems = $this->getItems2D($allItems);
        $itemsJSON = $this->getNodesJSON($allItems);

        $filename = 'profiling.json';
        file_put_contents($filename, $itemsJSON);

        return $filename;
    }

    public function getTestProducts() {
        $products = array();
        for ($i = 1; $i <= 20; $i++) {
            $products[] = new profilingItemProduct($i, 'Produit ' . $i);
        }

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
        $products[1]->setName('Woman - Young - CSP- - Marseille - Football');
        $products[1]->setStaticVars(array_combine($variables, $values));

        // Man - Young adult - CSP~ - Clermont - Rugby
        $values = array(
            0, 0, 1, 0, 0,
            0, 1, 0,
            1, 0,
            0, 1, 0, 0,
            0, 0, 0, 1, 0, 0, 0, 0, 0
        );
        $products[2]->setName('Man - Young adult - CSP~ - Clermont - Rugby');
        $products[2]->setStaticVars(array_combine($variables, $values));

        // Woman - Old adult - CSP+ - Montpellier - Handball
        $values = array(
            0, 0, 0, 0, 1,
            0, 0, 1,
            0, 1,
            0, 0, 1, 0,
            0, 0, 0, 0, 0, 0, 1, 0, 0
        );
        $products[3]->setName('Woman - Old adult - CSP+ - Montpellier - Handball');
        $products[3]->setStaticVars(array_combine($variables, $values));

        // Man - Young adult - CSP~ - Lyon - Football
        $values = array(
            0, 0, 1, 0, 0,
            1, 0, 0,
            1, 0,
            0, 1, 0, 0,
            0, 0, 0, 0, 1, 0, 0, 0, 0
        );
        $products[4]->setName('Man - Young adult - CSP~ - Lyon - Football');
        $products[4]->setStaticVars(array_combine($variables, $values));

        // Calculate once the 2D coordinates for static items
        $static = array_slice($products, 0, 5);
        $this->getItems2D($static);

        return $products;
    }

    public function getUserProfile() {
        $user = new profilingItemUser(0, 'User');
        return $user;
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
                $n = array(
                    'id' => $item->getId(),
                    'label' => $item->getName(),
                    'x' => 7 * $item->getCoordX(),
                    'y' => $item->getCoordY(),
                    'size' => 3
                );

                if ($item->isStatic()) {
                    $n['size'] = 2;
                    $n['color'] = '#666';
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
}