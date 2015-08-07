<?php
require_once 'BaseDAO.php';
class NearestDriverDataDAO 
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function NearestDriverDataDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
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
}
?>