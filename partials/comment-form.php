<?php ?>
<hr />

<?php if ($errors): ?>
    <div style="border: 1px solid #ff6666; padding: 6px;">
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
           <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<h3>Add your comment</h3>

<form method="post">
    <p>
        <label for="comment-name">Name:</label>
        <div>
            <input
                type="text"
                id="comment-name"
                name="comment-name"
                value="<?= htmlEscape($commentData["name"]) ?>"
                required />
        </div>
    </p>
    <p>
        <label for="comment-website">Website:</label>
        <div>
            <input type="text"
                   id="comment-website"
                   value="<?= htmlEscape($commentData["website"]) ?>"
                   name="comment-website"
                   required
            />
        </div>
    </p>
    <p>
        <label for="comment-text">Comment:</label>
        <div>
        <textarea id="comment-text"
                  name="comment-text"
                  rows="8"
                  cols="70"
                  required>
            <?= htmlEscape($commentData["text"])?>
        </textarea>
        </div>
    </p>

    <input type="submit" value="Submit comment" />
</form>