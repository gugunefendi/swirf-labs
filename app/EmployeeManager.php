<?php

require_once '../config/config.php';
require_once 'Employee.php';
require_once 'EmployeeValidator.php';

class EmployeeManager
{
    private $pdo;
    private $validator;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->validator = new EmployeeValidator();
    }

    public function validateEmployee($employee)
    {
        return $this->validator->validate($employee);
    }

    public function addEmployee($employee)
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO employees (name, number_identification, age, dob, address, occupation, place) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $employee->getName(),
                $employee->getNumberIdentification(),
                $employee->getAge(),
                $employee->getDob(),
                $employee->getAddress(),
                $employee->getOccupation(),
                $employee->getPlace(),
            ]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getEmployees()
    {
        $stmt = $this->pdo->query('SELECT * FROM employees');
        $employees = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $employee = new Employee(
                $row['name'],
                $row['number_identification'],
                $row['dob'],
                $row['address'],
                $row['occupation'],
                $row['place']
            );
            $employees[] = [
                'name' => $employee->getName(),
                'age' => $employee->getAge(),
                'address' => $employee->getAddress(),
                'occupation' => $employee->getOccupation()
            ];
        }

        return $employees;
    }

    public function handleRequest($method, $data = null)
    {
        if ($method === 'POST') {
            $employee = new Employee(
                $data['name'],
                $data['number_identification'],
                $data['dob'],
                $data['address'],
                $data['occupation'],
                $data['place']
            );

            // Validasi
            $validationMessage = $this->validateEmployee($employee);

            if ($validationMessage) {
                http_response_code(400);
                echo json_encode(
                    [
                        'success' => false, 
                        'message' => $validationMessage
                    ]
                );
            } else {
                $result = $this->addEmployee($employee);
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'data' => $result
                ]);
            }
        } else {
            // GET employees
            $employees = $this->getEmployees();
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $employees
            ]);
        }
    }
}
