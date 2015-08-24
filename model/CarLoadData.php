<?php
require_once '../dao/CarLoadDataDAO.php';
class CarLoadData
{
	private $selectedTypeOfCar;
	private $carMake;
    private $logo_tmp;
    private $target_path;
    private $serviceProviderName;
    private $serviceProviderType;
    private $serviceByHourly;
	private $selectedCity;
	
	public function setSelectedTypeOfCar($selectedTypeOfCar) {
		$this -> selectedTypeOfCar=$selectedTypeOfCar;
	}
    
	public function getSelectedTypeOfCar() {
		return $this->selectedTypeOfCar;
	}
	public function setSelectedCity($selectedCity) {
		$this -> selectedCity=$selectedCity;
	}
    
	public function getSelectedCity() {
		return $this->selectedCity;
	}
	
    
	public function setCarMake($carMake) {
		$this->carMake=$carMake;
	}
    
	public function getCarMake() {
		return $this->carMake;
	}
    
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
    
    public function setServiceProviderName($serviceProviderName) {
        $this->serviceProviderName=$serviceProviderName;
    }
    
    public function getServiceProviderName() {
        return $this->serviceProviderName;
    }
    
    public function setServiceProviderType($serviceProviderType) {
        $this->serviceProviderType=$serviceProviderType;
    }
    
    public function getServiceProviderType() {
        return $this->serviceProviderType;
    }
    
    public function setServiceByHourly($serviceByHourly) {
        $this->serviceByHourly=$serviceByHourly;
    }
    
    public function getServiceByHourly() {
        return $this->serviceByHourly;
    }
	
	public function loadCarsDetails($selectedTypeOfCar, $selectedCity) {
		$this ->setSelectedTypeOfCar($selectedTypeOfCar);
		$this ->setSelectedCity($selectedCity);
		$LoadCarsDetailsDAO = new CarLoadDataDAO();
        $returnLoadCarsSuccessMessage = $LoadCarsDetailsDAO->loadCars($this);
        return $returnLoadCarsSuccessMessage;
	}
    
    public function saveSelfdrivecarDetails($carMake) {
        $SelfdrivecarDetailsDAO = new CarLoadDataDAO();
        $this->setCarMake($carMake);
        $returnSelfdrivecarSuccessMessage = $SelfdrivecarDetailsDAO->selfdrivecar($this);
        return $returnSelfdrivecarSuccessMessage;
    }
	
	public function mapIncomingServiceProviderParams($logo_tmp, $target_path, $serviceProviderName, $serviceProviderType, $serviceByHourly) {
	    $this->setLogoTemporaryName($logo_tmp);
        $this->setTargetPathOfImage($target_path);
	    $this->setServiceProviderName($serviceProviderName);
        $this->setServiceProviderType($serviceProviderType);
        $this->setServiceByHourly($serviceByHourly);
	}
    
    public function saveServiceProvider() {
        $ServiceProviderDAO = new CarLoadDataDAO();
        $returnServiceProviderSuccessMessage = $ServiceProviderDAO->addServiceProvider($this);
        return $returnServiceProviderSuccessMessage;
    }
    
    public function showServiceProvider() {
        $showServiceProviderDAO = new CarLoadDataDAO();
        $returnServiceProviderDetails = $showServiceProviderDAO->fetchServiceProvider();
        return $returnServiceProviderDetails;
    }
    
    public function deleteServiceProviderByServiceProviderName($serviceProviderName, $imageName) {
        $deleteServiceProviderDAO = new CarLoadDataDAO();
        $this->setServiceProviderName($serviceProviderName);
        $this->setTargetPathOfImage($imageName);
        $returnDeleteServiceProviderSuccessMessage = $deleteServiceProviderDAO->deleteServiceProvider($this);
        return $returnDeleteServiceProviderSuccessMessage;
    }
	
	public function loadCity(){
		$LoadCarsDetailsDAO=new CarLoadDataDAO();
		$returnLoadCitySuccessMessage =$LoadCarsDetailsDAO -> loadCity();
		return $returnLoadCitySuccessMessage;
	}
}          
?>