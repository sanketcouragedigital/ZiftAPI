<?php
require_once '../dao/NearestDriverDataDAO.php';
class NearestDriverData
{
	private $latitude;
    private $longitude;

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

    public function findNearestDrivers($userLatitude, $userLongitude) {
        $nearestDriverLocationDataDAO = new NearestDriverDataDAO();
        $this->setLatitude($userLatitude);
        $this->setLongitude($userLongitude);
        $returnNearestDriversData = $nearestDriverLocationDataDAO->find($this);
        return $returnNearestDriversData;
    }
	
}
?>