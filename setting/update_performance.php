<?php
include 'navigation.php'; // For Navigation Bar
include '../dbFunctions.php'; // Connect to DB
// Check what data are posted or transferred
if (isset($_GET['id'])) {
    $p_id = $_GET['id'];
    if ($p_id != 0 && $p_id != null) {
        $query = "SELECT * FROM `performance` WHERE `performance_id`='$p_id';";
        $doquery = mysqli_query($connection, $query);
        $performance_data = mysqli_fetch_assoc($doquery);
        $p_old_name = $performance_data['performance_name'];
        $p_old_slide = $performance_data['performance_slide_link'];
    }
    if (isset($_GET['update'])) { //Check whether to update or not
        $postcomplete = $_GET['update'];
        if ($postcomplete) {
            // Check Data are really posted or not
            if (isset($_POST)) {
                // Retrieve posted data
                $performance_name = $_POST['performancename'];
                if (isset($_FILES)) {
                    $performance_slide_name = basename($_FILES['performanceslide']['name']);
                    $performance_server_file = $_FILES['performanceslide']['tmp_name'];
                }
                // Only if all datas are complete, add new performance
                if ($performance_name != "") {
                    //Update Statement
                    $update = "UPDATE `performance` SET `performance_name`='$performance_name'";
                    if ($performance_slide_name != "") {
                        $destination = "../performance/" . $performance_slide_name;
                        // Unlink(Delete) old file
                        if (is_file('../performance/' . $p_old_slide)) {
                            unlink('../performance/' . $p_old_slide);
                        }
                        if (move_uploaded_file($performance_server_file, $destination)) {  // Upload the powerpoint
                            // Update statement
                            $update .= ",`performance_slide_link`='$performance_slide_name'";
                        } else {
                            $done = false;
                            $msg = "Sorry. Error uploading the powerpoint file. Please try again.";
                        }
                    }
                    $update .= " WHERE `performance_id`= '$p_id';";
                    $doquery = mysqli_query($connection, $update);
                    if ($doquery) {
                        $done = true;
                        $msg = "The Performance Data  has been successfully updated";
                    } else {
                        $done = false;
                        $msg = "Sorry. An error occurred when updating the performance data";
                    }
                    // Otherwise, show error message
                } else {
                    $done = false;
                    $msg = "You have left to fill something. Please fill the form completely and check carefully before submitting.";
                }
            } else {
                $done = false;
                $msg = "You did not submit anything. Please fill the form completely and check carefully before submitting.";
            }
        }
    }
} else {
    header('location: manage_content.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Setting Page</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="../favicon.ico"/>
        <!-- Javascript for IE png problem, icon effect and time delaying and looping-->
        <script type="text/javascript" src="../iepngfix_tilebg.js"></script>
        <!-- CSS Style -->
        <link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="../css/print.css" type="text/css" media="print">
        <link rel="stylesheet" href="../css/mycss.css" type="text/css" media="screen"/>
        <style type="text/css">
            .container{
                color: #fff;
                width: 1100px;
                height: 800px;
                border-left: 1px solid #fff;
                border-right: 1px solid #fff;
                background: gray;
            }
            p{
                color: #fff;
                font-size: 15px;
            }
            a,a:visited,a:hover,a:active{
                color: #fff;
                font-size: 15px;
                text-decoration: underline;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1 style="padding-top: 30px;">Setting Page</h1>
                <?php echo $menu; ?>
                <hr class="space"/><hr class="space"/>
                <div class="form1">
                    <?php
                    if (isset($_GET['update']) && isset($_POST)) {
                        if ($done) {
                            echo "<h4><i>" . $msg . "</i></h4>";
                    ?>
                            <p>
                                <label>Performance Name   </label>
                        <?php echo $performance_name; ?>
                        </p>
                        <p>
                            <label>Powerpoint slide:  </label>
                        <?php
                            if (isset($_FILES['performanceslide'])) {
                                echo $performance_slide_name;
                            } else {
                                echo "<br/><br/><hr class='space'/>";
                            }
                        ?>
                        </p>
                        <p><a href="manage_content.php">Go Back</a></p>
                    <?php
                        } else {
                    ?>
                            <h5 class="warning"><strong><?php echo $msg; ?></strong></h5>
                            <hr class="space"/>
                            <h4>Update Performance</h4>
                            <!-- Post the form data to current file, use get value "add" to indicate that data are posted-->
                            <form action="update_performance.php?id=<?php echo $p_id; ?>&update=true" method="post" enctype="multipart/form-data">
                                <p>
                                    <label for="performancename">Performance Name   </label>
                                    <input type="text" name="performancename" size="40" value="<?php echo $performance_name; ?>"/>
                                </p>
                                <p>
                                    <label for="performanceslide">Choose Powerpoint slide:  </label>
                                    <input type="file" name="performanceslide" accept="application/vnd.ms-powerpoint"/>
                                </p>
                                <p><input class="button gray" type="submit" value="Update Performance"/></p>
                            </form>
                            <p><a href="manage_content.php">Go Back</a></p>
                    <?php
                        }
                    } else {
                    ?>
                        <h4>Update Performance</h4>
                        <!-- Post the form data to current file, use get value "add" to indicate that data are posted-->
                        <form action="update_performance.php?id=<?php echo $p_id; ?>&update=true" method="post" enctype="multipart/form-data">
                            <p>
                                <label for="performancename">Performance Name   </label>
                                <input type="text" name="performancename" size="40" value="<?php echo $p_old_name; ?>"/>
                            </p>
                            <p>
                                <label for="performanceslide">Choose Powerpoint slide:  </label>
                                <input type="file" name="performanceslide" accept="application/vnd.ms-powerpoint"/>
                            </p>
                            <p><input class="button gray" type="submit" value="Update Performance"/></p>
                        </form>
                        <p><a href="manage_content.php">Go Back</a></p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
