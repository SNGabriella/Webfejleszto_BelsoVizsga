<?php 
require_once '../MODEL/product.php';
require_once '../MODEL/status.php'; 
session_start();
$products = $_SESSION['products']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szervíz összesítő</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-body-secondary">
    <?php require_once 'navbar.php';?>
<div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h3>Szervízben lévő termékek:</h3>
                <?php if (!empty($products)): ?>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Sorozatszám</th>
                            <th>Gyártó</th>
                            <th>Model</th>
                            <th>Státusz</th>
                            <th>Státusz változás dátuma</th>
                        </tr>
                    </>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr class="<?php echo htmlspecialchars(Status::getStatusColor($product->getStatus()))  ?>">
                                <td><?= htmlspecialchars($product->getSerial_number()) ?></td>
                                <td><?= htmlspecialchars($product->getManufacturer()) ?></td>
                                <td><?= htmlspecialchars($product->getModel()) ?></td>
                                <td><?= htmlspecialchars($product->getStatus()) ?></td>
                                <td><?= htmlspecialchars($product->getStatusChange()) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


                <?php else: ?>
                    <p>Nincsenek szervízben lévő termékek.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require_once 'footer.php';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>