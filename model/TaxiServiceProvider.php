<?php
require_once '../dao/TaxiServiceProviderDAO.php';
class TaxiServiceProvider
{
    private $logo_tmp;
    private $target_path;
    private $owner;
    private $serviceType;
    
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
    
    public function setOwner($owner) {
        $this->owner = $owner;
    }
    
    public function getOwner() {
        return $this->owner;
    }

    public function setServiceType($serviceType) {
        $this->serviceType = $serviceType;
    }
    
    public function getServiceType() {
        return $this->serviceType;
    }
    
    public function mapIncomingTaxiServiceProviderParams($logo_tmp, $target_path, $owner, $serviceType) {
        $this->setLogoTemporaryName($logo_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setOwner($owner);
        $this->setServiceType($serviceType);
    }
    
    public function saveTaxiServiceProvider() {
        $showTaxiServiceProviderDAO = new TaxiServiceProviderDAO();
        $returnShowTaxiServiceProvider = $showTaxiServiceProviderDAO->showTaxiServiceDetails($this);
        return $returnShowTaxiServiceProvider;
    }
}
?>