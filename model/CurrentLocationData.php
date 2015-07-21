<?php
require_once '../dao/currentLocationDataDAO.php';
class CurrentLocationData
{
    private $mobileno;
    private $latitude;
    private $longitude;
    private $area;
    
    public function setMobileNo($mobileno) {
        $this->mobileno = $mobileno;
    }
    
    public function getMobileNo() {
        return $this->mobileno;
    }
    
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }
    
    public function getLatitude() {
        return $this->latitude;
    }
    
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }
    
    public function getLongitude() {
        return $this->longitude;
    }
    
    public function setArea($area) {
        $this->area = $area;
    }
    
    public function getArea() {
        return $this->area;
    }
    
    public function mapIncomingParams($mobileno,$latitude,$longitude,$area) {
        $this->setMobileNo($mobileno);
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->setArea($area);
    }
    
    public function locationData(){
        $currentLocationDataDAO = new CurrentLocationDataDAO();
        $returnSuccessMessage = $currentLocationDataDAO->check($this);
        return $returnSuccessMessage;
    }
}          
?>