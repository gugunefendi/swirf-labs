<?php

require_once 'Employee.php';

class EmployeeValidator
{
    public function validate(Employee $employee)
    {
        $name = $employee->getName();
        $numberIdentification = $employee->getNumberIdentification();
        $dob = $employee->getDob();
        $occupation = $employee->getOccupation();

        if (empty($name) || empty($numberIdentification) || empty($dob) || empty($occupation)) {
            return 'Nama, NIK, Umur, dan Pekerjaan harus diisi.';
        }
        if (strlen($numberIdentification) !== 16) {
            return 'NIK harus 16 karakter.';
        }
        if (!ctype_digit($numberIdentification)) {
            return 'NIK hanya berisi angka.';
        }
        $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
        if (!$dobDate || $dobDate->format('Y-m-d') !== $dob) {
            return 'Format tanggal lahir tidak valid.';
        }
        $today = new DateTime();
        $age = $today->diff($dobDate)->y;
        if ($age < 18 || $age > 65) {
            return 'Usia harus (18-65 tahun).';
        }

        // Cek jika Nama sudah ada
        $nameExists = $this->checkNameExists($name);
        // Cek jika NIK sudah ada
        $numberExists = $this->checkNumberExists($numberIdentification);

        if ($nameExists && $numberExists) {
            return 'Nama dan NIK sudah ada.';
        } elseif ($nameExists) {
            return 'Nama sudah ada.';
        } elseif ($numberExists) {
            return 'NIK sudah ada.';
        }

        return null;
    }

    private function checkNameExists($name)
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM employees WHERE name = ?');
        $stmt->execute([$name]);
        return $stmt->fetchColumn() > 0;
    }

    private function checkNumberExists($numberIdentification)
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM employees WHERE number_identification = ?');
        $stmt->execute([$numberIdentification]);
        return $stmt->fetchColumn() > 0;
    }
}
