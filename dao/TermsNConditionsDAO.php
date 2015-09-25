<?php

require_once 'BaseDAO.php';
class TermsNConditionsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function TermsNConditionsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
	
	public function termsNConditionOfTaxi($cityNservice_type){
        $sql="SELECT crc.City,crc.Service_Type,crc.Contact,crc.Day_Cost,crc.Night_Cost,crc.Day_perKM,crc.Night_perKM,crc.First_x_KM,crc.per_minute_rate,crc.Waiting_Charges_Day,crc.Waiting_Charges_Night,crc.Minimum_Rates,crs.logo,crs.Terms_n_Conditions
                FROM cheapest_ride_citywise crc
                INNER JOIN cheapest_ride_service crs
                ON crc.Service_Type = crs.Service_Type
                WHERE City='".$cityNservice_type->getCity()."' 
				AND crc.Service_Type='".$cityNservice_type->getService_Type()."' ";
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