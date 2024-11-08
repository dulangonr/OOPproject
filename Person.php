<?php

class Person {
    protected $name;
    protected $address;
    protected $age;

    public function __construct($name, $address, $age) {
        $this->name = $name;
        $this->address = $address;
        $this->age = $age;
    }

    public function getName() {
        return $this->name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getAge() {
        return $this->age;
    }
}
