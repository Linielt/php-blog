<?php
require_once "lib/common.php";
require_once "lib/edit-post.php";
require_once "lib/view-post.php";

session_start();

if (!isLoggedIn())
{
    redirectAndExit("index.php");
}

$title = $body = "";

$pdo = getPDO();

$postId = null;
if (isset($_GET["post_id"]))
{
    $post = getPostRow($pdo, $_GET["post_id"]);
    if ($post)
    {
        $postId = $_GET["post_id"];
        $title = $post["title"];
        $body = $post["body"];
    }
}

$errors = [];
if ($_POST)
{
    $title = $_POST["post-title"];
    if (!$title)
    {
        $errors[] = "Title cannot be empty";
    }
    $body = $_POST["post-body"];
    if (!$body)
    {
        $errors[] = "Body cannot be empty";
    }

    if (!$errors)
    {
        $pdo = getPDO();
        if ($postId)
        {
            editPost($pdo, $title, $body, $postId);
        }
        else
        {
            $userId = getAuthUserId($pdo);
            $postId = addPost($pdo, $title, $body, $userId);

            if ($postId === false)
            {
                $errors[] = "Failed to add post";
            }
        }
    }

    if (!$errors)
    {
        redirectAndExit("edit-post.php?postId=" . $postId);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>A simple blog | New post</title>
        <?php require_once "partials/head.php"; ?>
    </head>

    <?php if ($errors): ?>
        <div class="error box">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <body>
        <header>
            <?php require "partials/top-menu.php"; ?>

            <?php if (isset($_GET["post_id"])): ?>
                <h1>Edit post</h1>
            <?php else: ?>
                <h1>New post</h1>
            <?php endif ?>
        </header>

        <main>
            <form method="post" class="user-form">
                <div>
                    <label for="post-title">Title:</label>
                    <input
                            type="text"
                            id="post-title"
                            name="post-title"
                            value="<?= htmlspecialchars($title) ?>"
                    />
                </div>
                <div>
                    <label for="post-body">Body:</label>
                    <textarea
                            id="post-body"
                            name="post-body"
                            rows="12"
                            cols="70"
                            value="<?= htmlEscape($body) ?>"
                    ></textarea>
                </div>
                <div>
                    <input type="submit" value="Save post" />
                    <a href="index.php">Cancel</a>
                </div>
            </form>
        </main>
    </body>
</html>
