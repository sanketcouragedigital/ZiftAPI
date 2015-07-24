<?php
require_once '../dao/DriverLoginRegisterDataDAO.php';
class DriverLoginRegisterData
{
    private $name;
    private $mobileno;
    private $taxino;
    private $password;
    private $isVerify;
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setMobileNo($mobileno) {
        $this->mobileno = $mobileno;
    }
    
    public function getMobileNo() {
        return $this->mobileno;
    }
    
    public function setTaxiNo($taxino) {
        $this->taxino = $taxino;
    }
    
    public function getTaxiNo() {
        return $this->taxino;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setIsVerify($isVerify) {
        $this->area = $isVerify;
    }
    
    public function getIsVerify() {
        return $this->area;
    }
    
    public function mapIncomingParams($name, $mobileno, $taxino, $password, $isVerify) {
        $this->setName($name);
        $this->setMobileNo($mobileno);
        $this->setTaxiNo($taxino);
        $this->setPassword($password);
        $this->setIsVerify($isVerify);
    }
    
    public function driverRegisterData(){
        $driverRegisterDataDAO = new DriverLoginRegisterDataDAO();
        $returnRegisterMessage = $driverRegisterDataDAO->register($this);
        return $returnRegisterMessage;
    }
    
    public function deleteLocationEntry($mobileno) {
        $currentLocationDataDAO = new CurrentLocationDataDAO();
        $this->setMobileNo($mobileno);
        $returnDeleteMessage = $currentLocationDataDAO->delete($this);
        return $returnDeleteMessage;
    }
}          
?>