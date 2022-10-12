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
    <?php $mainLayout->section("css") ?>
</head>
<body>
    <div class="main">
        <?php $mainLayout->section("header") ?>
        <p>Main Layout</p>
        <?php $mainLayout->main() ?>
        <?php $mainLayout->section("footer") ?>
    </div>

    <?php $mainLayout->section("js") ?>
</body>
</html>

<?php $mainLayout->end() ?>
