<?php
require_once ("lib/common.php");
require_once ("lib/view-post.php");

session_start();

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
    if ($_GET["action"] === "add-comment")
    {
        $commentData = [
            "name" => $_POST["comment-name"],
            "website" => $_POST["comment-website"],
            "text" => $_POST["comment-text"],
        ];
        $errors = handleAddComment($pdo, $postId, $commentData);
    }
    else if ($_GET["action"] === "delete-comment")
    {
        $deleteResponse = $_POST["delete-comment"];
        handleDeleteComment($pdo, $postId, $deleteResponse);
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
        <?php require("partials/header.php"); ?>
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
    </article>

    <?php require "partials/list-comments.php" ?>

    <?php require("partials/comment-form.php"); ?>
</body>
</html>
