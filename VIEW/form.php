<?php 
declare(strict_types=1);
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
    session_start();
    ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">

            <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']);
                }

                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']);
                }
                ?>

                <form action="../CONTROLLER/control.php" method="POST">
                    <div class="class mb-3">
                        <label class="form-label" for="serial_number">Szériaszám</label>
                        <input class="form-control" type="text" placeholder="RF234567G/A" name="serial_number" id="serial_number">
                    </div>

                    <div class="class mb-3">
                        <label class="form-label" for="manufacturer">Gyártó</label>
                        <input class="form-control" type="text" placeholder="SAMSUNG ELECTRONICS" name="manufacturer" id="manufacturer">
                    </div>

                    <div class="class mb-3">
                        <label class="form-label" for="model">Model</label>
                        <input class="form-control" type="text" placeholder="SIDE BY SIDE" name="model" id="model">
                    </div>

                    <div class="class mb-3">
                        <label class="form-label" for="last_name">Vezetéknév</label>
                        <input class="form-control" type="text" placeholder="Kis" name="last_name" id="last_name">
                    </div>

                    <div class="class mb-3">
                        <label class="form-label" for="first_name">Keresztnév</label>
                        <input class="form-control" type="text" placeholder="Lajos" name="first_name" id="first_name">
                    </div>

                    <div class="class mb-3">
                        <label class="form-label" for="telephone">Telefonszám</label>
                        <input class="form-control" type="text" placeholder="06702347890" name="telephone" id="telephone">
                    </div>

                    <div class="class mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" type="email" placeholder="kislajos@gmail.com" name="email" id="email">
                    </div>

                    <div class="mb-3 text-center">
                        <input class="btn btn-primary"  type="submit" value="Felvitel" id="felvitel">
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