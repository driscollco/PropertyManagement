<?php // Example 21-6: checkuser.php
include_once '../functions.php';

if (isset($_POST['email']))
{
    $email = sanitizeString($_POST['email']);

    if (mysqli_num_rows(queryMysql("SELECT * FROM users WHERE email='$email'")))
        echo  "<span class='taken'>&nbsp;&#x2718; " .
              "Sorry, this email is already registered</span>";
    else echo "<span class='available'>&nbsp;&#x2714; " .
              "This email is valid</span>";
}
?>
