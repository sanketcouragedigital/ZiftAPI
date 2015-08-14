<?php

require_once 'BaseDAO.php';
class DriverDetailsDataDAO 
{
    
    private $con;
    private $msg;
    
    // Attempts to initialize the database connection using the supplied info.
    public function DriverDetailsDataDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    //Insert the supplied driver details to the database.
    public function register($driverDetail) {
        //include_once ('db_config.php');
        $sql = "INSERT INTO driver_details(name,mobileno,taxino,isVerify)VALUES('".$driverDetail->getName()."', '".$driverDetail->getMobileNo()."', '".$driverDetail->getTaxiNo()."', '".$driverDetail->getIsVerify()."')";
        
        try {
            $isInserted = mysqli_query($this->con,$sql);
            if ($isInserted) {
                $this->msg = "DRIVER_DETAILS_SAVED";
            } else {
                $this->msg = "ERROR";
            } 
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->msg;
    }
    
    public function check($checkDetail) {
        $query = "SELECT mobileno FROM driver_details WHERE mobileno = '".$checkDetail->getOldMobileNo()."' ";
        $result = mysqli_query($this->con, $query);
        if (mysqli_num_rows($result)>0){
            $this->msg = $this->update($checkDetail);
        } else {
            $this->msg = "ERROR_MOBILE_NO";
        }
        return $this->msg;
    }
    
    //Updates the Driver Location Entry
    public function update($updateDetail) {
        if($updateDetail->getMobileNo()!=="" && $updateDetail->getTaxiNo()!=="") {
            $query="UPDATE driver_details SET mobileno='".$updateDetail->getMobileNo()."', taxino='".$updateDetail->getTaxiNo()."' WHERE mobileno='".$updateDetail->getOldMobileNo()."' ";
            $update=mysqli_query($this->con,$query);
        }
        else if($updateDetail->getTaxiNo()!=="") {
            $query="UPDATE driver_details SET taxino='".$updateDetail->getTaxiNo()."' WHERE mobileno='".$updateDetail->getOldMobileNo()."' ";
            $update=mysqli_query($this->con,$query);
        }
        else if($updateDetail->getMobileNo()!=="") {
            $query="UPDATE driver_details SET mobileno='".$updateDetail->getMobileNo()."' WHERE mobileno='".$updateDetail->getOldMobileNo()."' ";
            $update=mysqli_query($this->con,$query);
        }
        else {
            $update=false;
        }
        
        try {
            
            if($update==true){
                $this->msg = "DRIVER_DETAILS_UPDATED";
            }
            else {
                $this->msg = "ERROR";
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->msg;
    }
}
?>