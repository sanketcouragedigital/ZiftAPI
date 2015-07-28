<?php

require_once 'BaseDAO.php';
class UserReviewDataDAO 
{
    
    private $con;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function UserReviewDataDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
     
    //Saves the supplied user to the database.
    public function save($review) {
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
    
    //Updates the supplied data of the user in the database.
    public function show($reviewByServiceName) {
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