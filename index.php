<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>A Basic Blog</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
<body>
    <header>
        <h1>A Basic Blog</h1>
        <p>A summary paragraph about what this blog is about.</p>
    </header>

    <main>
        <?php for ($postId = 1; $postId <= 4; $postId++) : ?>
            <article>
                <h2>Article <?= $postId ?> Title</h2>
                <div>dd MON YYYY</div>
                <p>A summary paragraph about Article <?= $postId ?>.</p>
                <p>
                    <a href="#">Read more...</a>
                </p>
            </article>
        <?php endfor ?>
    </main>
</body>
</html>
