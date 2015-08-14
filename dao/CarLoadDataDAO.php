<?php

require_once 'BaseDAO.php';
class CarLoadDataDAO 
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function CarLoadDataDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
	
	public function loadCars($cars){
		$sql="SELECT DISTINCT carMake FROM self_drive_car WHERE carType='".$cars->getSelectedTypeOfCar()."' ";
		try{
			$select= mysqli_query($this->con,$sql);
			$this->data=array();
			while($rowdata=mysqli_fetch_assoc($select)){
				$this->data[]=$rowdata;			
			}
		}
		catch (Exception $e){
			echo'SQL Exception:'.$e->getMessage();
		}
		return $this->data;
	}
	public function selfdrivecar($carMake){
		$sql="SELECT  sdc.carMake,sdc.hourlyWeekdayRate,sdc.hourlyWeekendRate,sdc.dailyWeekdayRate,sdc.dailyWeekendRate,sdc.extraChargePerKm,sdc.deposit,sp.serviceProviderName,sp.serviceByHourly
				FROM self_drive_car sdc
				INNER JOIN service_provider sp
				ON sdc.serviceProviderType=sp.type
				WHERE carMake='".$carMake->getCarMake()."' ";
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