<?php 
declare(strict_types=1);
class Customer{
    private string $last_name;
    private string $first_name;
    private string $email;
    private string $telephone;

    public function __construct(string $last_name, string $first_name, string $email, string $telephone){
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->email = $email;
        $this->telephone = $telephone;
    }

    public function getLastName():string{
        return $this->last_name;
    }
    public function getFirstName():string{
        return $this->first_name;
    }
    public function getEmail():string{
        return $this->email;
    }
    public function getTelephone():string{
        return $this->telephone;
    }

}