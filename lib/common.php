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