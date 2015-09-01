<?php

require_once 'BaseDAO.php';
class OutStationCityLoadDAO 
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function OutStationCityLoadDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
	
	public function outStationCity(){
		$sql="SELECT city_name FROM tblcitylist ORDER BY city_name";
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
}
?>