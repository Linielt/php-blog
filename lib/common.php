<?php

function getRootPath()
{
    return realpath(__DIR__ . "/..");
}

function getDsn()
{
    $configs = include(dirname(__DIR__) . "/config.php");
    return "mysql:host={$configs["host"]};dbname={$configs["db"]};charset=utf8mb4";
}

function getPDO()
{
    $configs = include(dirname(__DIR__) . "/config.php");
    return new PDO(getDsn(), $configs["username"], $configs["pass"], $configs["options"]);
}

function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, "UTF-8");
}

function countCommentsForPost($postId)
{
    $pdo = getPDO();
    $sql = "
    SELECT COUNT(*) AS c
    FROM comment
    WHERE post_id = :postId
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(["postId" => $postId]);

    return (int) $stmt->fetchColumn();
}

function getCommentsForPost($postId)
{
    $pdo = getPDO();
    $sql = "
    SELECT id, name, text, created_at, website
    FROM comment
    WHERE post_id = :post_id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["post_id" => $postId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}