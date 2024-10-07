<?php

function deletePost(PDO $pdo, $postId)
{
    $sqls = [
        "
        DELETE FROM comment
        WHERE post_id = :id
        ",
        "
        DELETE FROM post
        WHERE id = :id
        "
    ];

    foreach($sqls as $sql)
    {
        $stmt = $pdo->prepare($sql);
        if ($stmt === false)
        {
            throw new Exception("There was an error preparing the query");
        }

        $result = $stmt->execute([":id" => $postId]);

        if ($result === false)
        {
            break;
        }
    }

    return $result !== false;
}