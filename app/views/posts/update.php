<?php
require_once APPROOT . '/views/includes/head.php';
?>
<div class="navbar dark">
    <?php
    require_once APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container center">
    <h1>
        Update Post
    </h1>

    <form action="<?php echo URLROOT . '/public/posts/update/' . $data['post']->id ?>" method="post">
        <div class="form-item">
            <input type="text" name="title" value ="<?php echo $data['post']->title ?>">
            <span class="invalidFeedback">
                <br>
                <?php echo $data['titleError']; ?>
                <br>
            </span>
        </div>

        <div class="form-item">
            <textarea name="body"><?php echo $data['post']->body ?></textarea>
            <span class="invalidFeedback">
                <br>
                <?php echo $data['bodyError']; ?>
                <br>
            </span>
        </div>

        <button class="btn green" name="submit" type="submit">Submit</button>
    </form>
</div>
