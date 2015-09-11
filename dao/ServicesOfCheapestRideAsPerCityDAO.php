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
        $sql="SELECT * FROM cheapest_ride_citywise
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