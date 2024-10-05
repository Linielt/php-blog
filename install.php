<?php
require_once "lib/common.php";
require_once "lib/install.php";

// Store data in session so it is not lost
session_start();

// Only run installer when responding to form
if ($_POST)
{
    $pdo = getPDO();
    list($_SESSION["count"], $_SESSION["error"]) = installBlog($pdo);

    redirectAndExit("install.php");
}

$attempted = false;
if ($_SESSION)
{
    $attempted = true;
    $count = $_SESSION["count"];
    $error = $_SESSION["error"];

    // Report install/failure once per session only.
    unset($_SESSION["count"]);
    unset($_SESSION["error"]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html" />
    <title>Blog Installer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./stylesheets/install.css" />
</head>
<body>
<?php if ($attempted): ?>
    <?php if ($error): ?>
        <div class="error box">
            <?= $error ?>
        </div>
    <?php else: ?>
        <div class="success box">
            The database and demo data was created with no issues.

            <?php foreach (["post", "comment"] as $tableName): ?>
                <?php if (isset($count[$tableName])): ?> new
                    <?= $count[$tableName] ?>
                    <?= $tableName ?>s
                    were created.
                <?php endif ?>
            <?php endforeach ?>
        </div>

    <p>
        <a href="index.php">View the blog</a>,
        or <a href="install.php">Install again</a>.
    </p>
<?php endif ?>

<?php else: ?>
    <p>Click the install button to reset the database.</p>

    <form method="post">
        <input
            name="install"
            type="submit"
            value="install"
        />
    </form>
<?php endif ?>
</body>
</html>
