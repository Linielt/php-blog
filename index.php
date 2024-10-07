<?php
require_once ("lib/common.php");

session_start();

$pdo = getPDO();
$posts = getAllPosts($pdo);

$notFound = isset($_GET['not-found']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>A Basic Blog</title>
    <?php require "partials/head.php"; ?>
</head>
<body>
    <header>
        <?php require("./partials/header.php"); ?>
    </header>

    <?php if ($notFound): ?>
    <div class="error box"">
        <p>Error: cannot find the requested blog post</p>
    </div>
    <?php endif; ?>
    <main class="post-list">
        <?php foreach ($posts as $post): ?>
            <section class="post-synopsis">
                <h2>
                    <?= htmlEscape($post['title']) ?>
                </h2>
                <div class="meta">
                    <?= htmlEscape($post['created_at']) ?>

                    (<?= $post['comment_count'] ?> comments)
                </div>
                <p>
                    <?= htmlEscape($post['body']) ?>
                </p>
                <div class="post-controls">
                    <a href="view-post.php?post_id=<?= $post["id"] ?>">Read more...</a>
                    <?php if (isLoggedIn()): ?>
                        |
                        <a href="edit-post.php?post_id=<?= $post["id"] ?>">Edit</a>
                    <?php endif; ?>
                </div>
            </section>
        <?php endforeach ?>
    </main>
</body>
</html>
