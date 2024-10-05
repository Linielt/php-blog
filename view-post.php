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
    redirectAndExit("error.php");
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
        <?= convertNewLinesToParagraphs($row["body"])?>
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
            <?= convertNewLinesToParagraphs($comment["text"]) ?>
        </div>
        </div>
    <?php endforeach; ?>
</article>

<?php require("./partials/comment-form.php"); ?>
</body>
</html>
