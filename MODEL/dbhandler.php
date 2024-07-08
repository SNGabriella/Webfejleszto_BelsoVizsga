<?php 

declare(strict_types=1);

class Dbhandler{
    // Beállítjuk, hogy milyen adatokkal hozza létre az új customert
    public static function setCustomer(object $pdo, string $last_name, string $first_name, string $telephone, string $email){

        $stmt = $pdo->prepare("INSERT INTO customers (last_name, first_name, telephone, email) VALUES (:last_name, :first_name, :telephone, :email)");//:placeholderek a form-ból kapott adatokra utal

        //összekötjük a placeholdereket a változókkal
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":telephone", $telephone);
        $stmt->bindParam(":email", $email);

        $stmt -> execute();
    }

    //Beállítjuk, hogy milyen adatokkal hozza létre az új terméket
    public static function setProduct(object $pdo, string $serial_number, string $manufacturer, string $model){

        $stmt = $pdo->prepare("INSERT INTO products (serial_number, manufacturer, model) VALUES (:serial_number, :manufacturer, :model)"); 
        $stmt->bindParam(":serial_number", $serial_number);
        $stmt->bindParam(":manufacturer", $manufacturer);
        $stmt->bindParam(":model", $model);

        $stmt->execute();
    }

    // Megszerezzük a customer és product_id-t az adatbázisból, hogy össze tudjuk kötni a kettőt

    //customer_id
    public static function getCustomerId(object $pdo, string $email):?int{

        $stmt = $pdo->prepare("SELECT customer_id FROM customers WHERE email = :email");

        $stmt->bindParam(":email", $email);
        $stmt->execute();
        //a lekérdezés oszlopának első sorát akarjuk visszaadni:
        //(ezt muszáj volt így megadni, mert amíg nem volt még ügyfél egyáltalán a táblázatban, hibát dobott)
        $result = $stmt->fetchColumn();
        return $result !== false ? (int)$result : null;
    }

    //product_id
    public static function getProductId(object $pdo, string $serial_number): ?int{

        $stmt = $pdo->prepare("SELECT product_id FROM products WHERE serial_number = :serial_number");

        $stmt->bindParam(":serial_number", $serial_number);

        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result !== false ? (int)$result : null;
    }

    //Function, amivel összekötjük az ügyfelet a termékkel
    public static function setCustomerProduct(object $pdo, $customer_id, $product_id){

        $stmt = $pdo->prepare("INSERT INTO customer_products (customer_id, product_id) VALUES (:customer_id, :product_id)");

        $stmt->bindParam(":customer_id", $customer_id);
        $stmt->bindParam(":product_id", $product_id);

        $stmt->execute();
    }

    //Function, amivel beállítjuk a státuszt a termékhez
    public static function setStatus(object $pdo, int $product_id, string $status){  

        $stmt = $pdo->prepare("INSERT INTO service_statuses (product_id, status) VALUES (:product_id, :status)");

        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":status", $status);
        $stmt->execute();

    }

    //Megszerezzük a státuszt a product_id alapján
    public function getStatusByProductId(object $pdo, int $product_id):array{

        $stmt = $pdo->prepare("SELECT status change_of_status FROM status_services WHERE product_id = :product_id ORDER BY status DESC");

        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Function, amivel módosítani tudjuk a státuszt
    public static function updateStatus(object $pdo,string $product_id, string $status){

        $stmt = $pdo->prepare("UPDATE service_statuses SET status = :status, change_of_status = NOW() WHERE product_id = :product_id");

        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();
    }

    //Lekérdezni az összes szervízben lévő terméket és sorrendbe állítani, a kész termékekre vonatkozó kitétellel

    public static function getServiceProducts($pdo){
        try{
        $stmt = $pdo->prepare(
            "SELECT 
                p.serial_number,
                p.manufacturer,
                p.model,
                ss.status,
                ss.change_of_status
            FROM service_statuses ss
            JOIN products p ON ss.product_id = p.product_id
            WHERE
                ss.status != 'Kész' OR (ss.status = 'Kész' AND DATE(ss.change_of_status) = CURDATE())
            ORDER BY 
            FIELD(ss.status, 'Beérkezett', 'Hibafeltárás', 'Alkatrész beszerzés alatt', 'Javítás', 'Kész'), ss.change_of_status DESC");

            $stmt->execute();
            $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);          

            $productArray = [];

            foreach($result as $row){
                $product= new Product(
                    $row['serial_number'],
                    $row['manufacturer'],
                    $row['model'],
                    $row['status'],
                    $row['change_of_status']
                );

                $productArray[] = $product;
            }
            print_r($product);

            $stmt->null; 
            return $productArray; 
        }
        catch (PDOException $e) {
            throw new Exception('SQL Error: ' . $e->getMessage());           
        }
    } 
}


