<?php

class profilingItemUser extends profilingItem {
    function __construct($id, $name) {
        parent::__construct('user', $id, $name);
    }
}