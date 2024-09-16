<?php
include("includes/header.php");
include "../config/functions.php";

if (isset($_POST["updateAdmin"])) {
    $adminId = validateInput($_POST['adminid']); // Ensure this is a string

    $adminData = getById("admins", $adminId);

    if ($adminData["status"] != 200) {
        redirect("edit-admin.php?id=$adminId", "Admin not found or invalid ID!");
    }

    $name = validateInput($_POST["name"]); // Ensure these are strings
    $email = validateInput($_POST["email"]);
    $password = $_POST["password"];
    $phonenumber = validateInput($_POST["phonenumber"]);
    $isban = isset($_POST["ban"]) ? 1 : 0;

    if ($password != "") {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $password_hashed = $adminData['data']['password'];
    }

    if (!empty($name) && !empty($email)) {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password_hashed,
            'phonenumber' => $phonenumber,
            'is_ban' => $isban,
        ];

        // Update data in the database
        $updateResult = updateValues("admins", $data, $adminId);

        if ($updateResult) {
            redirect('admins.php?id=' . $adminId, 'Admin Edited Successfully');
        } else {
            redirect('admins.php.php?id=' . $adminId, 'Update Failed. Please try again.');
        }
    } else {
        redirect("edit-admin.php?id=$adminId", "Please fill all required fields.");
    }
}
?>

<div id="layoutSidenav">
    <?php include("includes/sidenav.php") ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-5 shadow">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Admin
                            <a href="admins.php" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="edit-admin.php" method="POST">
                            <?php
                            if (isset($_GET["id"]) && !empty($_GET["id"])) {
                                $adminid = validateInput($_GET["id"]);
                                $adminData = getById('admins', $adminid);

                                if ($adminData['status'] == 200) {
                                    $admin = $adminData['data'];
                                    alertmessage();
                                    ?>
                                    <input type="hidden" name="adminid" value="<?= htmlspecialchars($admin['id'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                                    <div class="col-12">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="<?= htmlspecialchars($admin['name'], ENT_QUOTES, 'UTF-8') ?>" required>
                                        <div class="invalid-feedback">
                                            Please provide a name.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?= htmlspecialchars($admin['email'], ENT_QUOTES, 'UTF-8') ?>" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid email address.
                                        </div>
                                    </div>
                                    <!-- Removed the password field -->
                                    <div class="col-md-4">
                                        <label for="phonenumber" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phonenumber" name="phonenumber"
                                            value="<?= htmlspecialchars($admin['phonenumber'], ENT_QUOTES, 'UTF-8') ?>">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="ban" name="ban"
                                                <?= $admin['is_ban'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="ban">
                                                Is Banned
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary" name="updateAdmin">Update</button>
                                    </div>
                                    <?php
                                } else {
                                    echo '<h5>' . htmlspecialchars($adminData['message'], ENT_QUOTES, 'UTF-8') . '</h5>';
                                }
                            } else {
                                echo '<h5>No Data Found</h5>';
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <?php include("includes/footer.php") ?>
    </div>
</div>
