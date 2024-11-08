<?php

require_once 'EmployeeRoster.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class Main {
    private EmployeeRoster $roster;
    private int $size;

    public function __construct() {
        $this->roster = new EmployeeRoster();
    }

    public function start() {
        $this->clearScreen();
        $this->displayRosterInfo();

        while (true) {
            $this->size = (int) readline("Enter the size of the roster : ");
            
      
            echo "Available size of Roster: " . $this->size . "\n";
            if ($this->size < 1) {
                echo "Invalid input. Please enter a positive integer.\n";
            } else {
                break;
            }
        }
    
        $this->entrance();
    }

    public function entrance() {
        while (true) {
            $this->clearScreen();
            $this->displayMenu();

            $choice = readline("Enter your choice: ");
            switch ($choice) {
                case 1:
                    $this->addEmployee();
                    break;
                case 2:
                    $this->deleteEmployee();
                    break;
                case 3:
                    $this->otherOptions();
                    break;
                case 0:
                    echo "Process terminated.\n";
                    exit;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" to return to the menu...");
                    break;
            }
        }
    }

    public function displayMenu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Options\n";
        echo "[0] Exit\n";
    }

    public function addEmployee() {
        $this->clearScreen();
        echo "Add Employee Details:\n";
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        $age = readline("Enter age: ");
        $company = readline("Enter company name: ");
    
        echo "[1] Commission Employee       [2] Hourly Employee       [3] Piece Worker\n";
        $type = readline("Select type of employee: ");
    
        switch ($type) {
            case 1:
                $baseSalary = (float) readline("Enter base salary: "); 
                $commissionRate = (float) readline("Enter commission rate: ");
                $sales = (float) readline("Enter sales: ");
                $employee = new CommissionEmployee($name, $address, $age, $company, $baseSalary, $commissionRate, $sales);
                break;
            case 2:
                $hourlyRate = (float) readline("Enter hourly rate: ");
                $hoursWorked = (float) readline("Enter hours worked: ");
                $employee = new HourlyEmployee($name, $address, $age, $company, $hourlyRate, $hoursWorked);
                break;
            case 3:
                $pieceRate = (float) readline("Enter # of item: ");
                $piecesProduced = (int) readline("Enter wageperItem: ");
                $employee = new PieceWorker($name, $address, $age, $company, $pieceRate, $piecesProduced);
                break;
            default:
                echo "Invalid input. Returning to menu.\n";
                return;
        }
    
        $this->roster->addEmployee($employee);
        echo "Employee added successfully!\n";
        readline("Press \"Enter\" to return to the menu...");
    }
    
    public function deleteEmployee() {
        $this->clearScreen();
        echo "*** List of Employees ***\n";

        if ($this->roster->count() === 0) {
            echo "No employees to remove.\n";
        } else {
            foreach ($this->roster->getEmployees() as $index => $employee) {
                echo "Employee #" . ($index + 1) . "\n";
                echo "Name       : " . $employee->getName() . "\n";
                echo "Address    : " . $employee->getAddress() . "\n";
                echo "Age        : " . $employee->getAge() . "\n";
                echo "Company    : " . $employee->getCompany() . "\n";
                echo "Type       : " . get_class($employee) . "\n";
                echo "-----------------------------\n";
            }

            $id = (int) readline("Select Employee to Remove (use the assigned #): ");
            
            if ($id > 0 && $id <= $this->roster->count()) {
                $this->roster->removeEmployee($id - 1);
                echo "Employee removed successfully.\n";
            } else {
                echo "Invalid selection.\n";
            }
        }

        readline("Press \"Enter\" to return to the menu...");
    }

    public function otherOptions() {
        $this->clearScreen();
        echo "[1] Display All Employees\n";
        echo "[2] Count Employees\n";
        echo "[3] Calculate Payroll\n";
        echo "[0] Return\n";

        $choice = readline("Select an option: ");

        switch ($choice) {
            case 1:
                $this->displayAllEmployees();
                break;
            case 2:
                $this->countEmployees();
                break;
            case 3:
                echo "Total payroll: $" . $this->roster->calculateTotalPayroll() . "\n";
                break;
            case 0:
                return;
            default:
                echo "Invalid input. Returning to menu.\n";
                break;
        }

        readline("Press \"Enter\" to continue...");
    }

    public function displayAllEmployees() {
        $this->clearScreen();
        echo "*** List of Employees ***\n";

        if ($this->roster->count() === 0) {
            echo "No employees in the roster.\n";
        } else {
            foreach ($this->roster->getEmployees() as $index => $employee) {
                echo "Employee #" . ($index + 1) . "\n";
                echo "Name       : " . $employee->getName() . "\n";
                echo "Address    : " . $employee->getAddress() . "\n";
                echo "Age        : " . $employee->getAge() . "\n";
                echo "Company    : " . $employee->getCompany() . "\n";
                echo "Type       : " . get_class($employee) . "\n";
                echo "-----------------------------\n";
            }
        }

        readline("Press \"Enter\" to return to the menu...");
    }

    private function countEmployees() {
        echo "Employee Count Options:\n";
        echo "[1] Count All Employees\n";
        echo "[2] Count Commission Employees\n";
        echo "[3] Count Hourly Employees\n";
        echo "[4] Count Piece Worker Employees\n";
        
        $choice = readline("Enter your choice: ");

        $count = 0;
        switch ($choice) {
            case 1:
                echo "Total Employees: " . $this->roster->count() . "\n";
                break;
            case 2:
                foreach ($this->roster->getEmployees() as $employee) {
                    if ($employee instanceof CommissionEmployee) $count++;
                }
                echo "Commission Employees: $count\n";
                break;
            case 3:
                foreach ($this->roster->getEmployees() as $employee) {
                    if ($employee instanceof HourlyEmployee) $count++;
                }
                echo "Hourly Employees: $count\n";
                break;
            case 4:
                foreach ($this->roster->getEmployees() as $employee) {
                    if ($employee instanceof PieceWorker) $count++;
                }
                echo "Piece Worker Employees: $count\n";
                break;
            default:
                echo "Invalid input.\n";
                break;
        }
    }

    private function clearScreen() {
        echo str_repeat("\n", 1);
    }

    private function displayRosterInfo() {
        echo "*** Current Employee Roster ***\n";
        if ($this->roster->count() > 0) {
            echo "Total Employees: " . $this->roster->count() . "\n";
            $this->displayAllEmployees();
        } else {
            echo "No employees in the roster.\n";
        }
        echo "-------------------------------\n";
    }
}

$entry = new Main();
$entry->start();
