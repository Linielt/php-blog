<?php

function installBlog(PDO $pdo)
{
    $root = getRootPath();
    $error = "";

    $sql = file_get_contents($root . "/data/init.sql");

    if (!$sql)
    {
        $error = "Unable to find SQL file";
    }

    if (!$error)
    {
        $result = $pdo->exec($sql);
        if ($result === false)
        {
            $error = "Could not run SQL: " . print_r($pdo->errorInfo(), true);
        }
    }

    $count = [];

    foreach(["post", "comment"] as $tableName)
    {
        if (!$error)
        {
            $sql = "SELECT COUNT(*) AS c FROM " . $tableName;
            $stmt = $pdo->query($sql);
            if ($stmt)
            {
                $count[$tableName] = $stmt->fetchColumn();
            }
        }
    }

    return [$count, $error];
}