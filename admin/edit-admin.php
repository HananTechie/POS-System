<?php
include("includes/header.php");
include "../config/functions.php"; // Ensure the path to functions.php is correct
?>

<div id="layoutSidenav">
    <?php include("includes/sidenav.php") ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-5 shadow">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Admins
                            <a href="admins.php" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="update-admin.php" method="POST">
                            <?php
                            if (isset($_GET["id"]) && !empty($_GET["id"])) {
                                $adminid = validateInput($_GET["id"]);
                                $adminData = getById('admins', $adminid);

                                if ($adminData['status'] == '200') {
                                    $admin = $adminData['data'];
                                    ?>
                                    <div class="col-md-12">
                                        <input type="hidden" name="adminid" id="id" value=<?= $admin['id']; ?> readonly>
                                    </div>
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
                                            value="<?= $admin['phonenumber'] ?>">
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
                                        <input type="hidden" name="id"
                                            value="<?= htmlspecialchars($admin['id'], ENT_QUOTES, 'UTF-8') ?>">
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