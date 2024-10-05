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
    INSERT INTO user (username, password, created_at)
    VALUES (:username, :password, :created_at)
    ";
    $stmt = $pdo->prepare($sql);
    if ($stmt === false)
    {
        $error = "Could not prepare user creation";
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
        $result = $stmt->execute([
            "username" => $username,
            "password" => $hash,
            "created_at" => date('Y-m-d H:i:s')
        ]
        );
        if ($result === false)
        {
            $error = "Could not execute user creation";
        }
    }

    if ($error)
    {
        $password = "";
    }

    return [$password, $error];
}