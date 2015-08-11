<?php
require_once '../dao/CarLoadDataDAO.php';
class CarLoadData
{
	private $selectedTypeOfCar;
	private $carMake;
	
	public function setSelectedTypeOfCar($selectedTypeOfCar){
		$this -> selectedTypeOfCar=$selectedTypeOfCar;
	}
	public function getSelectedTypeOfCar(){
		return $this->selectedTypeOfCar;
	}
	public function setCarMake($carMake){
		$this->carMake=$carMake;
	}
	public function getCarMake(){
		return $this->carMake;
	}
	
	public function loadCarsDetails($selectedTypeOfCar){
		$this ->setSelectedTypeOfCar($selectedTypeOfCar);
		$LoadCarsDetailsDAO = new CarLoadDataDAO();
        $returnLoadCarsSuccessMessage = $LoadCarsDetailsDAO->loadCars($this);
        return $returnLoadCarsSuccessMessage;
	}
	
	public function mapIncomingSelfdrivecarParams($carMake){
		$this->setCarMake($carMake);
	}
	
	public function saveSelfdrivecarDetails() {
		$SelfdrivecarDetailsDAO = new CarLoadDataDAO();
        $returnSelfdrivecarSuccessMessage = $SelfdrivecarDetailsDAO->selfdrivecar($this);
        return $returnSelfdrivecarSuccessMessage;
	}
}          
?>