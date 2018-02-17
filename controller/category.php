<?php
require_once 'controller.php';

class category extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }
    
    public function show($id) {
        $products = array();
        for ($i = 1; $i <= 10; $i++) {
            $products[] = array(
                'id' => $i,
                'name' => 'Product '.$i,
                'price' => $i,
                'discount' => $i
            );
        }
        
        $subcats = array();
        for ($i = 1; $i <= 3; $i++) {
            $subcats[] = array(
                'id' => $i,
                'name' => 'Subcategory '.$id.'-'.$i,
                'btnAllAction' => BASE_URL . '/product/allBySubcategory/' . $id,
                'products' => $products
            );
        }
        
        echo $this->plates->render('category', ['title' => 'Category '.$id, 'subcategories' => $subcats]);
    }
}