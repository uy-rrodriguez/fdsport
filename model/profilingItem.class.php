<?php

class profilingItem {
    private $vars = array();

    public $static = false;
    public $unset = true;

    public $type = '';
    public $id = '';
    public $name = '';

    public $coordX = 0;
    public $coordY = 0;

    function __construct($type, $id, $name) {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
    }

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
        $this->unset = false;
        $this->vars = $vars;
    }

    public function setStaticVars($vars) {
        $this->static = true;
        $this->setVars($vars);
    }

    public function isUnset() {
        return $this->unset;
    }

    public function setUnset($unset) {
        $this->unset = $unset;
    }

    public function isStatic() {
        return $this->static;
    }

    public function setStatic($static) {
        $this->static = $static;
    }

    public function getType() {
        return $this->type;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCoordX() {
        return $this->coordX;
    }

    public function setCoordX($coordX) {
        $this->coordX = $coordX;
    }

    public function getCoordY() {
        return $this->coordY;
    }

    public function setCoordY($coordY) {
        $this->coordY = $coordY;
    }

    public function copyVars(ProfilingItem $origin) {
        if ($this->static) return;

        $this->unset = false;
        $this->vars = array();
        foreach ($origin->vars as $name => $value) {
            $this->$name = $value;
        }

        // 2D coordinates
        $this->coordX = $origin->coordX;
        $this->coordY = $origin->coordY;
    }

    public function moveToMiddle(ProfilingItem $newItem) {
        if ($this->unset) {
            if (! $newItem->unset)
                $this->copyVars($newItem);
        }
        else if ($newItem->unset) {
            $newItem->copyVars($this);
        }
        else if ($this->static) {
            if (! $newItem->static)
                $newItem->moveToMiddle($this);
        }
        else {
            $mixVarsKeys = array_merge(array_keys($this->vars), array_keys($newItem->vars));
            foreach ($mixVarsKeys as $var) {
                $this->$var = ($this->$var + $newItem->$var) / 2;
            }

            // 2D coordinates
            $this->coordX = ($this->coordX + $newItem->coordX) / 2;
            $this->coordY = ($this->coordY + $newItem->coordY) / 2;
        }
    }
}