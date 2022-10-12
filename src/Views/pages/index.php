<?php require("./src/Views/layouts/main.php") ?>

<?php $mainLayout->slot("title", "Test") ?>

<?php $mainLayout->slot("main") ?>

<h1>Hello <?php echo $hello ?></h1>
<img src="<?php echo resources("images/demo.png") ?>" alt="">

<?php $mainLayout->endSlot("main") ?>

<?php $mainLayout->render() ?>
