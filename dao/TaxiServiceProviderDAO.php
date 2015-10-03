<?php

require_once 'BaseDAO.php';
class TaxiServiceProviderDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function TaxiServiceProviderDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
            
    public function saveTaxiServiceDetails($TaxiServiceDetails) {
        try{
            if(move_uploaded_file($TaxiServiceDetails->getLogoTemporaryName(), $TaxiServiceDetails->getTargetPathOfImage())) {
                $query="INSERT INTO cheapest_ride_service(Owner, Service_Type, logo, Fleet, app_link, Terms_n_Conditions)
                    VALUES ('".$TaxiServiceDetails->getOwner()."',
                    '".$TaxiServiceDetails->getServiceType()."',
                    '".$TaxiServiceDetails->getTargetPathOfImage()."',
                    '".$TaxiServiceDetails->getFleet()."',
                    '".$TaxiServiceDetails->getAppLink()."',
                    '".$TaxiServiceDetails->getTermsAndConditions()."'
                    )";
                $isInserted = mysqli_query($this->con, $query);
                if ($isInserted) {
                    $this->data = "TAXI_SERVICE_SAVED";
                } else {
                    $this->data = "ERROR";
                }
            } else {
                $this->data = "ERROR";
            }
        }
        catch(Exception $e) {   
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

    public function showTaxiServiceTypes(){
        $sql="SELECT * FROM cheapest_ride_service";
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