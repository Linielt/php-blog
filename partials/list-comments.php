<?php ?>

<form
    action="view-post.php?action=delete-comment&amp;post_id=<?php echo $postId?>&amp;"
    method="post"
    class="comment-list"
>
    <h3><?= $commentCount ?> comments</h3>

    <?php foreach (getCommentsForPost($pdo, $postId) as $comment) : ?>
        <div class="comment">
            <div class="comment-metadata">
                Comment from
                <?= htmlEscape($comment["name"]) ?>
                <?= htmlEscape($comment["created_at"]) ?>
                <?php if (isLoggedIn()) : ?>
                    <input type="submit"
                           name="delete-comment[<?= $comment["id"] ?>]"
                           value="Delete"
                    />
                <?php endif; ?>
            </div>
            <div class="comment-body">
                <?= convertNewLinesToParagraphs($comment["text"]) ?>
            </div>
        </div>
    <?php endforeach; ?>
</form>
