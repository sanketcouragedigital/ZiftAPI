<?php

require_once 'BaseDAO.php';
class DealsDataDAO 
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function DealsDataDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
    public function saveDeals($deals) {
        //include_once ('db_config.php');
        try {
            if($deals->getLogoTemporaryName()=="") {
                $validUptoDate =  DateTime::createFromFormat('d/m/Y', $deals->getValidUptoDate())->format('Y-m-d');
                $sql = "INSERT INTO deals(companyName,offer,offerCode,validUptoDate,offerTerms,isVerify)VALUES
                ('".$deals->getCompanyName()."', '".$deals->getOffer()."', '".$deals->getOfferCode()."', '".$validUptoDate."', '".$deals->getOfferTerms()."', '".$deals->getIsVerify()."')";
        
                $isInserted = mysqli_query($this->con,$sql);
                if ($isInserted) {
                    $this->data = "DEAL_SAVED";
                } else {
                    $this->data = "ERROR";
                }
            }
            else if($deals->getLogoTemporaryName()!=="") {
            if(move_uploaded_file($deals->getLogoTemporaryName(), $deals->getTargetPathOfImage())) {
                $validUptoDate =  DateTime::createFromFormat('d/m/Y', $deals->getValidUptoDate())->format('Y-m-d');
                $sql = "INSERT INTO deals(image_path,companyName,offer,offerCode,validUptoDate,offerTerms,isVerify)VALUES
                ('".$deals->getTargetPathOfImage()."', '".$deals->getCompanyName()."', '".$deals->getOffer()."', '".$deals->getOfferCode()."', '".$validUptoDate."', '".$deals->getOfferTerms()."', '".$deals->getIsVerify()."')";
        
                $isInserted = mysqli_query($this->con,$sql);
                if ($isInserted) {
                    $this->data = "DEAL_SAVED";
                } else {
                    $this->data = "ERROR";
                }
            } else {
                $this->data = "ERROR";
            }
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
    
    public function showDeals() {
        $sql = "SELECT * FROM deals";
        
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
    
    public function deleteDeals($dealsRow) {
        $query="DELETE FROM deals WHERE offerCode = '".$dealsRow->getOfferCode()."'";
        
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