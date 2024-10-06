<?php
require_once ("lib/common.php");
require_once ("lib/view-post.php");

if (isset($_GET["post_id"]))
{
    $postId = $_GET["post_id"];
}
else
{
    $postId = 0;
}

$pdo = getPDO();
$row = getPostRow($pdo, $postId);

if (!$row)
{
    redirectAndExit('index.php?not-found=1');
}

$errors = null;
if ($_POST)
{
    $commentData = [
            "name" => $_POST["comment-name"],
            "website" => $_POST["comment-website"],
            "text" => $_POST["comment-text"],
    ];
    $errors = addCommentToPost($pdo, $postId, $commentData);

    if (!$errors)
    {
        redirectAndExit("view-post.php?post_id=" . $postId);
    }
}
else
{
    $commentData = [
        "name" => "",
        "website" => "",
        "text" => "",
    ];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        A Basic Blog | <?= htmlspecialchars($row["title"], ENT_HTML5, "UTF-8") ?>
    </title>
    <?php require "partials/head.php" ?>
</head>
<body>
    <header>
        <?php require("./partials/header.php"); ?>
    </header>

    <article class="post">
        <h2>
            <?= htmlEscape($row["title"]) ?>
        </h2>
        <div class="date">
            <?= htmlEscape($row["created_at"]) ?>
        </div>
        <p>
            <?= convertNewLinesToParagraphs($row["body"])?>
        </p>

        <section class="comment-list">
            <h3><?= countCommentsForPost($pdo, $postId) ?> comments</h3>

            <?php foreach (getCommentsForPost($pdo, $postId) as $comment): ?>
                <div class="comment">
                    <div class="comment-metadata">
                        Comment from
                        <?= htmlEscape($comment["name"]) ?>
                        on
                        <?= htmlEscape($comment["created_at"]) ?>
                    </div>
                    <div class="comment-body">
                        <?= convertNewLinesToParagraphs($comment["text"]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </article>

    <?php require("./partials/comment-form.php"); ?>
</body>
</html>
