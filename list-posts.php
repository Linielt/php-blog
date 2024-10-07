<?php
require_once "lib/common.php";
require_once "lib/list-posts.php";

session_start();

if (!isLoggedIn())
{
    redirectAndExit("index.php");
}

if ($_POST)
{
    $deleteResponse = $_POST["delete-post"];
    if ($deleteResponse)
    {
        $keys = array_keys($deleteResponse);
        $deletePostId = $keys[0];
        if ($deletePostId)
        {
            deletePost(getPDO(), $deletePostId);
            redirectAndExit("list-posts.php");
        }
    }
}

$pdo = getPDO();
$posts = getAllPosts($pdo);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>A simple blog | Blog posts</title>
        <?php require "partials/head.php" ?>
    </head>
    <body>
        <header>
            <?php require "partials/header.php" ?>
        </header>

        <main>
            <h1>Post list</h1>

            <p>You have <?= count($posts) ?> posts.</p>

            <form method="post">
                <table id="post-list">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Creation date</th>
                            <th>Comments</th>
                            <th />
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td>
                                    <a href="view-post.php?post_id=<?php echo $post['id']?>"
                                    ><?= htmlEscape($post["title"]) ?></a>
                                </td>
                                <td>
                                    <?= htmlEscape($post["created_at"]) ?>
                                </td>
                                <td>
                                    <?= $post["comment-count"]?>
                                </td>
                                <td>
                                    <a href="edit-post.php?post_id=<?= $post["id"] ?>">Edit</a>
                                </td>
                                <td>
                                    <input
                                        type="submit"
                                        name="delete-post[<?= $post["id"]?>]"
                                        value="Delete"
                                    />
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </main>
    </body>
</html>
