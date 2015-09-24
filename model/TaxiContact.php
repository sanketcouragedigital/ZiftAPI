<?php
require_once '../dao/TaxiContactDAO.php';
class TaxiContact
{
	private $City;

    
	public function setCity($City) {
		$this->City=$City;
	}
    
	public function getCity() {
		return $this->City;
	}
	
    public function showTaxiContact($City) {
        $showTaxiContactDAO = new TaxiContactDAO();
		$this->setCity($City);
        $returnShowTaxiContact = $showTaxiContactDAO->showTaxiContactDetails($this);
        return $returnShowTaxiContact;
    }
}
?>