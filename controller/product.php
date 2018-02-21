<?php
require_once 'controller.php';
require_once 'profiler.php';

class productCtrl extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }

    private function getAssociatedProducts($id) {
        $associatedDB = (new profilerCtrl($this->plates))->getSimilarProducts($id, 10, 0.9);
        $associated = array();
        foreach ($associatedDB as $p) {
            $associated[] = array(
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
                'discount' => $p->promotion,
                'image' => 'holder.js/200x200?text=IMG'
            );
        }
        return $associated;
    }

    public function show($id) {

        // Update profiling
        $profiler = new profilerCtrl($this->plates);
        $profiler->updateUser($id);
        
        /*
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
        */
        
        $productInDB = productTable::getProductById($id);
        
        $product = array(
            'id'            =>  $productInDB->id,
            'name'          =>  $productInDB->name,
            'price'         =>  $productInDB->price,
            'discount'      =>  $productInDB->promotion,
            'category'      =>  $productInDB->type,
            'sizes'         =>  explode('|', $productInDB->size),
            'isFavorite'    =>  ($id % 2 == 0 ? true : false),
            'images'        =>  array(
                'holder.js/200x200?text=IMG 1',
                'holder.js/200x200?text=IMG 2',
                'holder.js/200x200?text=IMG 3'
            ),
            'description'   =>  $productInDB->description
        );

        // Associated products
        $products = $this->getAssociatedProducts($id);
        //$products = array();

        /*
        for ($i = 1; $i <= 5; $i++) {
            $products[] = array(
                'id' => $i,
                'name' => 'Product '.$i,
                'price' => $i,
                'discount' => $i,
                'image' => 'holder.js/200x200?text=IMG'
            );
        }
        */

        // Product profiling data
        $profilingData = profilingTable::getProfilingByProductId($id);
        $productProfile = json_decode($profilingData->profil)->vars;

        echo $this->plates->render('product', [
            'title' => $product['name'],
            'product' => $product,
            'recommended' => $products,
            'profile' => $productProfile
        ]);
    }

    public function all() {
        // Get filters from session
        $subcat = isset($_SESSION['product_filters']['subcategory'])
                    ? $_SESSION['product_filters']['subcategory']
                    : 0;

        $recommended = isset($_SESSION['product_filters']['recommended'])
                        ? true
                        : false;

        /*
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
        */
        
        $productsInDB = productTable::getProducts();
        
        $title = 'Liste de produits';
        $products = array();
        
        if ($subcat !== 0)
        {
            
            $title = $subcat;
            
            foreach ($productsInDB as $productInDB)
            {
                
                if ($productInDB->type == $subcat)
                {
                    
                    $products[] = array(
                        'id' => $productInDB->id,
                        'name' => $productInDB->name,
                        'price' => $productInDB->price,
                        'discount' => $productInDB->promotion,
                        'category' => $productInDB->type,
                        'sizes' => $productInDB->size,
                        'isFavorite' => ($productInDB->id % 2 == 0 ? true : false),
                        'image' => 'holder.js/200x200?text=IMG'
                    );
                    
                }
                
            }
            
        }
        else if ($recommended == true)
        {
            
            $title = 'Produits recommandés';
            
            foreach ($productsInDB as $productInDB)
            {
                
                if ($productInDB->type == $subcat)
                {
                    
                    $products[] = array(
                        'id' => $productInDB->id,
                        'name' => $productInDB->name,
                        'price' => $productInDB->price,
                        'discount' => $productInDB->promotion,
                        'category' => $productInDB->type,
                        'sizes' => $productInDB->size,
                        'isFavorite' => ($productInDB->id % 2 == 0 ? true : false),
                        'image' => 'holder.js/200x200?text=IMG'
                    );
                    
                }
                
            }
            
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