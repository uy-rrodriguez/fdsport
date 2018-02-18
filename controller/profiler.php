<?php
require_once 'controller.php';
require_once 'pca.php';

class profiler extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }
    
    public function index() {
        $productsFilename = $this->processProfilingProducts();

        // Render a template
        echo $this->plates->render('profiler', [
            'title' => 'Graphe de profiling',
            'productsFilename' => BASE_URL . '/' . $productsFilename
        ]);
    }

    public function data() {
        $this->processProfilingProducts();
    }

    /**
     * Process the profiling data for products and returns the name of the file where
     * the resulting JSON will be stored.
     *
     * @return string Produced JSON data
     */
    public function processProfilingProducts() {
        $products = $this->getTestProducts();
        $products2D = $this->getProducts2D($products);
        $productsJSON = $this->getNodesJSON($products2D);

        $filename = 'profiling_products.json';
        file_put_contents($filename, $productsJSON);

        return $filename;
    }

    /**
     * Process the profiling data for users and returns the name of the file where
     * the resulting JSON will be stored.
     *
     * @return string Produced JSON data
     */
    public function processProfilingUsers() {
        $products = $this->getTestProducts();
        $products2D = $this->getProducts2D($products);
        $productsJSON = $this->getNodesJSON($products2D);

        $filename = 'profiling_users.json';
        file_put_contents($filename, $productsJSON);

        return $filename;
    }

    public function getTestProducts() {
        $products = array();
        for ($i = 1; $i <= 20; $i++) {
            $products[] = array(
                'id' => $i,
                'title' => 'Produit ' . $i,
                'profilingData' => new ProfilingItem()
            );
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
            0, 0, 1, 0, 0,
            0, 1, 0,
            1, 0,
            0, 0, 0, 1,
            0, 0, 0, 0, 0, 0, 0, 0, 1
        );
        $products[0]['name'] = 'Man - Young adult - CSP++ - Nice - Rugby';
        $products[0]['profilingData']->setStaticVars(array_combine($variables, $values));

        // Woman - Young - CSP- - Marseille - Football
        $values = array(
            0, 1, 0, 0, 0,
            1, 0, 0,
            0, 1,
            1, 0, 0, 0,
            0, 0, 0, 0, 0, 0, 0, 1, 0
        );
        $products[1]['name'] = 'Woman - Young - CSP- - Marseille - Football';
        $products[1]['profilingData']->setStaticVars(array_combine($variables, $values));

        // Man - Adult - CSP+ - Clermont - Rugby
        $values = array(
            0, 0, 0, 1, 0,
            0, 1, 0,
            1, 0,
            0, 0, 1, 0,
            0, 0, 0, 1, 0, 0, 0, 0, 0
        );
        $products[2]['name'] = 'Man - Adult - CSP+ - Clermont - Rugby';
        $products[2]['profilingData']->setStaticVars(array_combine($variables, $values));

        // Woman - Old adult - CSP+ - Montpellier - Handball
        $values = array(
            0, 0, 0, 0, 1,
            0, 0, 1,
            0, 1,
            0, 0, 1, 0,
            0, 0, 0, 0, 0, 0, 1, 0, 0
        );
        $products[3]['name'] = 'Woman - Old adult - CSP+ - Montpellier - Handball';
        $products[3]['profilingData']->setStaticVars(array_combine($variables, $values));

        // Man - Young adult - CSP~ - Lyon - Football
        $values = array(
            0, 0, 1, 0, 0,
            1, 0, 0,
            1, 0,
            0, 1, 0, 0,
            0, 0, 0, 0, 1, 0, 0, 0, 0
        );
        $products[4]['name'] = 'Man - Young adult - CSP~ - Lyon - Football';
        $products[4]['profilingData']->setStaticVars(array_combine($variables, $values));

        return $products;
    }

    public function getProducts2D($products) {
        // Principal Component Analysis to get the items represented in two dimensions
        $points = array();
        foreach ($products as $product) {
            if (! $product['profilingData']->isUnset()) {
                $coords = array_values($product['profilingData']->getVars());
                $points[] = $coords;
            }
        }

        $pca = new PCA\PCA($points);
        $pca->changeDimension(2);
        $pca->applayingPca();
        $pcaResult = $pca->getNewData();

        $products2D = array();
        foreach ($products as $i => $product) {
            if (! $product['profilingData']->isUnset()) {
                $products2D[] = array(
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'profilingData' => $product['profilingData'],
                    'x' => $pcaResult[$i][0],
                    'y' => $pcaResult[$i][1]
                );
            }
        }

        return $products2D;
    }

    public function getNodesJSON($products2D) {
        // Max and min values helps us center the origin of coordinates
        $minX = false; $maxX = false; $minY = false; $maxY = false;

        $nodes = array();
        foreach ($products2D as $i => $product) {
            $n = array (
                'id' => $product['id'],
                'label' => $product['name'],
                'x' => 8 * $product['x'],
                'y' => $product['y'],
                'size' => 3
            );

            if ($product['profilingData']->isStatic()) {
                $n['size'] = 2;
                $n['color'] = '#666';
            }

            $nodes[] = $n;

            if ($minX === false || $n['x'] < $minX) $minX = $n['x'];
            if ($maxX === false || $n['x'] > $maxX) $maxX = $n['x'];
            if ($minY === false || $n['y'] < $minY) $minY = $n['y'];
            if ($maxY === false || $n['y'] > $maxY) $maxY = $n['y'];
        }

        $nodes[] = array (
            'id' => '0',
            'label' => '',
            'x' => ($maxX + $minX) / 2,
            'y' => ($maxY + $minY) / 2,
            'size' => 1,
            'color' => '#AAA'
        );

        $data = array(
            'edges' => array(),
            'nodes' => $nodes
        );

        return json_encode($data);
    }
}

class ProfilingItem {
    private $vars = array();
    public $static = false;
    public $unset = true;

    function __construct() {}

    function __set($name, $value) {
        $this->vars[$name] = floatval($value);
    }

    public function __get($name) {
        if (key_exists($name, $this->vars)) {
            return $this->vars[$name];
        }
        else {
            return 0;
        }
    }

    public function getVars() {
        return $this->vars;
    }

    public function isUnset() {
        return $this->unset;
    }

    public function isStatic() {
        return $this->static;
    }

    public function setStaticVars($vars) {
        $this->vars = array();
        $this->vars = array_merge($this->vars, $vars);
        $this->unset = false;
        $this->static = true;
    }

    public function copyVars(ProfilingItem $origin) {
        if ($this->static) return;

        $this->unset = false;
        $this->vars = array();
        foreach ($origin->vars as $name => $value) {
            $this->$name = $value;
        }
    }

    public function moveToMiddle(ProfilingItem $previous) {
        if ($this->static) {
            if (! $previous->static)
                $previous->moveToMiddle($this);
        }
        else if ($this->unset) {
            $this->unset = false;
            $this->copyVars($previous);
        }
        else {
            $mixVarsKeys = array_merge(array_keys($this->vars), array_keys($previous->vars));
            foreach ($mixVarsKeys as $name) {
                $this->$name = ($this->$name + $previous->$name) / 2;
            }
        }
    }
}