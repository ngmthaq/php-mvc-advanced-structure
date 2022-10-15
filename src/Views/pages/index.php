<?php require("./src/Views/layouts/main.php") ?>

<?php $mainLayout->slot("title", "Test") ?>

<?php $mainLayout->slot("main") ?>

<h1>Hello <?php trans("hello", ["name" => "Thắng"]) ?></h1>
<form action="/" method="get">
    <label for="email">Email</label>
    <input type="text" id="email" name="email">
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
    <input type="checkbox" name="remember" id="remember">
    <input type="submit" value="Login" name="button">
</form>

<?php $mainLayout->endSlot("main") ?>

<?php $mainLayout->render() ?>
