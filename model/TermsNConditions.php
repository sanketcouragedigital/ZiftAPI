<?php
require_once '../dao/TermsNConditionsDAO.php';
class TermsNConditions
{
	private $City;
	private $Service_Type;

    
	public function setCity($City) {
		$this->City=$City;
	}
    
	public function getCity() {
		return $this->City;
	}
	public function setService_Type($Service_Type) {
		$this->Service_Type=$Service_Type;
	}
    
	public function getService_Type() {
		return $this->Service_Type;
	}

    
    public function showTermsNCondition($City,$Service_Type) {
        $objTermsNConditions = new TermsNConditionsDAO();
        $this->setCity($City);
		$this->setService_Type($Service_Type);
        $returnTnCSuccessMessage = $objTermsNConditions->termsNConditionOfTaxi($this);
        return $returnTnCSuccessMessage;
    }
	
}          
?>