<?php
require_once '../dao/TaxiServiceProviderDAO.php';
class TaxiServiceProvider
{
    private $logo_tmp;
    private $target_path;
    private $owner;
    private $serviceType;
    private $fleet;
    private $appLink;
    private $termsAndConditions;
    
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
    
    public function setFleet($fleet) {
        $this->fleet = $fleet;
    }
    
    public function getFleet() {
        return $this->fleet;
    }
    
    public function setAppLink($appLink) {
        $this->appLink = $appLink;
    }
    
    public function getAppLink() {
        return $this->appLink;
    }
    
    public function setTermsAndConditions($termsAndConditions) {
        $this->termsAndConditions = $termsAndConditions;
    }
    
    public function getTermsAndConditions() {
        return $this->termsAndConditions;
    }
    
    public function mapIncomingTaxiServiceProviderParams($logo_tmp, $target_path, $owner, $serviceType, $fleet, $appLink, $termsAndConditions) {
        $this->setLogoTemporaryName($logo_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setOwner($owner);
        $this->setServiceType($serviceType);
        $this->setFleet($fleet);
        $this->setAppLink($appLink);
        $this->setTermsAndConditions($termsAndConditions);
    }
    
    public function saveTaxiServiceProvider() {
        $saveTaxiServiceProviderDAO = new TaxiServiceProviderDAO();
        $returnShowTaxiServiceProvider = $saveTaxiServiceProviderDAO->saveTaxiServiceDetails($this);
        return $returnShowTaxiServiceProvider;
    }
    
    public function loadTaxiServiceType() {
        $showTaxiServiceProviderTypeDAO = new TaxiServiceProviderDAO();
        $returnShowTaxiServiceProvider = $showTaxiServiceProviderTypeDAO->showTaxiServiceTypes($this);
        return $returnShowTaxiServiceProvider;
    }
}
?>