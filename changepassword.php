<?php
include('./constant/layout/head.php');
include('./constant/layout/header.php');
include('./constant/layout/sidebar.php');
include('./constant/connect.php');

session_start();
$userId = $_SESSION['userId'];

$passwordMsg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Fetch user info
    $sql = "SELECT * FROM users WHERE user_id = '$userId'";
    $query = $connect->query($sql);
    $user = $query->fetch_assoc();

    // Validate current password
    if (!password_verify($currentPassword, $user['password'])) {
        $passwordMsg = "<div class='alert alert-danger'>Current password is incorrect.</div>";
    }
    // Check new password match
    elseif ($newPassword !== $confirmPassword) {
        $passwordMsg = "<div class='alert alert-warning'>New passwords do not match.</div>";
    }
    // Proceed with update
    else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql = "UPDATE users SET password = '$hashedPassword' WHERE user_id = '$userId'";

        if ($connect->query($updateSql) === TRUE) {
            $passwordMsg = "<div class='alert alert-success'>Password updated successfully!</div>";
        } else {
            $passwordMsg = "<div class='alert alert-danger'>Error updating password. Please try again.</div>";
        }
    }
}

// Fetch current user info (for displaying username or reuse)
$sql = "SELECT * FROM users WHERE user_id = '$userId'";
$result = $connect->query($sql)->fetch_assoc();
?>

<link rel="stylesheet" href="assets/css/popup_style.css">

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Change Password</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Change Password</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8" style="margin-left: 10%;">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" class="form-horizontal">
                            <fieldset>
                                <legend>Change Password</legend>

                                <?php
                                if (!empty($passwordMsg)) {
                                    echo $passwordMsg;
                                }
                                ?>

                                <div class="form-group">
                                    <label for="password" class="col-sm-3 control-label">Current Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="npassword" class="col-sm-3 control-label">New Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cpassword" class="col-sm-3 control-label">Confirm New Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./constant/layout/footer.php'); ?>
