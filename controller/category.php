<?php
require_once 'controller.php';

class categoryCtrl extends Controller {
    function __construct($plates) {
        parent::__construct($plates);
    }
    
    public function show($id) {
        
        /*
        $products = array();
        for ($i = 1; $i <= 10; $i++) {
            $products[] = array(
                'id' => $i,
                'name' => 'Product '.$i,
                'price' => $i,
                'discount' => $i
            );
        }
        */
        
        $productsInDB = productTable::getProducts();
        
        $products = array();
        $category = 'Tous les produits';
        
        switch ($id)
        {
            
            case 1:
            
                $category = 'Petit prix';
                
                foreach ($productsInDB as $productInDB)
                {
                    
                    if ($productInDB->price < 50)
                    {
                        
                        $products[] = array(
                            'id'        =>  $productInDB->id,
                            'name'      =>  $productInDB->name,
                            'price'     =>  $productInDB->price,
                            'discount'  =>  $productInDB->promotion,
                            'type'      =>  $productInDB->type
                        );
                        
                    }
                    
                }
            
                break;
                
            case 2:
            
                $category = 'Pour elles';
            
                foreach ($productsInDB as $productInDB)
                {
                    
                    if ($productInDB->gender == 'F')
                    {
                        
                        $products[] = array(
                            'id'        =>  $productInDB->id,
                            'name'      =>  $productInDB->name,
                            'price'     =>  $productInDB->price,
                            'discount'  =>  $productInDB->promotion,
                            'type'      =>  $productInDB->type
                        );
                        
                    }
                    
                }
            
                break;
                
            case 3:
            
                $category = 'Nos marques';
            
                foreach ($productsInDB as $productInDB)
                {
                    
                    if ($productInDB->brand != '')
                    {
                        
                        $products[] = array(
                            'id'        =>  $productInDB->id,
                            'name'      =>  $productInDB->name,
                            'price'     =>  $productInDB->price,
                            'discount'  =>  $productInDB->promotion,
                            'type'      =>  $productInDB->type
                        );
                        
                    }
                    
                }
            
                break;
                
            default:
            
                foreach ($productsInDB as $productInDB)
                {
                    
                    $products[] = array(
                        'id'        =>  $productInDB->id,
                        'name'      =>  $productInDB->name,
                        'price'     =>  $productInDB->price,
                        'discount'  =>  $productInDB->promotion,
                        'type'      =>  $productInDB->type
                    );
                    
                }
            
                break;
            
        }
        
        /*
        $subcats = array();
        for ($i = 1; $i <= 3; $i++) {
            $subcats[] = array(
                'id' => $i,
                'name' => 'Subcategory '.$id.'-'.$i,
                'btnAllAction' => BASE_URL . '/product/allBySubcategory/' . $id,
                'products' => $products
            );
        }
        */
        
        $sortedProducts = array();
        
        foreach ($products as $product)
        {
            
            if (!array_key_exists($product['type'], $sortedProducts))
            {
                
                $sortedProducts[$product['type']] = array();
                
            }
            
            array_push($sortedProducts[$product['type']], $product);
            
        }
        
        $subcats = array();
        $i = 1;
        
        foreach ($sortedProducts as $key => $value)
        {
            
            $subcats[] = array(
                'id'            =>  $i,
                'name'          =>  ucfirst($key),
                'btnAllAction'  =>  BASE_URL . '/product/allBySubcategory/' . $key,
                'products'       =>  $value
            );
            
            $i++;
            
        }
        
        /*
        echo $this->plates->render('category', ['title' => 'Category '.$id, 'subcategories' => $subcats]);
        */
        
        echo $this->plates->render('category', ['title' => $category, 'subcategories' => $subcats]);
    }
}