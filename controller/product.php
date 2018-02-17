<?php
require_once 'controller.php';

class product extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }

    public function all() {
        // Get filters from session
        $subcat = isset($_SESSION['product_filters']['subcategory'])
                    ? $_SESSION['product_filters']['subcategory']
                    : 0;

        $products = array();
        for ($i = 1; $i <= 10; $i++) {
            $products[] = array(
                'id' => $i,
                'name' => 'Product '.$i,
                'price' => $i,
                'discount' => $i,
                'category' => 'Category X',
                'sizes' => 'S,M,L,XL',
                'isFavorite' => ($i % 2 == 0 ? true : false),
                'image' => 'holder.js/200x200?text=IMG'
            );
        }

        echo $this->plates->render('product_list', ['title' => 'Subcategory '.$subcat, 'products' => $products]);
    }
    
    public function allBySubcategory($id) {
        $_SESSION['product_filters'] = array();
        $_SESSION['product_filters']['subcategory'] = $id;
        http_redirect(BASE_URL . '/product/all');
    }
}