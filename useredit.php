<?php
/**
 * UserEdit.php
 *
 * This page is for users to edit their account information
 * such as their password, email address, etc. Their
 * usernames can not be edited. When changing their
 * password, they must first confirm their current password.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 2, 2009 by Ivan Novak
 */
include("include/session.php");
$page = "useredit.php";
include 'header.php';
?>


</head>
<body>
    <?php
    if ($session->logged_in) {
        include 'navbar.php';
        ?>
        <div class="container-fluid">
            <?php
            /**
             * User has submitted form without errors and user's
             * account has been edited successfully.
             */
            if (isset($_SESSION['useredit'])) {
                unset($_SESSION['useredit']);

                echo "<h1>User Account Edit Success!</h1>";
                echo "<p><b>$session->username</b>, your account has been successfully updated. "
                . "<a href=\"main.php\">Main</a>.</p>";
            } else {
                ?>

                <?php
                /**
                 * If user is not logged in, then do not display anything.
                 * If user is logged in, then display the form to edit
                 * account information, with the current email address
                 * already in the field.
                 */
                if ($session->logged_in) {
                    ?>

                    <h1>User Account Edit : <?php echo $session->username; ?></h1>
                    <?php
                    if ($form->num_errors > 0) {
                        echo "<td><font size=\"2\" color=\"#ff0000\">" . $form->num_errors . " error(s) found</font></td>";
                    }
                    ?>
                    <div id="userupdate">
                        <form action="process.php" method="POST">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="banuser">Name:</label>  
                                <div class="col-md-4">
                                    <input class="left" type="text" name="name" maxlength="50" value="<?php
                                    if ($form->value("name") == "") {
                                        echo $session->userinfo['name'];
                                    } else {
                                        echo $form->value("name");
                                    }
                                    ?>">
                                           <?php echo $form->error("name"); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="curpass">Current Password:</label>  
                                <div class="col-md-4">

                                    <input type="password" name="curpass" maxlength="30" value="<?php echo $form->value("curpass"); ?>">
                                    <?php echo $form->error("curpass"); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="newpass">New Password:</label>  
                                <div class="col-md-4">                       
                                    <input class="left" type="password" name="newpass" maxlength="30" value="<?php echo $form->value("newpass"); ?>">
                                    <?php echo $form->error("newpass"); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">Email:</label>  
                                <div class="col-md-4">

                                    <input class="left" type="text" name="email" maxlength="50" value="<?php
                                    if ($form->value("email") == "") {
                                        echo $session->userinfo['email'];
                                    } else {
                                        echo $form->value("email");
                                    }
                                    ?>">
                                           <?php echo $form->error("email"); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="subedit" value="1" />
                                <input type="submit" value="Edit Account" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                    <?php
                    echo "[<a href=\"main.php\">Main</a>] ";
                    echo "[<a href=\"userinfo.php?user=$session->username\">My Account</a>]&nbsp;";
                }
            }
            ?>
        </div>
        <?php
    }
    ?>

</body>
</html>
