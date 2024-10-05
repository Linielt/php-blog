<?php
require_once "lib/common.php";

if (version_compare(PHP_VERSION, '5.3.7') < 0)
{
    throw new Exception("This system needs PHP 5.3.7 or later.");
}

session_start();

$username = "";
if ($_POST)
{
    $pdo = getPDO();

    $username = $_POST['username'];
    $ok = tryLogin($pdo, $username, $_POST['password']);
    if ($ok)
    {
        login($username);
        redirectAndExit("index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>A Basic Blog | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header>
        <?php require "partials/header.php"; ?>
    </header>

    <?php if ($username): ?>
        <div style="border: 1px solid #ff6666; padding: 6px">
            The username or password is incorrect, try again
        </div>
    <?php endif ?>
    <main>
        <p>Login here:</p>

        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlEscape($username)?>" />
            <label for="password">Password</label>
            <input type="password" id="password" name="password" />
            <input type="submit" name="submit" value="Login" />
        </form>
    </main>
</body>