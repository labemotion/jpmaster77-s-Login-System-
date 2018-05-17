<?php
/**
 * Register.php
 * 
 * Displays the registration form if the user needs to sign-up,
 * or lets the user know, if he's already logged in, that he
 * can't register another name.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 2, 2009 by Ivan Novak
 */
include("include/session.php");
include 'header.php';
?>

</head>
<body>
    <div class="container">
        <?php
        /**
         * The user is already logged in, not allowed to register.
         */
        if ($session->logged_in) {
            echo "<h1>Registered</h1>";
            echo "<p>We're sorry <b>$session->username</b>, but you've already registered. "
            . "<a href=\"main.php\">Main</a>.</p>";
        }
        /**
         * The user has submitted the registration form and the
         * results have been processed.
         */ else if (isset($_SESSION['regsuccess'])) {
            /* Registration was successful */
            if ($_SESSION['regsuccess']) {
                echo "<h1>Registered!</h1>";
                if (EMAIL_WELCOME) {
                    echo "<p>Thankyou <b>" . $_SESSION['reguname'] . "</b>, you have been sent a confirmation email which should be arriving shortly.  Please confirm your registration before you continue.<br />Back to <a href='main.php'>Main</a></p>";
                } else {
                    echo "<p>Thank you <b>" . $_SESSION['reguname'] . "</b>, your information has been added to the database, "
                    . "you may now <a href=\"main.php\">log in</a>.</p>";
                }
            }
            /* Registration failed */ else {
                echo "<h1>Registration Failed</h1>";
                echo "<p>We're sorry, but an error has occurred and your registration for the username <b>" . $_SESSION['reguname'] . "</b>, "
                . "could not be completed.<br>Please try again at a later time.</p>";
            }
            unset($_SESSION['regsuccess']);
            unset($_SESSION['reguname']);
        }
        /**
         * The user has not filled out the registration form yet.
         * Below is the page with the sign-up form, the names
         * of the input fields are important and should not
         * be changed.
         */ else {
            ?>

            <h1>Register</h1>
            <?php
            if ($form->num_errors > 0) {
                echo "<td><font size=\"2\" color=\"#ff0000\">" . $form->num_errors . " error(s) found</font></td>";
            }
            ?>
            <div id="register">
                <form class="form-horizontal" action="process.php" method="POST">
                    <fieldset>

                        <!-- Form Name -->
                        <legend>Create new user</legend>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="name">Name</label>  
                            <div class="col-md-4">
                                <input id="name" name="name" placeholder="Name" class="form-control input-md" type="text" maxlength="30" value="<?php echo $form->value("name"); ?>">
                                <span class="help-block"><?php echo $form->error("name"); ?></span>
                            </div>
                        </div>                       
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user">Username</label>  
                            <div class="col-md-4">
                                <input id="user" name="user" placeholder="Username" class="form-control input-md" type="text" maxlength="30" value="<?php echo $form->value("user"); ?>">
                                <span class="help-block"><?php echo $form->error("user"); ?></span>
                            </div>
                        </div>
                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="pass">Password</label>
                            <div class="col-md-4">
                                <input id="password" name="pass" placeholder="Password" class="form-control input-md" type="password" maxlength="30" value="<?php echo $form->value("pass"); ?>">
                                <span class="help-block"><?php echo $form->error("name"); ?></span>
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="email">Email</label>  
                            <div class="col-md-4">
                                <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text" maxlength="50" value="<?php echo $form->value("email"); ?>">
                                <span class="help-block"><?php echo $form->error("name"); ?></span>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="subjoin"></label>
                            <div class="col-md-4">
                                <input type="hidden" id="subjoin" name="subjoin" value="1"><input type="submit" value="Join!" class="btn btn-primary">                                
                            </div>
                        </div>
                    </fieldset>
                    <p><a href="main.php">[Back to Main]</a></p>
                </form>              
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
