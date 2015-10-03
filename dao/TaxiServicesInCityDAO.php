<?php

require_once 'BaseDAO.php';
class TaxiServicesInCityDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function TaxiServicesInCityDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
            
    public function saveTaxiInCityDetails($TaxiInCityDetails) {
        try{
            $query="INSERT INTO cheapest_ride_citywise(City, Contact, Service_Type, First_x_KM, Day_Cost, Night_Cost, Day_perKM, Night_perKM, per_minute_rate, Waiting_Charges_Day, Waiting_Charges_Night, Minimum_Rates)
            VALUES ('".$TaxiInCityDetails->getCity()."',
                '".$TaxiInCityDetails->getContact()."',
                '".$TaxiInCityDetails->getServiceType()."',
                '".$TaxiInCityDetails->getFirstXKM()."',
                '".$TaxiInCityDetails->getDayCost()."',
                '".$TaxiInCityDetails->getNightCost()."',
                '".$TaxiInCityDetails->getDayCostPerKM()."',
                '".$TaxiInCityDetails->getNightCostPerKM()."',
                '".$TaxiInCityDetails->getPerMinuteRate()."',
                '".$TaxiInCityDetails->getDayWaitingCharges()."',
                '".$TaxiInCityDetails->getNightWaitingCharges()."',
                '".$TaxiInCityDetails->getMinimumRatesOfTaxi()."'
            )";
            $isInserted = mysqli_query($this->con, $query);
            if ($isInserted) {
                $this->data = "TAXI_SERVICE_IN_CITY_SAVED";
            } else {
                $this->data = "ERROR";
            }
        }
        catch(Exception $e) {   
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
}
?>