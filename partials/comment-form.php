<?php ?>

<?php if ($errors): ?>
    <div class="error box comment-margin">
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
           <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<h3>Add your comment</h3>

<form method="post" class="comment-form user-form">
    <div>
        <label for="comment-name">Name:</label>
        <div>
            <input
                type="text"
                id="comment-name"
                name="comment-name"
                value="<?= htmlEscape($commentData["name"]) ?>"
                required />
        </div>
    </div>
    <div>
        <label for="comment-website">Website:</label>
        <div>
            <input type="text"
                   id="comment-website"
                   value="<?= htmlEscape($commentData["website"]) ?>"
                   name="comment-website"
                   required
            />
        </div>
    </div>
    <div>
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
    </div>

    <div>
        <input type="submit" value="Submit comment" />
    </div>
</form>