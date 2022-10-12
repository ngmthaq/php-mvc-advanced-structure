<?php

use Core\View\Layout;

$mainLayout = new Layout("mainLayout");

$mainLayout->start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $mainLayout->section("title") ?></title>
    <link rel="shortcut icon" href="<?php assets("img/favicon.ico") ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php assets("libs/bootstrap/dist/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?php assets("libs/fontawesome/css/all.min.css") ?>">
    <link rel="stylesheet" href="<?php assets("css/index.css") ?>">
    <?php $mainLayout->section("css") ?>
</head>
<body>
    <div class="main">
        <?php $mainLayout->section("header") ?>
        <?php $mainLayout->main() ?>
        <?php $mainLayout->section("footer") ?>
    </div>

    <script src="<?php assets("libs/jquery/dist/jquery.min.js") ?>"></script>
    <script src="<?php assets("libs/bootstrap/dist/js/bootstrap.min.js") ?>"></script>
    <script src="<?php assets("libs/fontawesome/js/all.min.js") ?>"></script>
    <script src="<?php assets("js/index.js") ?>"></script>
    <?php $mainLayout->section("js") ?>
</body>
</html>

<?php $mainLayout->end() ?>
