<?php
require_once 'controller.php';

class index extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }
    
    public function index() {
        $products = array();
        for ($i = 1; $i <= 10; $i++) {
            $products[] = array(
                'id' => $i,
                'name' => 'Product '.$i,
                'price' => $i,
                'discount' => $i
            );
        }

        $cats = array();
        $catsNames = array('Petits prix', 'Pour elles', 'Nos marques', '');
        for ($i = 1; $i <= 3; $i++) {
            $cats[] = array(
                'id' => $i,
                'title' => $catsNames[$i-1],
                'btnAllAction' => BASE_URL . '/category/show/' . $i,
                'products' => $products
            );
        }
        
        // Render a template
        echo $this->plates->render('index', ['title' => 'Index', 'categories' => $cats]);
    }
}