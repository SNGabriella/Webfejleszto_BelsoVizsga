<?php 
declare(strict_types=1);
class Status{
    private string $status;
    private string $change_of_status;
    private static $statusColors = [
        'Beérkezett' => 'table-primary',
        'Hibafeltárás' => 'table-danger',
        'Alkatrész beszerzés alatt' => 'table-warning',
        'Javítás' => 'table-info',
        'Kész' => 'table-success'
    ];
    public function __construct(string $status, string $change_of_status){
        $this->status = $status;
        $this->change_of_status = $change_of_status;
    }

    public function getStatus():string{
        return $this->status;
    }
    public static function getStatusColor(string $status): string {
        return self::$statusColors[$status]; 
    }
    public function getChangeOfStatus():string{
        return $this->change_of_status;
    }
}