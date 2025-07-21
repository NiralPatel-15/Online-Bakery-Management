<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['fosaid'] == 0)) {
    header('location:logout.php');
    exit();
}

// ✅ DELETE HANDLER
if (isset($_GET['delfood'])) {
    $catid = intval($_GET['delfood']);
    $query = mysqli_query($con, "DELETE FROM tblproduct WHERE ID='$catid'");
    if ($query) {
        echo "<script>window.location.href='manage-item.php?status=deleted';</script>";
        exit();
    } else {
        echo "<script>window.location.href='manage-item.php?status=error';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title> Bakery House|| Manage Item</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <?php include_once('includes/leftbar.php'); ?>

        <div id="page-wrapper" class="gray-bg">
            <?php include_once('includes/header.php'); ?>

            <div class="row border-bottom">

            </div>

            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">

                    <div class="col-lg-12">
                        <div class="ibox">

                            <div class="ibox-content">
                                <table class="table table-bordered mg-b-0">
                                    <p style="text-align: center; color: blue;font-size: 30px">Manage Item </p>
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Category Name</th>
                                            <th>Item Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                                        $page_no = $_GET['page_no'];
                                    } else {
                                        $page_no = 1;
                                    }

                                    $total_records_per_page = 12;
                                    $offset = ($page_no - 1) * $total_records_per_page;
                                    $previous_page = $page_no - 1;
                                    $next_page = $page_no + 1;
                                    $adjacents = "2";

                                    $result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM tblproduct");
                                    $total_records = mysqli_fetch_array($result_count);
                                    $total_records = $total_records['total_records'];
                                    $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                    $second_last = $total_no_of_pages - 1; // total page minus 1
                                    $ret = mysqli_query($con, "select * from tblproduct LIMIT $offset, $total_records_per_page");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($ret)) {

                                    ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>

                                                <td><?php echo $row['CategoryName']; ?></td>
                                                <td><?php echo $row['ItemName']; ?></td>
                                                <td><a href="edit-product.php?editid=<?php echo $row['ID']; ?>">Edit</a> |
                                                    <span class="delete-btn text-danger" style="cursor: pointer;" data-id="<?php echo $row['ID']; ?>">Delete</span>

                                            </tr>
                                        <?php
                                        $cnt = $cnt + 1;
                                    } ?>

                                        </tbody>
                                </table>
                                <ul class="pagination">

                                    <li <?php if ($page_no <= 1) {
                                            echo "class='disabled'";
                                        } ?>>
                                        <a <?php if ($page_no > 1) {
                                                echo "href='?page_no=$previous_page'";
                                            } ?>>Previous</a>
                                    </li>

                                    <?php
                                    if ($total_no_of_pages <= 10) {
                                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                            if ($counter == $page_no) {
                                                echo "<li class='active'><a>$counter</a></li>";
                                            } else {
                                                echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                            }
                                        }
                                    } elseif ($total_no_of_pages > 10) {

                                        if ($page_no <= 4) {
                                            for ($counter = 1; $counter < 8; $counter++) {
                                                if ($counter == $page_no) {
                                                    echo "<li class='active'><a>$counter</a></li>";
                                                } else {
                                                    echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                                }
                                            }
                                            echo "<li><a>...</a></li>";
                                            echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                                            echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                                        } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                                            echo "<li><a href='?page_no=1'>1</a></li>";
                                            echo "<li><a href='?page_no=2'>2</a></li>";
                                            echo "<li><a>...</a></li>";
                                            for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                                if ($counter == $page_no) {
                                                    echo "<li class='active'><a>$counter</a></li>";
                                                } else {
                                                    echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                                }
                                            }
                                            echo "<li><a>...</a></li>";
                                            echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                                            echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                                        } else {
                                            echo "<li><a href='?page_no=1'>1</a></li>";
                                            echo "<li><a href='?page_no=2'>2</a></li>";
                                            echo "<li><a>...</a></li>";

                                            for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                if ($counter == $page_no) {
                                                    echo "<li class='active'><a>$counter</a></li>";
                                                } else {
                                                    echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                                }
                                            }
                                        }
                                    }
                                    ?>

                                    <li <?php if ($page_no >= $total_no_of_pages) {
                                            echo "class='disabled'";
                                        } ?>>
                                        <a <?php if ($page_no < $total_no_of_pages) {
                                                echo "href='?page_no=$next_page'";
                                            } ?>>Next</a>
                                    </li>
                                    <?php if ($page_no < $total_no_of_pages) {
                                        echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                                    } ?>
                                </ul>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include_once('includes/footer.php'); ?>

        </div>
    </div>

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>


    <script src="js/plugins/steps/jquery.steps.min.js"></script>


    <script src="js/plugins/validate/jquery.validate.min.js"></script>


    <script>
        $(document).ready(function() {
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function(event, currentIndex, newIndex) {

                    if (currentIndex > newIndex) {
                        return true;
                    }


                    if (newIndex === 3 && Number($("#age").val()) < 18) {
                        return false;
                    }

                    var form = $(this);
                    if (currentIndex < newIndex) {
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    form.validate().settings.ignore = ":disabled,:hidden";


                    return form.valid();
                },
                onStepChanged: function(event, currentIndex, priorIndex) {

                    if (currentIndex === 2 && Number($("#age").val()) >= 18) {
                        $(this).steps("next");
                    }


                    if (currentIndex === 2 && priorIndex === 3) {
                        $(this).steps("previous");
                    }
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // DELETE CONFIRMATION
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you really want to delete this product?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to delete URL
                            window.location.href = `manage-item.php?delfood=${productId}&status=deleted`;
                        }
                    });
                });
            });

            // SUCCESS / ERROR POPUP HANDLER
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            if (status === 'updated') {
                Swal.fire({
                    icon: 'success',
                    title: 'Item Updated',
                    text: 'The item details were successfully updated.',
                });
            } else if (status === 'deleted') {
                Swal.fire({
                    icon: 'success',
                    title: 'Item Deleted',
                    text: 'The item was successfully removed from the menu.',
                });
            } else if (status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                });
            }

            // Clean the URL
            if (status) {
                const newUrl = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>




</body>

</html>