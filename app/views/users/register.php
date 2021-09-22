<?php
require_once APPROOT . '/views/includes/head.php';
?>

<div class="navbar">
    <?php
    require_once  APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container_login">
    <div class="wrapper_login">
        <h2> Register</h2>
        <form action="<?php echo URLROOT ?>/public/users/register" method="post">

            <input type="text" placeholder="Username *" name="username">
            <span class="invalidFeedback">
               <?php echo $data['usernameError']; ?>
                <br>
           </span>

            <input type="text" placeholder="Email *" name="email">
            <span class="invalidFeedback">
               <?php echo $data['emailError']; ?>
                <br>
           </span>

            <input type="password" placeholder="Password *" name="password">
            <span class="invalidFeedback">
               <?php echo $data['passwordError']; ?>
                <br>
           </span>

            <input type="password" placeholder="Confirm Password *" name="confirmPassword">
            <span class="invalidFeedback">
               <?php echo $data['confirmPasswordError']; ?>
                <br>
           </span>

            <button type="submit" id="submit" value="submit"> Submit</button>

            <p class="options">
                Already registered?
                <a href="<?php echo URLROOT;?>/public/users/login"> Log in to your account!</a>
            </p>
        </form>
    </div>
</div>

