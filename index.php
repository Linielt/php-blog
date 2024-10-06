<?php
require_once ("lib/common.php");

session_start();

$pdo = getPDO();
$stmt = $pdo->query(
        "SELECT id, title, created_at, body
        FROM post
        ORDER BY created_at DESC"
);
if ($stmt === false)
{
    throw new Exception("There was a problem with running this query.");
}

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
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <section class="post-synopsis">
            <h2>
                <?= htmlEscape($row['title']) ?>
            </h2>
            <div class="meta">
                <?= htmlEscape($row['created_at']) ?>

                (<?= countCommentsForPost($pdo ,$row['id']) ?> comments)
            </div>
            <p>
                <?= htmlEscape($row['body']) ?>
            </p>
            <div class="post-controls">
                <a href="view-post.php?post_id=<?= $row["id"] ?>">Read more...</a>
                <?php if (isLoggedIn()): ?>
                    |
                    <a href="edit-post.php?post_id=<?= $row["id"] ?>">Edit</a>
                <?php endif; ?>
            </div>
        </section>
        <?php endwhile; ?>
    </main>
</body>
</html>
