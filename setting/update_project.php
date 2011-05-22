<?php
include 'navigation.php';
if (isset($_GET['id'])) {  // if specify project ID
    $project_id = $_GET['id'];
    if ($project_id != 0 && $project_id != null) {
        include "../dbFunctions.php"; // Connect to DB
        $query = "SELECT * FROM `project` WHERE `project_id` = '$project_id';"; //Retrieve from db to get old ppt naw
        $doquery = mysqli_query($connection, $query);
        $projectdata = mysqli_fetch_assoc($doquery);
        $projectname = $projectdata['project_name'];
        $projectoldslide = $projectdata['project_slide_link'];
        if (isset($_GET['update'])) { //if data are updated
            $update = $_GET['update'];
            if ($update) {
                if (isset($_POST)) { // Make sure data are really posted
                    $project_name = $_POST['projectname'];
                    if ($project_name != "") {
                        // Update Statement
                        $update = "UPDATE `project` SET `project_name`= '$project_name'";
                        if (isset($_FILES)) {
                            $project_slide_name = basename($_FILES['projectslide']['name']);
                            $project_server_file = $_FILES['projectslide']['tmp_name'];
                            $destination = "../project/" . $project_slide_name;
                            //Delete the old project powerpoint
                            unlink("../project/" . $projectoldslide);
                            if (move_uploaded_file($project_server_file, $destination)) {   // Upload the powerpoint
                                $update .= ",`project_slide_link` = '$project_slide_name'"; //Update statement
                            }
                        }
                        $update .= " WHERE `project_id`= '$project_id'";
                        $doquery = mysqli_query($connection, $update);
                        if ($doquery) {
                            $done = true;
                            $msg = "The project data has been successfully updated";
                        }
                    } else {
                        $done = false;
                        $msg = "You have left to fill something. Please fill the form completely and check carefully before submitting.";
                    }
                }
            }
        }
    }
} else { // If no project id, redirect to the previous page
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
                                <label for="projectname">Project Name :</label>
                        <?php echo $project_name; ?>
                        </p>
                        <p>
                            <label for="projectslide">Powerpoint slide :</label>
                        <?php
                            if (isset($_FILES['projectslide'])) {
                                echo $project_slide_name;
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
                            <h4>Update Project</h4>
                            <form action="update_project.php?id=<?php echo $project_id; ?>&update=true" method="post" enctype="multipart/form-data">
                                <p>
                                    <label for="projectname">Project Name :</label>
                                    <input type="text" name="projectname" size="40" value="<?php echo $project_name; ?>"/>
                                </p>
                                <p>
                                    <label for="projectslide">Choose powerpoint slide :  </label>
                                    <input type="file" name="projectslide" accept="application/vnd.ms-powerpoint"/>
                                </p>
                                <p><input class="button gray" type="submit" value="Update Project"/></p>
                            </form>
                            <p><a href="manage_content.php">Go Back</a></p>
                    <?php
                        }
                    } else {
                    ?>
                        <h4>Update Project</h4>
                        <!-- Post the form data to current file, use get value "add" to indicate that data are posted-->
                        <form action="update_project.php?id=<?php echo $project_id; ?>&update=true" method="post" enctype="multipart/form-data">
                            <p>
                                <label for="projectname">Project Name :</label>
                                <input type="text" name="projectname" size="40" value="<?php echo $projectname; ?>"/>
                            </p>
                            <p>
                                <label for="projectslide">Choose powerpoint slide:  </label>
                                <input type="file" name="projectslide" accept="application/vnd.ms-powerpoint"/>
                            </p>
                            <p><input class="button gray" type="submit" value="Update Project"/></p>
                        </form>
                        <p><a href="manage_content.php">Go Back</a></p>
                    <?php
                    }F
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
