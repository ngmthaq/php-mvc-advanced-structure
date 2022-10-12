<?php require("./src/Views/layouts/main.php") ?>

<?php $mainLayout->slot("title", "Test") ?>

<?php $mainLayout->slot("css") ?>
<style>
    h1 {
        color: blue;
    }
</style>
<?php $mainLayout->endSlot("css") ?>

<?php $mainLayout->slot("main") ?>
<h1>Hello <?php echo $hello ?></h1>
<?php $mainLayout->endSlot("main") ?>

<?php $mainLayout->slot("js") ?>
<script>
    console.log("test script");
</script>
<?php $mainLayout->endSlot("js") ?>

<?php $mainLayout->render() ?>
