<?php

class Customer {
    private $id;
    private $customerRoleTypeId;
    private $firstName;
    private $lastName;
    private $address;
    private $city;
    private $state;
    private $zip;
    private $emailAddress;
    private $userName;
    private $password;
    private $dateAdded;
    private $dateUpdated;

    
    
    // Constructor
    // Constructor
    public function __construct(
        $firstName, $lastName, $address, $city, $state, $zip, $emailAddress, 
        $password, $userName = null, $id = null, $customerRoleTypeId = null, 
        $dateAdded = null, $dateUpdated = null
    ) {
        $this->id = $id;
        $this->customerRoleTypeId = $customerRoleTypeId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->emailAddress = $emailAddress;
        $this->userName = $userName;
        $this->password = $password;
        $this->dateAdded = $dateAdded;
        $this->dateUpdated = $dateUpdated;
    }


    // Getters
    public function getId() {
        return $this->id;
    }

    public function getCustomerRoleTypeId() {
        return $this->customerRoleTypeId;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getZip() {
        return $this->zip;
    }

    public function getEmailAddress() {
        return $this->emailAddress;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }

    public function getDateUpdated() {
        return $this->dateUpdated;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setCustomerRoleTypeId($customerRoleTypeId) {
        $this->customerRoleTypeId = $customerRoleTypeId;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }

    public function setEmailAddress($emailAddress) {
        $this->emailAddress = $emailAddress;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }

    public function setDateUpdated($dateUpdated) {
        $this->dateUpdated = $dateUpdated;
    }
}