<?php

class profilingItemProduct extends profilingItem {
    function __construct($id, $name) {
        parent::__construct('product', $id, $name);
    }
}