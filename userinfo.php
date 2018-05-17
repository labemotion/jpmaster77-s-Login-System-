<?php
/**
 * UserInfo.php
 *
 * This page is for users to view their account information
 * with a link added for them to edit the information.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 2, 2009 by Ivan Novak
 */
include("include/session.php");
$page = "userinfo.php";
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
            /* Requested Username error checking */
            $req_user = trim($_GET['user']);
            if (!$req_user || strlen($req_user) == 0 ||
                    !preg_match("/^([0-9a-z])+$/i", $req_user) ||
                    !$database->usernameTaken($req_user)) {
                die("Username not registered");
            }

            /* Logged in user viewing own account */
            if (strcmp($session->username, $req_user) == 0) {
                echo "<h1>My Account</h1>";
            }
            /* Visitor not viewing own account */ else {
                echo "<h1>User Info</h1>";
            }

            /* Display requested user information */
            $req_user_info = $database->getUserInfo($req_user);

            /* Name */
            echo "<p><b>Name: " . $req_user_info['name'] . "</b><br />";

            /* Username */
            echo "<p><b>Username: " . $req_user_info['username'] . "</b><br />";

            /* Email */
            echo "<b>Email:</b> " . $req_user_info['email'] . "</p>";

            /**
             * Note: when you add your own fields to the users table
             * to hold more information, like homepage, location, etc.
             * they can be easily accessed by the user info array.
             *
             * $session->user_info['location']; (for logged in users)
             *
             * ..and for this page,
             *
             * $req_user_info['location']; (for any user)
             */
            /* If logged in user viewing own account, give link to edit */
            if (strcmp($session->username, $req_user) == 0) {
                echo "<a href=\"useredit.php\">Edit Account Information</a><br><br>";
            }

            /* Link back to main */
            echo "[<a href=\"main.php\">Main</a>] ";


            if ($session->isAdmin()) {
                echo "[<a href=\"admin/admin.php\">Admin Center</a>]&nbsp;";
            }
        }
        ?>
    </div>
</body>
</html>
