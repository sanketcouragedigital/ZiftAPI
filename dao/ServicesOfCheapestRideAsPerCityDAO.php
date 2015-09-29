<?php

require_once 'BaseDAO.php';
class ServicesOfCheapestRideAsPerCityDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function ServicesOfCheapestRideAsPerCityDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
	
	public function ServicesOfCheapestRides($City){
        $sql="SELECT crc.City,crc.Service_Type,crc.Contact,crc.First_x_KM,crc.Day_Cost,crc.Night_Cost,crc.Day_perKM,crc.Night_perKM,crc.Waiting_Charges_Day,crc.Waiting_Charges_Night,crc.per_minute_rate,crc.Minimum_Rates,crs.logo,crs.app_link,crs.Terms_n_Conditions
                FROM cheapest_ride_citywise crc
                INNER JOIN cheapest_ride_service crs
                ON crc.Service_Type = crs.Service_Type
                WHERE City='".$City->getCity()."' ";
        try{
            $select=mysqli_query($this->con,$sql);
            $this->data=array();
            while($rowdata=mysqli_fetch_assoc($select)){
                $this->data[]=$rowdata;         
            }
        }
        catch(Exception $e){
            echo'SQL Exception:'.$e->getMessage();  
        }
        return $this->data;
    }
	
	
}
?>