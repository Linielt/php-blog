<?php
$root = realpath(__DIR__);
$configs = include("config.php");
$charset = "utf8mb4";
$dsn = "mysql:host={$configs["host"]};dbname={$configs["db"]};charset=$charset";

$error = "";
$sql = file_get_contents($root . "/data/init.sql");

if ($sql === false)
{
    $error = "Cannot find SQL file.";
}

if (!$error)
{
    $pdo = new PDO($dsn, $configs["username"], $configs["pass"], $configs["options"]);
    $result = $pdo->exec($sql);
    if ($result === false)
    {
        $error = "Could not run SQL: " . print_r($pdo->errorInfo(), true);
    }
}
$count = null;
if (!$error)
{
    $sql = "SELECT COUNT(*) AS c FROM post";
    $stmt = $pdo->query($sql);
    if ($stmt)
    {
        $count = $stmt->fetchColumn();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html" />
    <title>Blog Installer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .box {
            border: 1px dotted silver;
            border-radius: 5px;
            padding: 4px;
        }
        .error {
            background-color: #ff6666;
        }
        .success {
            background-color: #88ff88;
        }
    </style>
</head>
<body>
<?php if ($error): ?>
    <div class="error box">
        <?= $error ?>
    </div>
<?php else: ?>
    <div class="success box">
        The database and demo data have been created.
        <?php if ($count): ?>
            <?= $count ?> new posts were created.
        <?php endif ?>
    </div>
<?php endif ?>
</body>
</html>
