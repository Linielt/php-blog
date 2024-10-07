<?php

function getPostRow(PDO $pdo, $postId)
{
    $stmt = $pdo->prepare("
    SELECT title, created_at, body
    FROM post
    WHERE id = :id
    ");

    if ($stmt === false)
    {
        throw new Exception("There was a problem preparing this query.");
    }

    $result = $stmt->execute([":id" => $postId]);
    if ($result === false)
    {
        throw new Exception("There was a problem running this query.");
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;
}

function addCommentToPost(PDO $pdo, $postId, array $commentData)
{
    $errors = [];

    if (empty($commentData["name"]))
    {
        $errors["name"] = "A name is required";
    }
    if (empty($commentData["text"]))
    {
        $errors["text"] = "The comment must have a body";
    }

    if (!$errors)
    {
        $sql = "
        INSERT INTO comment
        (name, website, text, created_at, post_id)
        VALUES(:name, :website, :text, :created_at, :post_id)
        ";
        $stmt = $pdo->prepare($sql);
        if ($stmt === false)
        {
            throw new Exception("Cannot prepare comment insertion statement.");
        }

        $date = new DateTime(timeZone: new DateTimeZone("UTC"));
        $createdTimestamp = $date->format("Y-m-d H:i:s");

        $result = $stmt->execute(array_merge($commentData, ["post_id" => $postId, "created_at" => $createdTimestamp]));

        if ($result === false)
        {
            $errorInfo = $stmt->errorInfo();
            if ($errorInfo)
            {
                $errors[] = $errorInfo[2];
            }
        }
    }

    return $errors;
}