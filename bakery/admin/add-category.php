<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
$showPopup = false;
$popupType = "";
$popupMessage = "";

if (strlen($_SESSION['fosaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $category = $_POST['categoryname'];
        $query = mysqli_query($con, "INSERT INTO tblcategory(CategoryName) VALUE('$category')");
        if ($query) {
            $showPopup = true;
            $popupType = "success";
            $popupMessage = "Category has been created successfully!";
        } else {
            $showPopup = true;
            $popupType = "error";
            $popupMessage = "Something went wrong. Please try again.";
        }
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Bakery House</title>

        <!-- Existing Styles -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    </head>

    <body>

        <div id="wrapper">
            <?php include_once('includes/leftbar.php'); ?>

            <div id="page-wrapper" class="gray-bg">
                <?php include_once('includes/header.php'); ?>
                <div class="row border-bottom"></div>

                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Category</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item"><a>Category</a></li>
                            <li class="breadcrumb-item active"><strong>Add</strong></li>
                        </ol>
                    </div>
                </div>

                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-content">

                                    <form id="form" action="#" class="wizard-big" method="post" name="submit">
                                        <fieldset>
                                            <h2>Category</h2>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <input id="categoryname" name="categoryname" type="text" class="form-control required" required="true">
                                                    </div>
                                                    <div class="form-group">
                                                        <p style="text-align: center;">
                                                            <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="text-center" style="margin-top: 20px">
                                                        <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>

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
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>
        <script src="js/plugins/steps/jquery.steps.min.js"></script>
        <script src="js/plugins/validate/jquery.validate.min.js"></script>

        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Show Popup if Triggered -->
        <?php if ($showPopup): ?>
            <script>
                Swal.fire({
                    icon: '<?php echo $popupType; ?>',
                    title: '<?php echo $popupType === "success" ? "Success!" : "Oops!"; ?>',
                    text: '<?php echo $popupMessage; ?>',
                    confirmButtonColor: '<?php echo $popupType === "success" ? "#28a745" : "#d33"; ?>'
                }).then(() => {
                    <?php if ($popupType === "success"): ?>
                        window.location.href = "add-category.php";
                    <?php endif; ?>
                });
            </script>
        <?php endif; ?>

        <script>
            $(document).ready(function() {
                $("#wizard").steps();
                $("#form").steps({
                    bodyTag: "fieldset",
                    onStepChanging: function(event, currentIndex, newIndex) {
                        if (currentIndex > newIndex) return true;
                        if (newIndex === 3 && Number($("#age").val()) < 18) return false;

                        var form = $(this);
                        if (currentIndex < newIndex) {
                            $(".body:eq(" + newIndex + ") label.error", form).remove();
                            $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                        }

                        form.validate().settings.ignore = ":disabled,:hidden";
                        return form.valid();
                    },
                    onFinishing: function(event, currentIndex) {
                        var form = $(this);
                        form.validate().settings.ignore = ":disabled";
                        return form.valid();
                    },
                    onFinished: function(event, currentIndex) {
                        var form = $(this);
                        form.submit();
                    }
                }).validate({
                    errorPlacement: function(error, element) {
                        element.before(error);
                    },
                    rules: {
                        confirm: {
                            equalTo: "#password"
                        }
                    }
                });
            });
        </script>

    </body>

    </html>
<?php } ?>