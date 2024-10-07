<?php

return [
    "host" => "127.0.0.1",
    "port" => "3306",
    "username" => "root",
    "pass" => "",
    "db" => "blog",
    "options" => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ],
];