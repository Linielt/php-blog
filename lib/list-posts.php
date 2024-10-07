<?php

function deletePost(PDO $pdo, $postId)
{
    $sql = "
    DELETE FROM post
    WHERE id = :id
    ";
    $stmt = $pdo->prepare($sql);
    if ($stmt === false)
    {
        throw new Exception("There was an error while preparing this query.");
    }

    $result = $stmt->execute([":id" => $postId]);

    return $result !== false;
}