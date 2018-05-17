<?php
/**
 * You can gather additional details by following 
 * the tutorial posted at:
 * 
 * http://ivannovak.com/email-account-activation/
 *
 * Author:  Ivan Novak
 * Last Updated: August 2, 2009 by Ivan Novak
 */
include("include/session.php");
global $database;
include 'header.php';
?>


</head>
<body>

    <div class="container-fluid">

        <?php
        /*
         * If the someone accesses this page without the correct variables
         * passed, assume they are want to fill out a form asking for a 
         * confirmation email.
         */
        if (!(isset($_GET['qs1']) && isset($_GET['qs2']))) {
            ?>
            <div id="email">
                <h1>Send Confirmation Email</h1>
                <form action="process.php" method="POST">
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
                        <label class="col-md-4 control-label" for="password">Password</label>
                        <div class="col-md-4">
                            <input id="password" name="pass" placeholder="Password" class="form-control input-md" type="password" maxlength="30" value="<?php echo $form->value("pass"); ?>">
                            <span class="help-block"><?php echo $form->error("name"); ?></span>
                        </div>
                    </div>
                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="subConfirm"></label>
                        <div class="col-md-4">
                            <input type="hidden" id="subConfirm" name="subConfirm" value="1"><input type="submit" value="Send!" class="btn btn-primary">                                
                        </div>
                    </div>

                    <p><a href="main.php">Back to Main</a></p>
                </form>
            </div>
            <?php
        }

        /* If the correct variables are passed, define and check them. */ else {

            $v_username = $_GET['qs1'];
            $v_userid = $_GET['qs2'];
            $field = 'valid';

            $q = "SELECT userid from " . TBL_USERS . " WHERE username='$v_username'";
            $query = $database->query($q) or die(mysqli_error());
            $query = mysqli_fetch_array($query);


            /*
             * if the userid associated with the passed username does not
             * exactly equal the passed userid automatically redirect
             * them to the main page.
             */
            if (!($query['userid'] == $v_userid)) {
                echo "confirmation failed, username and UIN do not match";
            }
            /*
             * If the userid's match go ahead and change the value in
             * the valid field to 1, display a 'success' message, and
             * redirect to main.php.
             */ else {

                $database->updateUserField($v_username, $field, '1') or die(mysqli_error());

                echo $v_username . "'s account has been successfully verified.  You can now <a href='main.php'>login</a>.";
            }
        }
        ?>
    </div>
</body>
</html>