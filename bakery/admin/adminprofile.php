<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['fosaid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['submit'])) {
    $adminid = $_SESSION['fosaid'];
    $adminname = $_POST['adminname'];
    $mobno = $_POST['mobilenumber'];
    $email = $_POST['email'];

    $query = mysqli_query($con, "UPDATE tbladmin SET AdminName='$adminname', MobileNumber='$mobno', Email='$email' WHERE ID='$adminid'");
    if ($query) {
        header("Location: adminprofile.php?status=success");
        exit();
    } else {
        header("Location: adminprofile.php?status=error");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bakery House || Profile</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom Popup Handler -->
    <script src="js/popup-handler.js"></script>
</head>

<body>
    <div id="wrapper">
        <?php include_once('includes/leftbar.php'); ?>

        <div id="page-wrapper" class="gray-bg">
            <?php include_once('includes/header.php'); ?>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Admin Profile</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a>Profile</a></li>
                        <li class="breadcrumb-item active"><strong>Update</strong></li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <?php
                                $adminid = $_SESSION['fosaid'];
                                $ret = mysqli_query($con, "SELECT * FROM tbladmin WHERE ID='$adminid'");
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>
                                    <form method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Admin Name:</label>
                                            <div class="col-sm-10">
                                                <input name='adminname' class="form-control" value="<?php echo $row['AdminName']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">User Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="username" readonly value="<?php echo $row['UserName']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Mobile Number:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="mobilenumber" required value="<?php echo $row['MobileNumber']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" required value="<?php echo $row['Email']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Registration Date:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" readonly value="<?php echo $row['AdminRegdate']; ?>">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        // Trigger SweetAlert2 popup if status is present
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        if (status) {
            showPopup(status); // Comes from popup-handler.js
        }
    </script>
</body>

</html>