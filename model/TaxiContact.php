<?php
require_once '../dao/TaxiContactDAO.php';
class TaxiContact
{
	
    public function showTaxiContact() {
        $showTaxiContactDAO = new TaxiContactDAO();
        $returnShowTaxiContact = $showTaxiContactDAO->showTaxiContactDetails($this);
        return $returnShowTaxiContact;
    }
}
?>