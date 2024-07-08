<?php 
session_start();
require_once '../MODEL/connect.php';
require_once '../MODEL/customer.php';
require_once '../MODEL/dbhandler.php';
require_once '../MODEL/product.php';
require_once '../MODEL/status.php'; 


if($_SERVER["REQUEST_METHOD"] === 'POST'){

    //Megszerezzük az adatokat a státuszt módosító form-ról

    $product_id = $_POST["product_id"];
    $status = $_POST["status"];

    //Ellenőrizzük, hogy minden adat ki legyen töltve

    if(empty($product_id) || empty($status)){
        $_SESSION['error_message'] = 'Minden mező kitöltése kötelező.';
        header('Location: ../VIEW/statusChange.php');
        exit();
        //különben, ha minden adat ki lett töltve, akkor tegye a következőt:
    } else {
        try{
            //Frissítjük a státuszt
            Dbhandler::updateStatus($pdo, $product_id, $status);

            $_SESSION['success_message'] = "Státusz sikeresen frissítve";
            header("Location: ../VIEW/statusChange.php");
            exit();
        }
        catch(Exception $e){
            echo 'Error ' . $e->getMessage();
        }
    }
}
//Lekérjük az adatokat a getServiceProducts sql-es lekérdezésből(mert ezeket szeretnénk kiíratni)
function viewProducts(PDO $pdo){
    $products = Dbhandler::getServiceProducts($pdo);
    $_SESSION['products'] = $products; //átadjuk a view-nak session-ben az adatokat
    return $products;
    }

    $products = viewProducts($pdo);//meghívjuk a functiont, hogy működjön
    
    header('Location: ../VIEW/tableview.php');
    exit();









  

  


