<?php

class profilingItemProduct extends profilingItem {
    private $product = null;

    function __construct($id, $product) {
        parent::__construct('product', $id, $product->name);

        $this->product = $product;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setName($name) {
        $this->name = $name;
    }
}