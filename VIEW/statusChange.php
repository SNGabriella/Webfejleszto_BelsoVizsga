<?php
session_start();
require_once '../MODEL/connect.php';
require_once '../MODEL/customer.php';
require_once '../MODEL/dbhandler.php';
require_once '../MODEL/product.php';
require_once '../MODEL/status.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elektronikai szervíz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-body-secondary">
    <?php
    require_once 'navbar.php';
    ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <?php
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']);
                }
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']);
                }
                ?>
                <form action="../CONTROLLER/status_control.php" method="POST">
                    <label class="form-label" for="product_id">Termék ID:</label>
                    <input class="form-control" type="text" id="product_id" name="product_id" required><br>
                    <label class="form-label" for="status">Új státusz:</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Beérkezett">Beérkezett</option>
                        <option value="Hibafeltárás">Hibafeltárás</option>
                        <option value="Alkatrész">Alkatrész beszerzés alatt</option>
                        <option value="Javítás">Javítás</option>
                        <option value="Kész">Kész</option>
                    </select><br>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Frissítés</button>
                    </div>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>

    <?php
    require_once 'footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>