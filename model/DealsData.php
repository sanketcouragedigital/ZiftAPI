<?php
require_once '../dao/DealsDataDAO.php';
class DealsData
{
	private $logo_tmp;
    private $target_path;
    private $companyName;
    private $offer;
    private $offerCode;
    private $validUptoDate;
    private $offerTerms;

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

    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
    }
    
    public function getCompanyName() {
        return $this->companyName;
    }
    
    public function setOffer($offer) {
        $this->offer = $offer;
    }
    
    public function getOffer() {
        return $this->offer;
    }
    
    public function setOfferCode($offerCode) {
        $this->offerCode = $offerCode;
    }
    
    public function getOfferCode() {
        return $this->offerCode;
    }
    
    public function setValidUptoDate($validUptoDate) {
        $this->validUptoDate = $validUptoDate;
    }
    
    public function getValidUptoDate() {
        return $this->validUptoDate;
    }
    
    public function setOfferTerms($offerTerms) {
        $this->offerTerms = $offerTerms;
    }
    
    public function getOfferTerms() {
        return $this->offerTerms;
    }

    public function mapIncomingDealsParams($logo_tmp, $target_path, $companyName, $offer, $offerCode, $validUptoDate, $offerTerms) {
        $this->setLogoTemporaryName($logo_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setCompanyName($companyName);
        $this->setOffer($offer);
        $this->setOfferCode($offerCode);
        $this->setValidUptoDate($validUptoDate);
        $this->setOfferTerms($offerTerms);
    }

    public function saveDealsDetails() {
        $DealsDetailsDAO = new DealsDataDAO();
        $returnDealsSuccessMessage = $DealsDetailsDAO->saveDeals($this);
        return $returnDealsSuccessMessage;
    }
	
    public function showDealsDetails() {
        $showDealsDataDAO = new DealsDataDAO();
        $returnShowDealsDetails = $showDealsDataDAO->showDeals($this);
        return $returnShowDealsDetails;
    }
}
?>