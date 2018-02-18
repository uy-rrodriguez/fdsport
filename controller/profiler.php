<?php
require_once 'controller.php';
require_once 'pca.php';

class profiler extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }
    
    public function index() {
        $products = $this->getTestProducts();
        $products2D = $this->getProducts2D($products);
        $productsJSON = $this->getNodesJSON($products2D);

        // Render a template
        echo $this->plates->render('profiler', [
            'title' => 'Graphe de profiling',
            'products' => $productsJSON
        ]);
    }

    public function data() {
        $products = $this->getTestProducts();

        // Render a template
        echo $this->plates->render('profiler', [
            'title' => 'Graphe de profiling',
            'products' => $products
        ]);
    }

    public function getTestProducts() {
        $products = array();
        for ($i = 1; $i <= 5; $i++) {
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

        // Man - Young adult - CSP++ - Nice - Rugby
        $values = array(
            0, 0, 1, 0, 0,
            0, 1, 0,
            1, 0,
            0, 0, 0, 1,
            0, 0, 0, 0, 0, 0, 0, 0, 1
        );
        $products[0]['name'] = 'Man - Young adult - CSP++ - Nice - Rugby';
        $products[0]['profilingData']->setVars(array_combine($variables, $values));

        // Woman - Young - CSP- - Marseille - Football
        $values = array(
            0, 1, 0, 0, 0,
            1, 0, 0,
            0, 1,
            1, 0, 0, 0,
            0, 0, 0, 0, 0, 0, 0, 1, 0
        );
        $products[1]['name'] = 'Woman - Young - CSP- - Marseille - Football';
        $products[1]['profilingData']->setVars(array_combine($variables, $values));

        // Man - Adult - CSP+ - Clermont - Rugby
        $values = array(
            0, 0, 0, 1, 0,
            0, 1, 0,
            1, 0,
            0, 0, 1, 0,
            0, 0, 0, 1, 0, 0, 0, 0, 0
        );
        $products[2]['name'] = 'Man - Adult - CSP+ - Clermont - Rugby';
        $products[2]['profilingData']->setVars(array_combine($variables, $values));

        // Woman - Old adult - CSP+ - Montpellier - Handball
        $values = array(
            0, 0, 0, 0, 1,
            0, 0, 1,
            0, 1,
            0, 0, 1, 0,
            0, 0, 0, 0, 0, 0, 1, 0, 0
        );
        $products[3]['name'] = 'Woman - Old adult - CSP+ - Montpellier - Handball';
        $products[3]['profilingData']->setVars(array_combine($variables, $values));

        // Man - Young adult - CSP~ - Lyon - Football
        $values = array(
            0, 0, 1, 0, 0,
            1, 0, 0,
            1, 0,
            0, 1, 0, 0,
            0, 0, 0, 0, 1, 0, 0, 0, 0
        );
        $products[4]['name'] = 'Man - Young adult - CSP~ - Lyon - Football';
        $products[4]['profilingData']->setVars(array_combine($variables, $values));

        return $products;
    }

    public function getProducts2D($products) {
        // Principal Component Analysis to get the items represented in two dimensions
        $points = array();
        foreach ($products as $product) {
            $coords = array_values($product['profilingData']->getVars());
            $points[] = $coords;
        }

        $pca = new PCA\PCA($points);
        $pca->changeDimension(2);
        $pca->applayingPca();
        $pcaResult = $pca->getNewData();

        $products2D = array();
        foreach ($products as $i => $product) {
            $products2D[] = array (
                'id' => $product['id'],
                'name' => $product['name'],
                'x' => $pcaResult[$i][0],
                'y' => $pcaResult[$i][1]
            );
        }

        return $products2D;
    }

    public function getNodesJSON($products2D) {
        $nodes = array();

        foreach ($products2D as $i => $product) {
            $nodes[] = array (
                'id' => $product['id'],
                'label' => $product['name'],
                'x' => $product['x'],
                'y' => $product['y'],
                'size' => 1
            );
        }

        $data = array(
            'edges' => array(),
            'nodes' => $nodes
        );

        return json_encode($data);
    }
}

class ProfilingItem {
    private $vars = array();
    private $isStatic = false;
    private $isUnset = true;

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

    public function setVars($vars) {
        $this->vars = array();
        $this->vars = array_merge($this->vars, $vars);
    }

    public function copyVars(ProfilingItem $origin) {
        if ($this->isStatic) return;

        $this->isUnset = false;
        $this->vars = array();
        foreach ($origin->vars as $name => $value) {
            $this->$name = $value;
        }
    }

    public function moveToMiddle(ProfilingItem $previous) {
        if ($this->isStatic) {
            if (! $previous->isStatic)
                $previous->moveToMiddle($this);
        }
        else if ($this->isUnset) {
            $this->isUnset = false;
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