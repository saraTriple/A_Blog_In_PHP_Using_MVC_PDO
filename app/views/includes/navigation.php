<nav class="top_nav" >
    <ul>
        <li>
            <a href="<?php echo URLROOT; ?>/public/pages/index">Home</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/public/pages/about">About</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/public/pages/projects">Projects</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/public/posts/index">Blog</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/public/pages/contact">Contact</a>
        </li>
        <li class="btn_login">
            <?php  if(isset($_SESSION['user_id'])) :?>
                <a href="<?php echo URLROOT; ?>/public/users/logout">Log out</a>
            <?php else: ?>
                <a href="<?php echo URLROOT; ?>/public/users/login">Login</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>
