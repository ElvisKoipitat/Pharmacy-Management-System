<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>
<?php include('./constant/connect.php'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New User</h4>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $username = mysqli_real_escape_string($connect, $_POST['username']);
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure hashing of password
                    $email = mysqli_real_escape_string($connect, $_POST['email']);

                    $insertSql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
                    if (mysqli_query($connect, $insertSql)) {
                        echo "<div class='alert alert-success'>User added successfully!</div>";
                        echo "<script>setTimeout(function(){ window.location.href = 'add-user.php'; }, 1500);</script>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . mysqli_error($connect) . "</div>";
                    }
                }
                ?>

                <form method="POST" action="add-user.php">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Add User</button>
                    <a href="dashboard.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>