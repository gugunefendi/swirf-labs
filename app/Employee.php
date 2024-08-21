<?php

class Employee
{
    private $name;
    private $number_identification;
    private $dob;
    private $address;
    private $occupation;
    private $place;

    public function __construct($name, $number_identification, $dob, $address, $occupation, $place)
    {
        $this->name = $name;
        $this->number_identification = $number_identification;
        $this->dob = $dob;
        $this->address = $address;
        $this->occupation = $occupation;
        $this->place = $place;
    }

    public function getName() { return $this->name; }
    public function getNumberIdentification() { return $this->number_identification; }
    public function getDOB() { return $this->dob; }
    public function getAddress() { return $this->address; }
    public function getOccupation() { return $this->occupation; }
    public function getPlace() { return $this->place; }
    public function getAge()
    {
        $birthdate = new DateTime($this->dob);
        $today = new DateTime('today');
        return $birthdate->diff($today)->y;
    }
}
