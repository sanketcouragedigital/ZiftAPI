<?php
require_once '../dao/ServicesOfCheapestRideAsPerCityDAO.php';
class ServicesOfCheapestRideAsPerCity
{
	private $City;

    
	public function setCity($City) {
		$this->City=$City;
	}
    
	public function getCity() {
		return $this->City;
	}

    
    public function showCheapestRideAsPerCity($City) {
        $objServicesOfCheapestRideAsPerCityDAO = new ServicesOfCheapestRideAsPerCityDAO();
        $this->setCity($City);
        $returnCheapestRideSuccessMessage = $objServicesOfCheapestRideAsPerCityDAO->ServicesOfCheapestRides($this);
        return $returnCheapestRideSuccessMessage;
    }
	
}          
?>