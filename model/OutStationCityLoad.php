<?php
require_once '../dao/OutStationCityLoadDAO.php';
class OutStationCityLoad
{
	public function outStationLoadCity(){
		$outStationCityLoadDAO=new OutStationCityLoadDAO();
		$returnLoadCitySuccessMessage =$outStationCityLoadDAO -> outStationCity();
		return $returnLoadCitySuccessMessage;
	}
}          
?>