<?php 
declare(strict_types=1);
session_start();
require_once '../MODEL/connect.php';
require_once '../MODEL/customer.php';
require_once '../MODEL/dbhandler.php';
require_once '../MODEL/product.php';
require_once '../MODEL/status.php'; 

if($_SERVER["REQUEST_METHOD"] === "POST"){

    //megszerezzük a form-ról érkező adatokat:
    $last_name = $_POST["last_name"];
    $first_name = $_POST["first_name"];
    $telephone = $_POST["telephone"];
    $email = $_POST["email"];
    $serial_number = $_POST['serial_number'];
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];

    // ellenőrizzük, hogy minden adat ki legyen töltve, illetve az email helyesen megadva
    if (is_input_empty($last_name, $first_name, $telephone, $email, $serial_number, $manufacturer, $model)) {
        //átadjuk az adatokat a view-nak, hogy ott írja ki a hibaüzeneteket
        $_SESSION['error_message'] = 'Minden mező kitöltése kötelező.';
        header('Location: ../VIEW/form.php');
        exit();
    } elseif (is_email_invalid($email)) {
        //ugyanaz
        $_SESSION['error_message'] = 'Érvénytelen email cím.';
        header('Location: ../VIEW/form.php');
        exit();
    } else {
        try {
            // Ellenőrizzük, hogy létezik-e már az ügyfél
            $customer_id = Dbhandler::getCustomerId($pdo, $email);

            // Ha az ügyfél nem létezik, adjuk hozzá
            if (!$customer_id) {
                addCustomer($pdo, $last_name, $first_name, $telephone, $email);
                $customer_id = Dbhandler::getCustomerId($pdo, $email);
            }

            // Adjuk hozzá a terméket
            addProduct($pdo, $serial_number, $manufacturer, $model);
            $product_id = Dbhandler::getProductId($pdo, $serial_number);

            //összekötjük az ügyfelet a termékkel

            $customer_id = Dbhandler::getCustomerId($pdo, $email);
            $product_id = Dbhandler::getProductId($pdo, $serial_number);

            // Beállítjuk az alapértelmezett státuszt
            Dbhandler::setStatus($pdo, $product_id, 'Beérkezett');

            // Összekötjük az ügyfelet a termékkel és átadjuk az adatot a view-nak, hogy ott írja ki, ha minden rendben van 

            if ($customer_id && $product_id) {
                Dbhandler::setCustomerProduct($pdo, $customer_id, $product_id);
                $_SESSION['success_message'] = 'Adatok sikeresen feltöltve.';
            } else {
                $_SESSION['error_message'] = 'Nem sikerült összekötni az ügyfelet a termékkel.';
            }
            header('Location: ../VIEW/form.php');
            exit();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
 
//itt megadjuk, hogy mit viszgálunk, hogy ne legyen üres semmi
function is_input_empty($last_name, $first_name, $telephone, $email, $serial_number, $manufacturer, $model) {
    return empty($last_name) || empty($first_name) || empty($telephone) || empty($email) || empty($serial_number) || empty($manufacturer) || empty($model);
}

// itt megadjuk, hogy mit vizsgálunk, hogy érvényes legyen az email
function is_email_invalid($email) {
    $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    return !preg_match($pattern, $email);
}

//function, ami hozzáad egy új customert
function addCustomer(object $pdo, string $last_name, string $first_name, string $telephone, string $email) {
    Dbhandler::setCustomer($pdo, $last_name, $first_name, $telephone, $email);
}

//function, ami hozzáad egy új terméket
function addProduct(object $pdo, string $serial_number, string $manufacturer, string $model) {
    Dbhandler::setProduct($pdo, $serial_number, $manufacturer, $model);
}
