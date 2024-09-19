<?php
session_start();
require("config/functions.php");

$error = '';

if (isset($_POST["loginBtn"])) {
    $email = validateInput($_POST["email"]);
    $password = validateInput($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM admins WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($connect, $query);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $hashed_password = $row["password"];

                if (!password_verify($password, $hashed_password)) {
                    redirect("login.php", "Invalid Password!!");
                }

                if ($row["is_ban"] == 1) {
                    redirect("login.php", "You are banned. You cannot login to the admin dashboard!!");
                }

                // Set session variables
                $_SESSION["loggedIn"] = true;
                $_SESSION["loggedInUser"] = [
                    "userid" => $row["id"],
                    "useremail" => $row["email"],
                    "username" => $row["name"],
                    "userphone" => $row["phonenumber"]
                ];

                // Redirect to admin/index.php
                redirect("admin/index.php", "Logged In Successfully");
            } else {
                redirect("login.php", "User with this email does not exist");
            }
        } else {
            redirect("login.php", "Something Went Wrong!!");
        }
    } else {
        redirect("login.php", "All Fields are mandatory");
    }
}

// Include header
include("includes/header.php");

// Check if already logged in and redirect
if (isset($_SESSION["loggedInUser"])) {
    echo "<script>window.location.href = 'admin/index.php'</script>";
    exit();
}

// Display any alert messages
alertMessage();
?>

<div class="py-5 bg-light">
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4">
                    <div class="p-5">
                        <h4 class="text-dark mb-3">Sign into your POS System</h4>
                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="email">Enter Your Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password">Enter Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="my-3">
                                <button class="btn btn-primary w-100 mt-2" name="loginBtn" type="submit">
                                    Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
