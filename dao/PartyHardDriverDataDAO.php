<?php

require_once 'BaseDAO.php';
class PartyHardDriverDataDAO 
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function PartyHardDriverDataDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
            
    public function savePHD($PHDDetails) {
        try{
            if($PHDDetails->getLogoTemporaryName()=="") {
                $query="INSERT INTO phd_details(serviceName, mobileno, city, isVerify, date)VALUES
                ('".$PHDDetails->getServiceName()."','".$PHDDetails->getMobileNo()."','".$PHDDetails->getCity()."','".$PHDDetails->getIsVerify()."', UTC_TIMESTAMP())";
                $isInserted = mysqli_query($this->con, $query);
                if ($isInserted) {
                    $this->data = "PHD_DETAILS_SAVED";
                } else {
                    $this->data = "ERROR";
                }
            }
            else if($PHDDetails->getLogoTemporaryName()!=="") { 
                if(move_uploaded_file($PHDDetails->getLogoTemporaryName(), $PHDDetails->getTargetPathOfImage())) {
                    $query="INSERT INTO phd_details(image_path, serviceName, mobileno, city, isVerify, date)VALUES
                    ('".$PHDDetails->getTargetPathOfImage()."','".$PHDDetails->getServiceName()."','".$PHDDetails->getMobileNo()."','".$PHDDetails->getCity()."','".$PHDDetails->getIsVerify()."', UTC_TIMESTAMP())";
                    $isInserted = mysqli_query($this->con, $query);
                    if ($isInserted) {
                        $this->data = "PHD_DETAILS_SAVED";
                    } else {
                        $this->data = "ERROR";
                    }
                } else {
                    $this->data = "ERROR";
                }
            }
        }
        catch(Exception $e) {   
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

    public function showPHD($City) {
        $sql = "SELECT * FROM phd_details 
				WHERE City='".$City->getCity()."'
				ORDER BY date DESC";
        
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
    
    public function showAllPHD() {
        $sql = "SELECT * FROM phd_details 
                ORDER BY date DESC";
        
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
    
    public function deletePHD($phdRow) {
        $query="DELETE FROM phd_details WHERE mobileno = '".$phdRow->getMobileNo()."'";
        
        try{
            $delete=mysqli_query($this->con,$query);
            if($delete){
                $this->data = array("result" => 1, "message" => "Successfully service deleted!");
                if($phdRow->getTargetPathOfImage()!=="default_image.png") {
                    unlink($phdRow->getTargetPathOfImage());
                }
            } else {
                $this->data = array("result" => 0, "message" => "Error!");
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
    
    public function verifyPHD($phdIsVerify) {
        $query="UPDATE phd_details SET isVerify = '".$phdIsVerify->getIsVerify()."' WHERE mobileno = '".$phdIsVerify->getMobileNo()."'";
        
        try{
            $delete=mysqli_query($this->con,$query);
            if($delete){
                $this->data = array("result" => 1, "message" => "Successfully service verified!");
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