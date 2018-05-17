<?php
/**
 * author.php
 * You can gather more details by following the
 * Adding Protected Pages to the Jp77 System
 * tutorial found here: http://ivannovak.com/b5rj
 */
include("include/session.php");

if (!$session->isAuthor()) {
    header("Location: main.php");
} else {
    include 'header.php';
    ?>



    </head>
    <body>


        <div class="container">
            <p>you have author privileges</p>
        </div>

    </body>
    </html>
    <?php
}
?>