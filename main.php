<?php

require_once 'EmployeeRoster.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class Main {
    private EmployeeRoster $roster;
    private $size;

    public function __construct() {
        $this->roster = new EmployeeRoster();
    }

    public function start() {
        $this->clear();
        $this->size = readline("Enter the size of the roster: ");
        
        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to Return...");
            $this->start();
        } else {
            $this->entrance();
        }
    }

    public function entrance() {
        $choice = 0;

        while (true) {
            $this->clear();
            $this->menu();

            $choice = readline("Enter your choice: ");
            switch ($choice) {
                case 1:
                    $this->addEmployee();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    echo "Process terminated.\n";
                    exit;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to Return..");
                    break;
            }
            }
         }
    
    public function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    public function addEmployee() {
        $this->clear();
        echo "Add Employee Details:\n";
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        $age = readline("Enter age: ");
        $company = readline("Enter company name: ");
    
        echo "[1] Commission Employee       [2] Hourly Employee       [3] Piece Worker\n";
        $type = readline("Select type of employee: ");
    
        switch ($type) {
            case 1:
                $baseSalary = (float)readline("Enter base salary: "); 
                $commissionRate = (float)readline("Enter commission rate: ");
                $sales = (float)readline("Enter sales: ");
                $employee = new CommissionEmployee($name, $address, $age, $company, $baseSalary, $commissionRate, $sales);
                break;
            case 2:
                $hourlyRate = (float)readline("Enter hourly rate: ");
                $hoursWorked = (float)readline("Enter hours worked: ");
                $employee = new HourlyEmployee($name, $address, $age, $company, $hourlyRate, $hoursWorked);
                break;
            case 3:
                $pieceRate = (float)readline("Enter piece rate: ");
                $piecesProduced = (int)readline("Enter pieces produced: ");
                $employee = new PieceWorker($name, $address, $age, $company, $pieceRate, $piecesProduced);
                break;
            default:
                echo "Invalid input. Returning to menu.\n";
                return;
        }
    
        $this->roster->addEmployee($employee);
        echo "Employee added!\n";
        readline("Press \"Enter\" key to Return...");
    }
    
    
    public function deleteMenu() {
        $this->clear();
        echo "*** LIST of Employees on the current Roster ***\n";

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

            $id = readline("Select Employee to Remove (use the assigned #): ");
            
            if (is_numeric($id) && $id > 0 && $id <= $this->roster->count()) {
                $this->roster->removeEmployee($id - 1);
                echo "Employee Removed.\n";
            } else {
                echo "Invalid selection.\n";
            }
        }

        readline("Press \"Enter\" key to Return...");
    }

    public function otherMenu() {
        $this->clear();
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
                echo "Total number of employees: " . $this->roster->count() . "\n";
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

        readline("Press \"Enter\" key to continue...");
    }

    public function displayAllEmployees() {
        $this->clear();
        echo "*** LIST of Employees on the current Roster ***\n";

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

        readline("Press \"Enter\"to Return...");
    }

    private function clear() {
        echo str_repeat("\n", 1); 
    }
}

$entry = new Main();
$entry->start();
