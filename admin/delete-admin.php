<?php
include("../config/functions.php");

$paraResultId = checkParamsID("id");
if (is_numeric($paraResultId)) {
    $adminId = validateInput($paraResultId);

    $admin = getById("admins", $paraResultId);

    if ($admin["status"] == 200) {
        $adminDeleteResult = delete("admins" , $adminId);

        if($adminDeleteResult){
            redirect("admins.php", "Admin Deleted Succesfully");
        } else {
            redirect("admins.php", "Something Went Wrong");
        }
    } else {
        redirect("admins.php", admin["message"]);
    }
} else {
    redirect("admins.php", "Something Went Wrong");
}
?>