<?php

require_once 'BaseDAO.php';
class DriverLoginRegisterDataDAO 
{
    
    private $con;
    private $msg;
    
    // Attempts to initialize the database connection using the supplied info.
    public function DriverLoginRegisterDataDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    //Insert the supplied driver details to the database.
    public function register($driverDetail) {
        //include_once ('db_config.php');
        $sql = "INSERT INTO driver_details(name,mobileno,taxino,password,isVerify)VALUES('".$driverDetail->getName()."', '".$driverDetail->getMobileNo()."', '".$driverDetail->getTaxiNo()."', '".$driverDetail->getPassword()."', '".$driverDetail->getIsVerify()."')";
        
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
        
    //Selects the Driver Location Entry
    public function login($loginDetail) {
        $query="SELECT * FROM driver_details WHERE mobileno='".$loginDetail->getMobileNo()."' and password='".$loginDetail->getPassword()."'";
        
        try {
        $login=mysqli_query($this->con,$query);
        $count=mysqli_num_rows($login);
            if($count==1){
                $this->msg = "LOGGED_IN";
            }
            else {
                $this->msg = "LOGIN_FAILED";
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->msg;
    }
}
?>