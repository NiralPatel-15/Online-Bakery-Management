/*
 * This file is part of the Online Bakery Management System.
 * 
 * Copyright (c) 2025 Niral Patel
 * 
 * This project is licensed under the MIT License.
 * See the LICENSE file for more details.
 */

<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['fosaid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
    $category=$_POST['categoryname'];
     $eid=$_GET['editid'];
     
    $query=mysqli_query($con, "update tblcategory set CategoryName ='$category' where ID=$eid");
    if ($query) {
   
    echo '<script>alert("Category has been updated")</script>';
  }
  else
    {
      echo '<script>alert("Something Went Wrong. Please try again.")</script>';
    }

  
}
  ?>
<!DOCTYPE html>
<html>

<head>

    <title> Bakery House|| Edit Category</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

    <?php include_once('includes/leftbar.php');?>

        <div id="page-wrapper" class="gray-bg">
             <?php include_once('includes/header.php');?>
        <div class="row border-bottom">
        
        </div>
            
        <div class="wrapper wrapper-content animated fadeInRight">
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        
                        <div class="ibox-content">
                           

                            <form id="form" action="#" class="wizard-big" method="post" name="submit">
                                
                                <?php
 $cid=$_GET['editid'];
$ret=mysqli_query($con,"select * from tblcategory where ID='$cid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                                    <fieldset>
                                    <h2>Category</h2>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                
                                                <input id="categoryname" name="categoryname" type="text" class="form-control required" required="true" value="<?php  echo $row['CategoryName'];?>">
                                            </div>
                                            <?php } ?>
                                            <div class="form-group">
                                              <p style="text-align: center;"><button type="submit" name="submit" class="btn btn-primary">Update</button></p>
                                            </div>
                                           
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="text-center">
                                                <div style="margin-top: 20px">
                                                    <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                                </div>
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
                <?php include_once('includes/footer.php');?>

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
        $(document).ready(function(){
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                  
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    
                    if (currentIndex < newIndex)
                    {
                        
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                  
                    form.validate().settings.ignore = ":disabled,:hidden";

                    
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    
                    form.validate().settings.ignore = ":disabled";

                    
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                  
                    form.submit();
                }
            }).validate({
                        errorPlacement: function (error, element)
                        {
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
<?php }  ?>