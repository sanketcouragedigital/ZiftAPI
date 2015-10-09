<?php
require_once '../dao/IndexPageCityLoadDAO.php';
class IndexPageCityLoad
{

	public function loadCity(){
		$LoadCityDAO=new IndexPageCityLoadDAO();
		$returnLoadCitySuccessMessage =$LoadCityDAO -> loadCity();
		return $returnLoadCitySuccessMessage;
	}
}          
?>