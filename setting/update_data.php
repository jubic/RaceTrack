<?php
include 'navigation.php'; // For Navigation Bar
include '../dbFunctions.php'; // Connect to DB
if (isset($_GET['cat'])) { //Check whether the category is specified or not
    $update_cat = $_GET['cat'];  // Get the category
    if (isset($_GET['update'])) {  // Do Update?
        $doupdate = $_GET['update'];
        if ($doupdate) {
            if (isset($_POST)) { // Check any data is posted
                if (isset($_FILES['slide'])) {  // Check whether the file is submitted
                    $slidename = basename($_FILES['slide']['name']);
                    $slide_tmp_name = $_FILES['slide']['tmp_name'];
                    // Get old slide
                    $files = scandir("../" . $update_cat);
                    foreach ($files as $file) {
                        if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
                            $slides[] = $file;
                        }
                    }
                    if ($slidename != "") {
                        $destination = "../" . $update_cat . "/" . $slidename;
                        //Delete old files
                        foreach ($slides as $slide) {
                            unlink("../" . $update_cat . "/" . $slide);
                        }
                        // Upload the file
                        if (move_uploaded_file($slide_tmp_name, $destination)) {
                            $done = true;
                            $msg = "The " . strtoupper($update_cat) . " data has been successfully updated";
                        } else {
                            $done = false;
                            $msg = "Sorry. Error uploading the powerpoint file. Please try again.";
                        }
                    } else {
                        $done = false;
                        $msg = "Oops. You did not upload anything. The data was not updated. ";
                    }
                } else {
                    $done = false;
                    $msg = "Oops. You did not upload anything. The data was not updated. ";
                }
            } else {
                $done = false;
                $msg = "Oops. You did not upload anything. The data was not updated. ";
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
                    ?>
                            <h4><i><?php echo $msg; ?></i></h4>
                            <p>
                                <label for="slidename">Uploaded Powerpoint Name: </label>
                        <?php echo $slidename; ?>
                        </p>
                        <p><a href="manage_content.php">Go Back</a></p>
                    <?php
                        } else {
                    ?>
                            <h5 class="warning"><strong><?php echo $msg; ?></strong></h5>
                            <hr class="space"/>
                            <h4>Update Powerpoint Slide for "<?php echo strtoupper($update_cat); ?>"</h4>
                            <!-- Post the form data to current file, use get value "add" to indicate that data are posted-->
                            <form action="update_data.php?cat=<?php echo $update_cat ?>&update=true" method="post" enctype="multipart/form-data">
                                <p>
                                    <label for="slide">Choose Powerpoint slide:  </label>
                                    <input type="file" name="slide" accept="application/vnd.ms-powerpoint"/>
                                </p>
                                <p><input class="button gray" type="submit" value="Update"/></p>
                            </form>
                            <p><a href="manage_content.php">Go Back</a></p>
                    <?php
                        }
                    } else {
                    ?>
                        <h4>Update Powerpoint Slide for "<?php echo strtoupper($update_cat); ?>"</h4>
                        <!-- Post the form data to current file, use get value "add" to indicate that data are posted-->
                        <form action="update_data.php?cat=<?php echo $update_cat ?>&update=true" method="post" enctype="multipart/form-data">
                            <p>
                                <label for="slide">Choose Powerpoint slide:  </label>
                                <input type="file" name="slide" accept="application/vnd.ms-powerpoint"/>
                            </p>
                            <p><input class="button gray" type="submit" value="Update"/></p>
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
