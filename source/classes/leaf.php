<?php
class Leaf
{
    protected $weight = 0;

    public function __construct($weight = 0) {
        $this->setWeight($weight);
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight = 0) {
        $this->weight = $weight;
    }
}