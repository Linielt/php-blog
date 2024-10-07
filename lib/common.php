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

function countCommentsForPost(PDO $pdo, $postId)
{
    $sql = "
    SELECT COUNT(*) AS c
    FROM comment
    WHERE post_id = :postId
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(["postId" => $postId]);

    return (int) $stmt->fetchColumn();
}

function getCommentsForPost(PDO $pdo, $postId)
{
    $sql = "
    SELECT id, name, text, created_at, website
    FROM comment
    WHERE post_id = :post_id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["post_id" => $postId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function redirectAndExit($script)
{
    $relativeUrl = $_SERVER["PHP_SELF"];
    $urlFolder = substr($relativeUrl, 0, strrpos($relativeUrl, "/") + 1);

    $host = $_SERVER["HTTP_HOST"];
    $fullUrl = "http://" . $host . $urlFolder . $script;
    header("Location: " . $fullUrl);
    exit();
}

function convertNewLinesToParagraphs($text)
{
    $escaped = htmlEscape($text);

    return "<p>" . str_replace("\n", "</p><p>", $escaped) . "</p>";
}

function tryLogin(PDO $pdo, $username, $password)
{
    $sql = "
    SELECT password
    FROM user
    WHERE username = :username
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["username" => $username]);

    $hash = $stmt->fetchColumn();
    $success = password_verify($password, $hash);

    return $success;
}

function login($username)
{
    session_regenerate_id();

    $_SESSION['logged_in_username'] = $username;
}

function isLoggedIn()
{
    return isset($_SESSION['logged_in_username']);
}

function logout()
{
    unset($_SESSION['logged_in_username']);
}

function getAuthUser()
{
    return isLoggedIn() ? $_SESSION['logged_in_username'] : null;
}

function getAuthUserId(PDO $pdo)
{
    if (!isLoggedIn())
    {
        return null;
    }

    $sql = "
    SELECT id
    FROM user
    WHERE username = :username
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["username" => getAuthUser()]);

    return $stmt->fetchColumn();
}

function getAllPosts(PDO $pdo)
{
    $stmt = $pdo->query(
        "SELECT id, title, created_at, body
        FROM post
        ORDER BY created_at DESC"
    );
    if ($stmt === false)
    {
        throw new Exception("There was a problem with running this query.");
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}