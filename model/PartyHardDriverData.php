<?php
require_once '../dao/PartyHardDriverDataDAO.php';
class PartyHardDriverData
{
	private $logo_tmp;
    private $target_path;
    private $serviceName;
    private $mobileno;
    private $city;
    private $isVerify;

    public function setLogoTemporaryName($logo_tmp) {
        $this->logo_tmp = $logo_tmp;
    }
    
    public function getLogoTemporaryName() {
        return $this->logo_tmp;
    }

    public function setTargetPathOfImage($target_path) {
        $this->target_path = $target_path;
    }
    
    public function getTargetPathOfImage() {
        return $this->target_path;
    }

    public function setServiceName($serviceName) {
        $this->serviceName = $serviceName;
    }
    
    public function getServiceName() {
        return $this->serviceName;
    }

    public function setMobileNo($mobileno) {
        $this->mobileno = $mobileno;
    }
    
    public function getMobileNo() {
        return $this->mobileno;
    }
    
     public function setCity($city) {
        $this->city = $city;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function setIsVerify($isVerify) {
        $this->isVerify = $isVerify;
    }
    
    public function getIsVerify() {
        return $this->isVerify;
    }

    public function mapIncomingPHDParams($logo_tmp, $target_path, $serviceName, $mobileno, $city, $isVerify) {
        $this->setLogoTemporaryName($logo_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setServiceName($serviceName);
        $this->setMobileNo($mobileno);
        $this->setCity($city);
        $this->setIsVerify($isVerify);
    }

    public function savePHDDetails() {
        $PHDDetailsDAO = new PartyHardDriverDataDAO();
        $returnPHDSuccessMessage = $PHDDetailsDAO->savePHD($this);
        return $returnPHDSuccessMessage;
    }
	
    public function showPHDDetails() {
        $showPHDDataDAO = new PartyHardDriverDataDAO();
        $returnShowPHDDetails = $showPHDDataDAO->showPHD($this);
        return $returnShowPHDDetails;
    }
}
?>