<?php 
declare(strict_types=1);
class Product{
    //Adattagok

    private string $serial_number;
    private string $manufacturer;
    private string $model;
    private string $status;
    private string $statusChange;

    public function __construct(string $serial_number, string $manufacturer, string $model, string $status, string $statusChange){

        $this->serial_number = $serial_number;
        $this->manufacturer = $manufacturer;
        $this->model = $model;
        $this->status = $status;
        $this->statusChange = $statusChange;
    }

    public function getSerial_number():string{
        return $this->serial_number;
    }

    public function getManufacturer():string{
        return $this->manufacturer;
    }

    public function getModel():string{
        return $this->model;
    }
    public function getStatus():string{
        return $this->status;
    }
    public function getStatusChange():string{
        return $this->statusChange;
    }
}