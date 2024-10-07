<?php
require_once "lib/common.php";

if (version_compare(PHP_VERSION, '5.3.7') < 0)
{
    throw new Exception("This system needs PHP 5.3.7 or later.");
}

session_start();

if (isLoggedIn())
{
    redirectAndExit("index.php");
}

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
    <title>A Basic Blog | Login</title>
    <?php require "partials/head.php" ?>
</head>
<body>
    <header>
        <?php require "partials/header.php"; ?>
    </header>

    <?php if ($username): ?>
        <div class="error box">
            The username or password is incorrect, try again
        </div>
    <?php endif ?>
    <main>
        <p>Login here:</p>

        <form method="post">
            <div>
                <label for="username">Username:</label>
                <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?= htmlEscape($username)?>"
                />
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" />
            </div>
            <input type="submit" name="submit" value="Login" />
        </form>
    </main>
</body>