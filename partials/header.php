<div style="float: right">
    <?php if (isLoggedIn()): ?>
        Hello <?= htmlEscape(getAuthUser()) ?>
        <a href="../logout.php">Log out</a>
    <?php else: ?>
        <a href="../login.php">Log in</a>
    <?php endif ?>
</div>

<a href="../index.php">
    <h1>A Basic Blog</h1>
</a>
<p>A summary paragraph about what this blog is about.</p>