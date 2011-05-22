<?php
include 'navigation.php'; // For Navigation Bar
// Check whether data are posted
if (isset($_GET['add'])) {
    $postcomplete = $_GET['add'];
    if ($postcomplete) {
        // Check Data are really posted or not
        if (isset($_POST)) {
            // Retrieve posted data
            $ini_name = $_POST['initiativename'];
            if (isset($_FILES)) {
                $ini_slide_name = basename($_FILES['inislide']['name']);
                $ini_server_file = $_FILES['inislide']['tmp_name'];
            }
            // Only if all datas are complete, add new initiative
            if ($ini_name != "" && $ini_slide_name != "") {
                $destination = "../initiative/" . $ini_slide_name;
                if (move_uploaded_file($ini_server_file, $destination)) {  // Upload the powerpoint
                    include '../dbFunctions.php'; // Connect to DB
                    // Insert statement
                    $insert = "INSERT INTO `initiative_slide` (`slide_name`, `slide_link`) VALUES ('$ini_name', '$ini_slide_name');";
                    $doquery = mysqli_query($connection, $insert);
                    if ($doquery) {
                        $done = true;
                        $msg = "New initiative has been successfully added";
                    }
                } else {
                    $done = false;
                    $msg = "Sorry. Error uploading the powerpoint file. Please try again.";
                }
                // Otherwise, show error message
            } else {
                $done = false;
                $msg = "You have left to fill something. Please fill the form completely and check carefully before submitting.";
            }
        }
    }
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
                    if (isset($_GET['add']) && isset($_POST)) {
                        if ($done) {
                            echo "<h4><i>" . $msg . "</i></h4>";
                    ?>
                            <p>
                                <label for="initiativename">Initiative Name   </label>
                        <?php echo $ini_name; ?>
                        </p>
                        <p>
                            <label for="inislide">Uploaded Powerpoint slide:  </label>
                        <?php echo $ini_slide_name; ?>
                        </p>
                        <p><a href="manage_content.php">Go Back</a></p>
                    <?php
                        } else {
                    ?>
                            <h5 class="warning"><strong><?php echo $msg; ?></strong></h5>
                            <hr class="space"/>
                            <h4>Add New Initiative</h4>
                            <form action="add_initiative.php?add=true" method="post" enctype="multipart/form-data">
                                <p>
                                    <label for="initiativename">Initiative Name   </label>
                                    <input type="text" name="initiativename" size="40" value="<?php echo $ini_name; ?>"/>
                                </p>
                                <p>
                                    <label for="inislide">Choose powerpoint slide:  </label>
                                    <input type="file" name="inislide" accept="application/vnd.ms-powerpoint"/>
                                </p>
                                <p><input class="button gray" type="submit" value="Add Initiative"/></p>
                            </form>
                            <p><a href="manage_content.php">Go Back</a></p>
                    <?php
                        }
                    } else {
                    ?>
                        <h4>Add New Initiative</h4>
                        <!-- Post the form data to current file, use get value "add" to indicate that data are posted-->
                        <form action="add_initiative.php?add=true" method="post" enctype="multipart/form-data">
                            <p>
                                <label for="initiativename">Initiative Name   </label>
                                <input type="text" name="initiativename" size="40"/>
                            </p>
                            <p>
                                <label for="inislide">Choose powerpoint slide:  </label>
                                <input type="file" name="inislide" accept="application/vnd.ms-powerpoint"/>
                            </p>
                            <p><input class="button gray" type="submit" value="Add Initiative"/></p>
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
