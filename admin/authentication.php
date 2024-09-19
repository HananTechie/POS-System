<?php
require_once("../config/functions.php");

if (isset($_SESSION["loggedIn"])) {
    $email = validateInput($_SESSION["loggedInUser"]["useremail"]);

    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($connect, "SELECT * FROM admins WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        logoutSession();
        redirect("../login.php", "Access Denied");
        exit();
    } else {
        $row = mysqli_fetch_assoc($result);
        if ($row["is_ban"] == 1) {
            logoutSession();
            redirect("../login.php", "Access Denied");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
} else {
    redirect('../login.php', 'Log In to Continue..');
    exit();
}
?>
