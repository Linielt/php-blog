<?php
require_once ("lib/common.php");

if (isset($_GET["post_id"]))
{
    $postId = $_GET["post_id"];
}
else
{
    $postId = 0;
}

$pdo = getPDO();
$stmt = $pdo->prepare(
    "SELECT title, created_at, body
    FROM post
    WHERE id = :id"
);
if ($stmt === false)
{
    throw new Exception("There was a problem preparing this query.");
}
$result = $stmt->execute(["id" => $postId]);
if ($result === false)
{
    throw new Exception("There was a problem running this query.");
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Swaps carriage returns for paragraph breaks.
$bodyText = htmlEscape($row['body']);
$paraText = str_replace("\n", "</p><p>", $bodyText);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html" />
    <title>
        A Basic Blog | <?= htmlspecialchars($row["title"], ENT_HTML5, "UTF-8") ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<header>
    <?php require("./partials/header.php"); ?>
</header>

<article>
    <h2>
        <?= htmlEscape($row["title"]) ?>
    </h2>
    <div>
        <?= htmlEscape($row["created_at"]) ?>
    </div>
    <p>
        <?= $paraText ?>
    </p>

    <h3><?= countCommentsForPost($postId) ?> comments</h3>

    <?php foreach (getCommentsForPost($postId) as $comment): ?>
        <hr />
        <div class="comment">
            <div class="comment-metadata">
                Comment from
                <?= htmlEscape($comment["name"]) ?>
                on
                <?= htmlEscape($comment["created_at"]) ?>
            </div>
        <div class="comment-body">
            <?= htmlEscape($comment["text"]) ?>
        </div>
        </div>
    <?php endforeach; ?>
</article>
</body>
</html>
