<?php
/**
 * Admin.php
 *
 * This is the Admin Center page. Only administrators
 * are allowed to view this page. This page displays the
 * database table of users and banned users. Admins can
 * choose to delete specific users, delete inactive users,
 * ban users, update user levels, etc.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 2, 2009 by Ivan Novak
 */
include("../include/session.php");
include '../header.php';
?>
</head>
<body>    
    <?php

    /**
     * displayUsers - Displays the users database table in
     * a nicely formatted html table.
     */
    function displayUsers() {
        global $database;
        $q = "SELECT username,userlevel,email,timestamp, parent_directory "
                . "FROM " . TBL_USERS . " ORDER BY userlevel DESC,username";
        $result = $database->query($q);
        /* Error occurred, return given name by default */
        $num_rows = mysqli_num_rows($result);
        if (!$result || ($num_rows < 0)) {
            echo "Error displaying info";
            return;
        }
        if ($num_rows == 0) {
            echo "Database table empty";
            return;
        }
        /* Display table contents */
        echo "<table class='table' align='left' border='1' cellspacing='0' cellpadding='3'> \n";
        echo "<thead><td><b>Username</b></td> \n"
        . "<td><b>Level</b></td> \n"
        . "<td><b>Email</b></td> \n"
        . "<td><b>Last Active</b></td> \n"
        . "<td><b>Group</b></td> \n"
        . "</thead>\n";

        for ($i = 0; $i < $num_rows; $i++) {
            mysqli_data_seek($result, $i);
            $row = mysqli_fetch_row($result);
            $uname = $row[0]; //username
            $ulevel = $row[1]; //userlevel
            $email = $row[2]; //email
            $time = $row[3]; //timestamp
            $parent = $row[4]; //parent directory
            echo "<tr><td>$uname</td> \n"
            . "<td>$ulevel</td> \n"
            . "<td>$email</td> \n"
            . "<td>$time</td> \n"
            . "<td>$parent</td> \n"
            . "</tr> \n";
        }
        echo "</table><br>\n";
    }

    /**
     * displayBannedUsers - Displays the banned users
     * database table in a nicely formatted html table.
     */
    function displayBannedUsers() {
        global $database;
        $q = "SELECT username,timestamp "
                . "FROM " . TBL_BANNED_USERS . " ORDER BY username";
        $result = $database->query($q);
        /* Error occurred, return given name by default */
        $num_rows = mysqli_num_rows($result);
        if (!$result || ($num_rows < 0)) {
            echo "Error displaying info";
            return;
        }
        if ($num_rows == 0) {
            echo "<p class='grid_12'>Database table empty</p>";
            return;
        }
        /* Display table contents */
        echo "<table class='table' id='display'> \n";
        echo "<thead><tr colspan='2'>Username</td><td colspan='2'>Time Banned</td></thead> \n";
        echo '<tbody> \n';
        for ($i = 0; $i < $num_rows; $i++) {
            $uname = mysqli_result($result, $i, "username");
            $time = mysqli_result($result, $i, "timestamp");

            echo "<tr><td colspan='2'>" . $uname . "</td> \n"
            . "<td colspan='2'>" . $time . "</td> \n"
            . "</tr> \n";
        }
        echo "</tbody> \n";
        echo "</table> \n";
    }

    /**
     * User not an administrator, redirect to main page
     * automatically.
     */
    if (!$session->isAdmin()) {
        header("Location: ../main.php");
    } else {
        /**
         * Administrator is viewing page, so display all
         * forms.
         */
        include '../navbar.php';
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1>Admin Center</h1>
                    <p>
                        <font size="4">Logged in as <b><?php echo $session->username; ?></b></font>
                    </p>
                    <p>
                        Back to [<a href="../main.php">Main Page</a>]
                    </p>

                    <?php
                    if ($form->num_errors > 0) {
                        echo "<font size='4' color='#ff0000'>"
                        . "!*** Error with request, please fix</font><br><br>";
                    }

                    /**
                     * Display Users Table
                     */
                    ?>
                </div>
            </div>
            <div class="row">
                <h3>Users Table Contents:</h3>
                <?php
                displayUsers();
                ?>
            </div>
            <hr>
            <?php
            /**
             * Update User Level
             */
            ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="update">
                        <h3>Update User Level</h3>
                        <?php echo $form->error("upduser"); ?>
                        <form class="form-horizontal" action="adminprocess.php" method="POST">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="deluser">Username:</label>  
                                <div class="col-md-4">
                                    <input type="text" name="upduser" maxlength="30" value="<?php echo $form->value("upduser"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="deluser">Level:</label>  
                                <div class="col-md-4">

                                    <select name="updlevel">
                                        <option value="1">1</option>
                                        <option value="5">5</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="subupdlevel" value="1">
                                <input type="submit" value="Update Level" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>


                <?php
                /**
                 * Delete User
                 */
                ?>
                <div class="col-md-4">
                    <div class="update">
                        <h3>Delete User</h3>
                        <?php echo $form->error("deluser"); ?>
                        <form class="form-horizontal" action="adminprocess.php" method="POST">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="deluser">Username:</label>  
                                <div class="col-md-4">
                                    <input type="text" name="deluser" maxlength="30" value="<?php echo $form->value("deluser"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="subdeluser" value="1">
                                <input type="submit" value="Delete User" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                /**
                 * Delete Inactive Users
                 */
                ?>
                <div class="col-md-4">
                    <div class="update">
                        <h3>Delete Inactive Users</h3>
                        This will delete all users (not administrators), who have not logged in to the site<br>
                        within a certain time period. You specify the days spent inactive.<br><br>
                        <form class="form-horizontal" action="adminprocess.php" method="POST">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="inactdays">Days:</label>  
                                <div class="col-md-4">
                                    <select name="inactdays">
                                        <option value="3">3</option>
                                        <option value="7">7</option>
                                        <option value="14">14</option>
                                        <option value="30">30</option>
                                        <option value="100">100</option>
                                        <option value="365">365</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="subdelinact" value="1">
                                <input type="submit" value="Delete All Inactive" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <?php
                /**
                 * Ban User
                 */
                ?>
                <div class="col-md-4">
                    <div class="update">
                        <h3>Ban User</h3><?php echo $form->error("banuser"); ?>
                        <form class="form-horizontal" action="adminprocess.php" method="POST">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="banuser">Username:</label>  
                                <div class="col-md-4">
                                    <input type="text" name="banuser" maxlength="30" value="<?php echo $form->value("banuser"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="subbanuser" value="1">
                                <input type="submit" value="Ban User" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>

                <?php
                /**
                 * Display Banned Users Table
                 */
                ?>
                <div class="col-md-4">
                    <h3>Banned Users Table Contents:</h3>
                    <?php
                    displayBannedUsers();
                    ?>
                </div>
                <?php
                /**
                 * Delete Banned User
                 */
                ?>
                <div class="col-md-4">
                    <div class="update">
                        <h3>Delete Banned User</h3><?php echo $form->error("delbanuser"); ?>
                        <form class="form-horizontal" action="adminprocess.php" method="POST">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="delbanuser">Username:</label>  
                                <div class="col-md-4">
                                    <input type="text" name="delbanuser" maxlength="30" value="<?php echo $form->value("delbanuser"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="subdelbanned" value="1">
                                <input type="submit" value="Delete Banned User" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <p>
                        Back to [<a href="../main.php">Main Page</a>]
                    </p>
                </div>
            </div>
        </div>

    </body>
    </html>
    <?php
}
?>

