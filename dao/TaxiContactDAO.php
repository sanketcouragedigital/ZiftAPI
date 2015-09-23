<?php

require_once 'BaseDAO.php';
class TaxiContactDAO 
{
	private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function TaxiContactDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
     public function showTaxiContactDetails() {
        $sql = "SELECT DISTINCT crc.Contact,crs.Owner,crs.logo
                FROM cheapest_ride_citywise crc
                INNER JOIN chipeast_ride_service crs
                ON crc.Service_Type = crs.Service_Type";
        
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
