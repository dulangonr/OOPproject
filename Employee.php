<?php

require_once 'Person.php';

class Employee extends Person {
    protected $company;

    public function __construct($name, $address, $age, $company) {
        parent::__construct($name, $address, $age);
        $this->company = $company;
    }

    public function getCompany() {
        return $this->company;
    }

    public function getSalary() {
        return 0;
    }
}
