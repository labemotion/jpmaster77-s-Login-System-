<?php
/**
 * Main.php
 *
 * This is an example of the main page of a website. Here
 * users will be able to login. However, like on most sites
 * the login form doesn't just have to be on the main page,
 * but re-appear on subsequent pages, depending on whether
 * the user has logged in or not.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: June 15, 2011 by Ivan Novak
 */
include("include/session.php");
$page = "main.php";
include 'header.php';
?>


<script type="text/javascript">
    $(document).ready(function () {
<?php
if (isset($_GET['hash'])) {
    $hash = $_GET['hash'];
} else {
    $hash = '';
}
?>
        jp_hash = ('<?php echo $hash; ?>'.length) ? '<?php echo $hash; ?>' : window.location.hash;
        if (jp_hash) {
            $.ajax({
                type: "POST",
                url: 'process.php',
                data: 'login_with_hash=1&hash=' + jp_hash,
                success: function (msg) {
                    if (msg) {
                        alert(msg);
                        window.location.href = "main.php";
                    } else {
                        alert("Invalid Hash");
                    }
                }
            });
        }
    });
</script>
</head>
<body>




    <?php
    /**
     * User has already logged in, so display relavent links, including
     * a link to the admin center if the user is an administrator.
     */
    if ($session->logged_in) {
        include 'navbar.php';
        ?>
        

        <div class="container-fluid">
            <h1 class="clear">Logged In</h1>
            <p>Welcome <b><?php echo $session->username; ?></b>, you are logged in.</p>
        </div>
        <?php
    } else {
        ?>
        <div class="container-fluid">
            <div id="login">
                <h1>Login</h1>
                <?php
                /**
                 * User not logged in, display the login form.
                 * If user has already tried to login, but errors were
                 * found, display the total number of errors.
                 * If errors occurred, they will be displayed.
                 */
                if ($form->num_errors > 0) {
                    echo "<font size=\"2\" color=\"#ff0000\">" . $form->num_errors . " error(s) found</font>";
                }
                ?>

                <form class="form-horizontal" action="process.php" method="POST">
                    <fieldset>
                        <!-- Form Name -->
                        <legend>Access</legend>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="username">Username</label>  
                            <div class="col-md-4">
                                <input id="user" name="user" placeholder="Username" class="form-control input-md" type="text" maxlength="30" value="<?php echo $form->value("user"); ?>">
                                <span class="help-block"><?php echo $form->error("user"); ?></span>
                            </div>
                        </div>
                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="passwor">Password</label>
                            <div class="col-md-4">
                                <input id="password" name="pass" placeholder="Password" class="form-control input-md" type="password" maxlength="30" value="<?php echo $form->value("pass"); ?>">
                                <span class="help-block"><?php echo $form->error("name"); ?></span>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="sublogin"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="subjoin" name="sublogin" value="1"><input type="submit" value="Login" class="btn btn-primary">                                
                            </div>
                        </div>
                        <!-- Multiple Checkboxes -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="remember">Remember me</label>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label for="remember-0">
                                        <input name="remember" id="remember-0" value="1" type="checkbox"  <?php
                                        if ($form->value("remember") != "") {
                                            echo "checked";
                                        }
                                        ?>>
                                        Remember me next time
                                    </label>
                                </div>
                            </div>
                        </div>         
                        <div class="form-group">
                            <p><br />[<a href="forgotpass.php">Forgot Password?</a>]</p>
                            <p>Not registered? <a href="register.php">Sign-Up!</a></p>
                            <?php
                            if (EMAIL_WELCOME) {
                                echo "<p>Do you need a Confirmation email? <a href='valid.php'>Send!</a></p>";
                            }
                            ?>
                        </div>
                    </fieldset>
                </form>
            </div><!-- #login -->
        </div>
        <?php
    }

    /**
     * Just a little page footer, tells how many registered members
     * there are, how many users currently logged in and viewing site,
     * and how many guests viewing site. Active users are displayed,
     * with link to their user information.
     */
    ?>
    <div class="container-fluid">
        <div id="footer"><br />
            <p><b>Member Total:</b><?php echo $database->getNumMembers(); ?>
                <br>There are <?php echo $database->num_active_users; ?> registered members and <?php $database->num_active_guests; ?> guests viewing the site.<br><br>
                <?php
                include("include/view_active.php");
                ?>
            </p>
        </div><!-- #footer -->

    </div><!-- #main -->
</body>
</html>
