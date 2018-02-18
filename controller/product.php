<?php
require_once 'controller.php';

class product extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }

    public function show($id) {
        // Product data
        $product = array(
            'id' => $id,
            'name' => 'Product '.$id,
            'price' => $id,
            'discount' => $id,
            'category' => 'Category X',
            'sizes' => array('S', 'M', 'L', 'XL'),
            'isFavorite' => ($id % 2 == 0 ? true : false),
            'images' => array(
                'holder.js/200x200?text=IMG 1',
                'holder.js/200x200?text=IMG 2',
                'holder.js/200x200?text=IMG 3'
            ),
            'description' => 'Description du produit ' . $id
        );

        // Associated products
        $products = array();
        for ($i = 1; $i <= 5; $i++) {
            $products[] = array(
                'id' => $i,
                'name' => 'Product '.$i,
                'price' => $i,
                'discount' => $i,
                'image' => 'holder.js/200x200?text=IMG'
            );
        }

        echo $this->plates->render('product', ['title' => 'Product '.$id, 'product' => $product, 'recommended' => $products]);
    }

    public function all() {
        // Get filters from session
        $subcat = isset($_SESSION['product_filters']['subcategory'])
                    ? $_SESSION['product_filters']['subcategory']
                    : 0;

        $recommended = isset($_SESSION['product_filters']['recommended'])
                        ? true
                        : false;


        // Title for the new page
        $title = 'Liste de produits';
        if ($subcat !== 0)
            $title = 'Subcategorie ' . $subcat;

        else if ($recommended == true)
            $title = 'Produits recommandés';


        // Get products from DB
        $products = array();
        for ($i = 1; $i <= 10; $i++) {
            $products[] = array(
                'id' => $i,
                'name' => 'Product ' . $i,
                'price' => $i,
                'discount' => $i,
                'category' => 'Category X',
                'sizes' => 'S,M,L,XL',
                'isFavorite' => ($i % 2 == 0 ? true : false),
                'image' => 'holder.js/200x200?text=IMG'
            );
        }

        echo $this->plates->render('product_list', ['title' => $title, 'products' => $products]);
    }
    
    public function allBySubcategory($id) {
        $_SESSION['product_filters'] = array();
        $_SESSION['product_filters']['subcategory'] = $id;
        header('Location: ' . BASE_URL . '/product/all');
    }

    public function allRecommended() {
        $_SESSION['product_filters'] = array();
        $_SESSION['product_filters']['recommended'] = true;
        /*http_redirect(BASE_URL . '/product/all');*/
        header('Location: ' . BASE_URL . '/product/all');
    }
}