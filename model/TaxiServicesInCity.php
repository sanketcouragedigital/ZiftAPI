<?php
require_once '../dao/TaxiServicesInCityDAO.php';
class TaxiServicesInCity
{
    private $city;
    private $contact;
    private $serviceType;
    private $firstXKM;
    private $dayCost;
    private $nightCost;
    private $dayCostPerKM;
    private $nightCostPerKM;
    private $perMinuteRate;
    private $dayWaitingCharges;
    private $nightWaitingCharges;
    private $minimumRatesOfTaxi;
    
    public function setCity($city) {
        $this->city = $city;
    }
    
    public function getCity() {
        return $this->city;
    }

    public function setContact($contact) {
        $this->contact = $contact;
    }
    
    public function getContact() {
        return $this->contact;
    }

    public function setServiceType($serviceType) {
        $this->serviceType = $serviceType;
    }
    
    public function getServiceType() {
        return $this->serviceType;
    }
    
    public function setFirstXKM($firstXKM) {
        $this->firstXKM = $firstXKM;
    }
    
    public function getFirstXKM() {
        return $this->firstXKM;
    }
    
    public function setDayCost($dayCost) {
        $this->dayCost = $dayCost;
    }
    
    public function getDayCost() {
        return $this->dayCost;
    }
    
    public function setNightCost($nightCost) {
        $this->nightCost = $nightCost;
    }
    
    public function getNightCost() {
        return $this->nightCost;
    }
    
    public function setDayCostPerKM($dayCostPerKM) {
        $this->dayCostPerKM = $dayCostPerKM;
    }
    
    public function getDayCostPerKM() {
        return $this->dayCostPerKM;
    }
    
    public function setNightCostPerKM($nightCostPerKM) {
        $this->nightCostPerKM = $nightCostPerKM;
    }
    
    public function getNightCostPerKM() {
        return $this->nightCostPerKM;
    }
    
    public function setPerMinuteRate($perMinuteRate) {
        $this->perMinuteRate = $perMinuteRate;
    }
    
    public function getPerMinuteRate() {
        return $this->perMinuteRate;
    }
    
    public function setDayWaitingCharges($dayWaitingCharges) {
        $this->dayWaitingCharges = $dayWaitingCharges;
    }
    
    public function getDayWaitingCharges() {
        return $this->dayWaitingCharges;
    }
    
    public function setNightWaitingCharges($nightWaitingCharges) {
        $this->nightWaitingCharges = $nightWaitingCharges;
    }
    
    public function getNightWaitingCharges() {
        return $this->nightWaitingCharges;
    }
    
    public function setMinimumRatesOfTaxi($minimumRatesOfTaxi) {
        $this->minimumRatesOfTaxi = $minimumRatesOfTaxi;
    }
    
    public function getMinimumRatesOfTaxi() {
        return $this->minimumRatesOfTaxi;
    }
    
    public function mapIncomingTaxiServicesInCityParams($city, $contact, $serviceType, $firstXKM, $dayCost, $nightCost, $dayCostPerKM, $nightCostPerKM, $perMinuteRate, $dayWaitingCharges, $nightWaitingCharges, $minimumRatesOfTaxi) {
        $this->setCity($city);
        $this->setContact($contact);
        $this->setServiceType($serviceType);
        $this->setFirstXKM($firstXKM);
        $this->setDayCost($dayCost);
        $this->setNightCost($nightCost);
        $this->setDayCostPerKM($dayCostPerKM);
        $this->setNightCostPerKM($nightCostPerKM);
        $this->setPerMinuteRate($perMinuteRate);
        $this->setDayWaitingCharges($dayWaitingCharges);
        $this->setNightWaitingCharges($nightWaitingCharges);
        $this->setMinimumRatesOfTaxi($minimumRatesOfTaxi);
    }
    
    public function saveTaxiServicesInCity() {
        $saveTaxiServicesInCityDAO = new TaxiServicesInCityDAO();
        $returnShowTaxiServicesInCity = $saveTaxiServicesInCityDAO->saveTaxiInCityDetails($this);
        return $returnShowTaxiServicesInCity;
    }
}
?>