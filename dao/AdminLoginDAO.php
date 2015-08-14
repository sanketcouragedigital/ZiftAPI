<?php
require_once 'BaseDAO.php';
class AdminLoginDAO 
{
    
    private $con;
    private $msg;
    
    // Attempts to initialize the database connection using the supplied info.
    public function AdminLoginDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function login($checkLogin){
        $sql="SELECT * FROM admin_login WHERE username='".$checkLogin->getUserName()."' and password='".$checkLogin->getPassword()."'";
        try{
            $login=mysqli_query($this->con,$sql);
            $count=mysqli_num_rows($login);
            if($count==1) {
                $this->msg = "LOGGED_IN";
            }
            else {
                $this->msg = "LOGIN_FAILED";
            }
        }
        catch (Exception $e){
            echo'SQL Exception:'.$e->getMessage();
        }
        return $this->msg;
    }
}
?>