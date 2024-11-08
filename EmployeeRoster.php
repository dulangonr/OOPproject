<?php

class EmployeeRoster {
    private array $employees = [];

    public function addEmployee(Employee $employee): void {
        $this->employees[] = $employee;
    }

    public function getEmployees(): array {
        return $this->employees;
    }

    public function count(): int {
        return count($this->employees);
    }

    public function calculateTotalPayroll(): float {
        $totalPayroll = 0;
        foreach ($this->employees as $employee) {
            $totalPayroll += $employee->earnings();
        }
        return $totalPayroll;
    }

    public function removeEmployee(int $index): void {
        if (isset($this->employees[$index])) {
            array_splice($this->employees, $index, 1);
        }
    }
}
