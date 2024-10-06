<div class="top-menu">
    <div class="menu-options">
        <?php if (isLoggedIn()): ?>
            <a href="logout.php">Log out</a>
        <?php else: ?>
            <a href="login.php">Log in</a>
        <?php endif; ?>
    </div>
</div>

<a href="index.php">
    <h1>A Basic Blog</h1>
</a>
<p>A summary paragraph about what this blog is about.</p>