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
    <meta charset="utf-8">
    <title>A Basic Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header>
        <?php require("./partials/header.php"); ?>
    </header>

    <?php if ($notFound): ?>
    <div style="border: 1px solid #ff6666; padding: 6px;">
        <p>Error: cannot find the requested blog post</p>
    </div>
    <?php endif; ?>
    <main>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <article>
            <h2>
                <?= htmlEscape($row['title']) ?>
            </h2>
            <div>
                <?= htmlEscape($row['created_at']) ?>

                (<?= countCommentsForPost($row['id']) ?> comments)
            </div>
            <p>
                <?= htmlEscape($row['body']) ?>
            </p>
            <p>
                <a href="view-post.php?post_id=<?= $row["id"] ?>">Read more...</a>
            </p>
        </article>
        <?php endwhile; ?>
    </main>
</body>
</html>
