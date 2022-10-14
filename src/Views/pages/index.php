<?php require("./src/Views/layouts/main.php") ?>

<?php $mainLayout->slot("title", "Test") ?>

<?php $mainLayout->slot("main") ?>

<h1>Hello <?php trans("hello", ["name" => "Thắng"]) ?></h1>

<?php $mainLayout->endSlot("main") ?>

<?php $mainLayout->render() ?>
