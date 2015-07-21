<?php
class BaseDAO {
    
    
    private $db_host = 'localhost'; //hostname
    private $db_user = 'root'; // username
    private $db_password = ''; // password
    private $db_name = 'taxiapp'; //database name
    private $con = null;
    
    
    public function getConnection() {
        $this->con=mysqli_connect($this->db_host,$this->db_user,$this->db_password,$this->db_name) or die("Failed to connect to MySQL:".mysql_error());

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        return $this->con;
    }
}
?>