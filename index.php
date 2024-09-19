<?php 
session_start(); 
include("config/functions.php"); 
include("includes/header.php"); 
include("includes/navbar.php"); 
?>

<!-- Welcome heading -->
<div class="container text-center mt-4 mb-4">
    <h1>Welcome to the POS System</h1>
</div>

<?php if (isset($_SESSION["loggedIn"])): ?>
    <!-- User is logged in -->
    <div class="container text-center">
        <h2>Hello, <?= htmlspecialchars($_SESSION['loggedInUser']['username']); ?>!</h2>
        <p>You are now logged in. Enjoy using the system.</p>
    </div>
<?php else: ?>
    <!-- User is not logged in -->
    <div class="container text-center">
        <h2>Please Log In</h2>
        <a class="btn btn-success btn-lg" href="login.php">Login</a>
    </div>
<?php endif; ?>

<?php include("includes/footer.php"); ?>
