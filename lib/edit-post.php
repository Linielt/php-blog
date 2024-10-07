<?php

function addPost(PDO $pdo, $title, $body, $userId)
{
    $sql = "
    INSERT INTO post (title, body, user_id, created_at)
    VALUES (:title, :body, :user_id, :created_at)
    ";
    $stmt = $pdo->prepare($sql);
    if ($stmt === false)
    {
        throw new Exception("Could not prepare post insertion query.");
    }

    $date = new DateTime(timeZone: new DateTimeZone("UTC"));

    $result = $stmt->execute([
        ":title" => $title,
        ":body" => $body,
        ":user_id" => $userId,
        ":created_at" => $date->format('Y-m-d H:i:s')
    ]);
    if ($result === false)
    {
        throw new Exception("Could not execute post insertion query.");
    }

    return $pdo->lastInsertId();
}

function editPost(PDO $pdo, $title, $body, $postId)
{
    $sql = "
    UPDATE post
    SET title = :title, body = :body
    WHERE id = :post_id
    ";
    $stmt = $pdo->prepare($sql);
    if ($stmt === false)
    {
        throw new Exception("Could not prepare post edit query.");
    }

    $result = $stmt->execute([
        ":title" => $title,
        ":body" => $body,
        "post_id" => $postId,
    ]);
    if ($result === false)
    {
        throw new Exception("Could not execute post edit query.");
    }

    return true;
}