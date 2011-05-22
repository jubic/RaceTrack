<?php
include 'navigation.php'; // For Navigation Bar
include '../dbFunctions.php'; // Connect to DB
// Check what data are posted or transferred
if (isset($_GET['id'])) {
    $ini_id = $_GET['id'];
    if ($ini_id != 0 && $ini_id != null) {
        $query = "SELECT * FROM `initiative_slide` WHERE `slide_id`='$ini_id';";
        $doquery = mysqli_query($connection, $query);
        $ini_data = mysqli_fetch_assoc($doquery);
        $ini_name = $ini_data['slide_name'];
        $ini_slide = $ini_data['slide_link'];
    }
    if (isset($_GET['update'])) { //Check whether to update or not
        $postcomplete = $_GET['update'];
        if ($postcomplete) {
            // Check Data are really posted or not
            if (isset($_POST)) {
                // Retrieve posted data
                $initiative_name = $_POST['initiativename'];
                if (isset($_FILES)) {
                    $initiative_slide_name = basename($_FILES['inislide']['name']);
                    $initiative_server_file = $_FILES['inislide']['tmp_name'];
                }
                // Only if all datas are complete, add new initiative
                if ($initiative_name != "") {
                    //Update Statement
                    $insert = "UPDATE `initiative_slide` SET `slide_name`='$initiative_name'";
                    if ($initiative_slide_name != "") {
                        $destination = "../initiative/" . $initiative_slide_name;
                        //Unlink(Delete) the old file
                        if (is_file('../initiative/' . $ini_slide)) {
                            unlink('../initiative/' . $ini_slide);
                        }
                        if (move_uploaded_file($initiative_server_file, $destination)) {  // Upload the powerpoint
                            // Update statement
                            $insert .= ",`slide_link`='$initiative_slide_name'";
                        } else {
                            $done = false;
                            $msg = "Sorry. Error uploading the powerpoint file. Please try again.";
                        }
                    }
                    $insert .= " WHERE `slide_id`= '$ini_id';";
                    $doquery = mysqli_query($connection, $insert);
                    if ($doquery) {
                        $done = true;
                        $msg = "The Initiative has been successfully updated";
                    } else {
                        $done = false;
                        $msg = "Sorry. An error occurred when updating the initiative slidename";
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
                    if (isset($_GET['update']) && isset($_POST)){
                        if ($done) {
                            echo "<h4><i>" . $msg . "</i></h4>";
                    ?>
                            <p>
                                <label for="initiativename">Initiative Name   </label>
                        <?php echo $initiative_name; ?>
                        </p>
                        <p>
                            <label for="inislide">Powerpoint slide:  </label>
                        <?php
                            if (isset($_FILES['inislide'])) {
                                echo $initiative_slide_name;
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
                            <h4>Update Initiative</h4>
                            <form action="update_initiative.php?id=<?php echo $ini_id; ?>&update=true" method="post" enctype="multipart/form-data">
                                <p>
                                    <label for="initiativename">Initiative Name   </label>
                                    <input type="text" name="initiativename" size="40" value="<?php echo $initiative_name; ?>" />
                                </p>
                                <p>
                                    <label for="inislide">Choose powerpoint slide:  </label>
                                    <input type="file" name="inislide" accept="application/vnd.ms-powerpoint"/>
                                </p>
                                <p><input class="button gray" type="submit" value="Update Initiative"/></p>
                            </form>
                            <p><a href="manage_content.php">Go Back</a></p>
                    <?
                        }
                    } else{
                    ?>
                        <h4>Update Initiative</h4>
                        <!-- Post the form data to current file, use get value "add" to indicate that data are posted-->
                        <form action="update_initiative.php?id=<?php echo $ini_id; ?>&update=true" method="post" enctype="multipart/form-data">
                            <p>
                                <label for="initiativename">Initiative Name   </label>
                                <input type="text" name="initiativename" size="40" value="<?php echo $ini_name; ?>"/>
                            </p>
                            <p>
                                <label for="inislide">Choose Powerpoint slide:  </label>
                                <input type="file" name="inislide" accept="application/vnd.ms-powerpoint"/>
                            </p>
                            <p><input class="button gray" type="submit" value="Update Initiative"/></p>
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