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

function createUser(PDO $pdo, $username, $length = 10)
{
    $alphabet = range(ord('A'), ord('z'));
    $alphabetLength = count($alphabet);

    $password = "";
    for ($i = 0; $i < $length; $i++)
    {
        $letterCode = $alphabet[rand(0, $alphabetLength - 1)];
        $password .= chr($letterCode);
    }

    $error = "";
    $sql = "
    UPDATE user
    SET password = :password, created_at = :created_at, is_enabled = true
    WHERE username = :username
    ";
    $stmt = $pdo->prepare($sql);
    if ($stmt === false)
    {
        $error = "Could not prepare user update";
    }

    if (!$error)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if ($hash === false)
        {
            $error = "Password hashing failed.";
        }
    }

    if (!$error)
    {
        $date = new DateTime(timezone: new DateTimeZone("UTC"));
        $result = $stmt->execute([
            "username" => $username,
            "password" => $hash,
            "created_at" => $date->format("Y-m-d H:i:s")
        ]
        );
        if ($result === false)
        {
            $error = "Could not execute password update";
        }
    }

    if ($error)
    {
        $password = "";
    }

    return [$password, $error];
}