<?php

require_once '../config/config.php';
require_once 'Employee.php';
require_once 'EmployeeManager.php';

$employeeManager = new EmployeeManager($pdo);

// Request HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $employeeManager->handleRequest('POST', $data);
} else {
    $employeeManager->handleRequest('GET');
}
