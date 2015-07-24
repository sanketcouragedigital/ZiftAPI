<?php

require_once 'BaseDAO.php';
class DriverLoginRegisterDataDAO 
{
    
    private $con;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function DriverLoginRegisterDataDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    //Saves the supplied user to the database.
    public function register($contact) {
        //include_once ('db_config.php');
        $sql = "INSERT INTO driver_details(name,mobileno,taxino,password,isVerify)VALUES('".$contact->getName()."', '".$contact->getMobileNo()."', '".$contact->getTaxiNo()."', '".$contact->getPassword()."', '".$contact->getIsVerify()."')";
        
        try {
            $isInserted = mysqli_query($this->con,$sql);
            if ($isInserted) {
                $this->data = "DRIVER_DETAILS_SAVED";
            } else {
                $this->data = "ERROR";
            } 
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
    
    //Updates the supplied data of the user in the database.
    public function update($contact) {
        //include_once ('db_config.php');
        $sql = "UPDATE driver_location SET latitude='".$contact->getLatitude()."', longitude='".$contact->getLongitude()."', location_area='".$contact->getArea()."' WHERE mobileno='".$contact->getMobileNo()."' ";
        
        try {
            $isUpdated = mysqli_query($this->con,$sql);
            if ($isUpdated) {
                $this->data = "LOCATION_UPDATED";
            } else {
                $this->data = "ERROR";
            } 
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
    
    //Deletes the Driver Location Entry
    public function delete($deleteEntry) {
        $query="DELETE FROM driver_location WHERE mobileno = '".$deleteEntry->getMobileNo()."'";
        
        try{
            $delete=mysqli_query($this->con,$query);
            if($delete){
                $this->data = array("result" => 1, "message" => "Successfully user deleted!");
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