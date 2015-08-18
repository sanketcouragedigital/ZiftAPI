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
        $sql="SELECT sdc.carMake,sdc.hourlyWeekdayRate,sdc.hourlyWeekendRate,sdc.dailyWeekdayRate,sdc.dailyWeekendRate,sdc.weeklyRate,sdc.monthlyRate,sdc.extraChargePerKm,sdc.deposit,sdc.city,sp.serviceProviderName,sp.serviceByHourly
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
	
	public function addServiceProvider($service_provider){
	    try{
            if($service_provider->getLogoTemporaryName()=="") {
                $query="INSERT INTO service_provider(serviceProviderName, type, serviceByHourly)VALUES
                ('".$service_provider->getServiceProviderName()."','".$service_provider->getServiceProviderType()."','".$service_provider->getServiceByHourly()."')";
                $isInserted = mysqli_query($this->con, $query);
                if ($isInserted) {
                    $this->data = "SERVICE_PROVIDER_SAVED";
                } else {
                    $this->data = "ERROR";
                }
            }
            else if($service_provider->getLogoTemporaryName()!=="") { 
                if(move_uploaded_file($service_provider->getLogoTemporaryName(), $service_provider->getTargetPathOfImage())) {
                    $query="INSERT INTO service_provider(image_path, serviceProviderName, type, serviceByHourly)VALUES
                    ('".$service_provider->getTargetPathOfImage()."','".$service_provider->getServiceProviderName()."','".$service_provider->getServiceProviderType()."','".$service_provider->getServiceByHourly()."')";
                    $isInserted = mysqli_query($this->con, $query);
                    if ($isInserted) {
                        $this->data = "SERVICE_PROVIDER_SAVED";
                    } else {
                        $this->data = "ERROR";
                    }
                } else {
                    $this->data = "ERROR";
                }
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
	}

    public function fetchServiceProvider(){
        $sql="SELECT * FROM service_provider";
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
    
    public function deleteServiceProvider($delete_service_provider){
        $query="DELETE FROM service_provider WHERE serviceProviderName = '".$delete_service_provider->getServiceProviderName()."'";
        
        try{
            $delete=mysqli_query($this->con,$query);
            if($delete){
                $this->data = array("result" => 1, "message" => "Successfully service provider deleted!");
                if($delete_service_provider->getTargetPathOfImage()!=="default_image.png") {
                    unlink($delete_service_provider->getTargetPathOfImage());
                }
            } else {
                $this->data = array("result" => 0, "message" => "Error!");
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
}
?>