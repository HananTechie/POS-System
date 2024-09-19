<?php include("authentication.php") ?>
<?php
include("../config/functions.php");

if (isset($_POST["saveAdmin"])) {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phonenumber = $_POST["phonenumber"];
    $isban = isset($_POST["ban"]) ? 1 : 0;  // Check if the 'ban' checkbox is checked

    // Validate required fields
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Check if the email already exists
        $query = "SELECT * FROM admins WHERE email='$email'";
        $result = mysqli_query($connect, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                redirect("create-admins.php", "User with this email already exists");
            } else {
                // Hash the password
                $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

                // Prepare data for insertion
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $bcrypt_password,
                    'phonenumber' => $phonenumber,
                    'is_ban' => $isban,
                ];

                // Insert data into the database
                $insertResult = insert("admins", $data);

                if ($insertResult) {
                    redirect('admins.php', 'Admin Created Successfully');
                } else {
                    redirect('create-admins.php', 'Something Went Wrong');
                }
            }
        } else {
            redirect('create-admins.php', 'Database query failed');
        }
    } else {
        redirect("create-admins.php", "Please fill in the required fields!");
    }
}
 include("includes/header.php") ?>

<div id="layoutSidenav">
    <?php include("includes/sidenav.php") ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-5 shadow">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Add Admins
                            <a href="admins.php" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="create-admins.php" method="POST">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">
                                    Please provide a name.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Please provide a valid email address.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback">
                                    Please provide a password.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="phonenumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ban" name="ban">
                                    <label class="form-check-label" for="ban">
                                        Is Ban
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="saveAdmin">Add Admin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <?php include("includes/footer.php") ?>
    </div>
</div>