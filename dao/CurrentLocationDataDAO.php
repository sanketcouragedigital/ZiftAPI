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
    
    //Find the nearest drivers from the database.
    public function find($latlong) {
        $query="SELECT dd.name, dd.taxino, dd.mobileno, dd.isVerify, ( 3959 * acos( cos( radians('".$latlong->getLatitude()."') ) * cos( radians( dl.latitude ) ) * cos( radians( dl.longitude ) - radians('".$latlong->getLongitude()."') ) + sin( radians('".$latlong->getLatitude()."') ) * sin( radians( dl.latitude ) ) ) ) * 1.609344 AS distance
                FROM driver_details dd
                INNER JOIN driver_location dl
                ON dd.mobileno = dl.mobileno
                HAVING distance < 5 ORDER BY distance";
        
        try {
            $select=mysqli_query($this->con,$query);
            $this->getDriverLocationAndDetails=array();
            while ($rowdata = mysqli_fetch_assoc($select)) {
                $this->getDriverLocationAndDetails[]=$rowdata;
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->getDriverLocationAndDetails;
    }
    
    //Save the review of user from the database.
    public function saveReview($review) {
        //include_once ('db_config.php');
        
        $sql = "INSERT INTO user_reviews(serviceName,rating,comment,date)VALUES('".$review->getServiceName()."', '".$review->getRatingNumber()."', '".$review->getComment()."', UTC_TIMESTAMP() )";
        
        try {
            $isInserted = mysqli_query($this->con,$sql);
            if ($isInserted) {
                $this->data = "REVIEW_SAVED";
            } else {
                $this->data = "ERROR";
            } 
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
    
    //Show the review of users from the database.
    public function showReview($reviewByServiceName) {
        //include_once ('db_config.php');
        $sql = "SELECT * FROM user_reviews WHERE serviceName='".$reviewByServiceName->getServiceName()."' ORDER BY date DESC";
        
        try {
            $select = mysqli_query($this->con,$sql);
            $this->data=array();
            while ($rowdata = mysqli_fetch_assoc($select)) {
                $this->data[]=$rowdata;
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
}
?>