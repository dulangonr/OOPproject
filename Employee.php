<?php
require_once 'Person.php';

abstract class Employee extends Person {
    private string $companyName;

    public function __construct(string $name, string $address, int $age, string $companyName) {
        parent::__construct($name, $address, $age);
        $this->companyName = $companyName;
    }

    public function getCompany(): string {
        return $this->companyName;
    }

    abstract public function earnings(): float;

    public function __toString(): string {
        return parent::__toString() . ", Company: $this->companyName";
    }
}

