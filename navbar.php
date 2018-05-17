<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo $url; ?>">PHP Login System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url; ?>">Home</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="userinfo.php?user=<?php echo $session->username; ?>">My Account</a></li>
                <?php
                if (MAIL) {
                    $q = "SELECT mail_id FROM " . TBL_MAIL . " WHERE UserTo = '$session->username' and status = 'unread'";
                    $numUnreadMail = $database->query($q) or die(mysqli_error());
                    $numUnreadMail = mysqli_num_rows($numUnreadMail);

                    echo '<li class="nav-item">
                <a class="nav-link" href="mail.php">You have ' . $numUnreadMail . ' Unread Mail</a></li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="#">Messages</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($session->isAdmin()) {
                    echo '<li class="nav-item">
                <a class="nav-link" href="admin/admin.php">Admin Center</a></li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="process.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</div>