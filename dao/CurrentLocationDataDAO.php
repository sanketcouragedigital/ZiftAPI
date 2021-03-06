<?php

require_once 'BaseDAO.php';
class CurrentLocationDataDAO 
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function CurrentLocationDataDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    //Checks the supplied user is already exists in database or not.
    public function check($contact) {
        $query = "SELECT mobileno FROM driver_location WHERE mobileno = '".$contact->getMobileNo()."' ";
        $result = mysqli_query($this->con, $query);
        if (mysqli_num_rows($result)>0){
            $this->msg = $this->update($contact);
        } else {
            $this->msg = $this->save($contact);
        }
        return $this->msg;
    }
    
    //Saves the supplied user to the database.
    public function save($contact) {
        //include_once ('db_config.php');
        $sql = "INSERT INTO driver_location(mobileno,latitude,longitude,location_area)VALUES('".$contact->getMobileNo()."', '".$contact->getLatitude()."', '".$contact->getLongitude()."', '".$contact->getArea()."')";
        
        try {
            $isInserted = mysqli_query($this->con,$sql);
            if ($isInserted) {
                $this->msg = "LOCATION_SAVED";
            } else {
                $this->msg = "ERROR";
            } 
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->msg;
    }
    
    //Updates the supplied data of the user in the database.
    public function update($contact) {
        //include_once ('db_config.php');
        $sql = "UPDATE driver_location SET latitude='".$contact->getLatitude()."', longitude='".$contact->getLongitude()."', location_area='".$contact->getArea()."' WHERE mobileno='".$contact->getMobileNo()."' ";
        
        try {
            $isUpdated = mysqli_query($this->con,$sql);
            if ($isUpdated) {
                $this->msg = "LOCATION_UPDATED";
            } else {
                $this->msg = "ERROR";
            } 
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->msg;
    }
    
    //Deletes the Driver Location Entry
    public function delete($deleteEntry) {
        $query="DELETE FROM driver_location WHERE mobileno = '".$deleteEntry->getMobileNo()."'";
        
        try{
            $delete=mysqli_query($this->con,$query);
            if($delete){
                $this->msg = array("result" => 1, "message" => "Successfully user deleted!");
            } else {
                $this->msg = array("result" => 0, "message" => "Error!");
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->msg;
    }
}
?>