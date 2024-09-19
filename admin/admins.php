<?php include("includes/header.php") ?>
<?php include("authentication.php") ?>

<?php include("../config/functions.php") ?>

<div id="layoutSidenav">
    <?php include("includes/sidenav.php") ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="card mt-5 shadow">
                    <div class="card-header">
                        <h4 class="mb-0">Admins/Staffs
                            <a href="create-admins.php" class="btn btn-primary float-end">Add Admin</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php alertMessage() ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch all admins
                                    $result = getAll('admins');
                                    
                                    if ($result) {
                                        // Check if there are any rows returned
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['phonenumber']) . '</td>';
                                            echo '<td>' . ($row['is_ban'] ? 'Banned' : 'Active') . '</td>';
                                            echo '<td>
                                                    <a href="edit-admin.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="delete-admin.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</a>
                                                  </td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="6">No records found</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("includes/footer.php") ?>
    </div>
</div>
