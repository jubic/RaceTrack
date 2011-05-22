<?php
include 'navigation.php';
include '../dbFunctions.php';
if (isset($_GET['id'])) {
    if (is_numeric($_GET['id']) && $_GET['id'] > 0) {
        $icon_id = $_GET['id'];
        //Retrieve Icon Information
        $query1 = "SELECT * FROM  `icons` WHERE `image_id`= '$icon_id';";
        $doquery1 = mysqli_query($connection, $query1);
        $icon_data = mysqli_fetch_assoc($doquery1);

        //Check whether the data to update icon are posted or not
        if (isset($_GET['change'])) {
            if (isset($_POST)) {
                if (isset($_FILES['new_normal_icon']) && isset($_FILES['new_hover_icon'])) {
                    //Retrive Normal Icon Data and set path
                    $normal_icon = $_FILES['new_normal_icon']['name'];
                    $server_normal_icon = $_FILES['new_normal_icon']['tmp_name'];
                    $normal_icon_des = "../image/normal_icon/" . $normal_icon;
                    //Retrieve Hover Icon Data and set path
                    $hover_icon = $_FILES['new_hover_icon']['name'];
                    $server_hover_icon = $_FILES['new_hover_icon']['tmp_name'];
                    $hover_icon_des = "../image/hover_icon/" . $hover_icon;
                    if ($normal_icon != "" && $hover_icon != "") {
                        // Upload to the server
                        if (move_uploaded_file($server_normal_icon, $normal_icon_des) && move_uploaded_file($server_hover_icon, $hover_icon_des)) {
                            unlink("../" . $icon_data['image_normal_src']);
                            unlink("../" . $icon_data['image_hover_src']);
                            $query2 = "UPDATE `icons` SET `image_normal_src`='image/normal_icon/$normal_icon',`image_hover_src`= 'image/hover_icon/$hover_icon' WHERE `image_id`='$icon_id';";
                            $doquery2 = mysqli_query($connection, $query2);
                            if ($doquery2) {
                                $done = true;
                                $msg = "The icon picture has been changed successfully.";
                            } else {
                                $done = false;
                                $msg = "Oops. Sorry. Error while updating the image data. Please try again.";
                            }
                        } else {
                            $done = false;
                            $msg = "Oops. Sorry. Error while uploading the image. Please try again.";
                        }
                    } else {
                        $done = false;
                        $msg = "Sorry. You didn't upload any data. Please try again.";
                    }
                } else {
                    $done = false;
                    $msg = "Sorry. You didn't upload any data. Please try again.";
                }
            } else {
                $done = false;
                $msg = "Sorry. You didn't upload any data. Please try again.";
            }
        }
    }
} else {
    header('location: manage_icon.php');
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
                font-style: italic;
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
                    if (isset($_GET['change']) && isset($_POST)) {
                        if ($done) {
                            echo "<h4><i>" . $msg . "</i></h4>";
                    ?>
                            <p>
                                <label for="projectname">Icon Description: </label>
                        <?php echo "ICON " . $icon_id; ?>
                        </p>
                        <p>
                            <label for="normaliconpic">Icon Normal Image:</label>
                            <img border="0" src="<?php echo "../image/normal_icon/" . $normal_icon; ?>" alt="<?php echo $icon_data['image_description']; ?>"
                        </p>
                        <p>
                            <label for="hovericonpic">Icon Hover Image:</label>
                            <img border="0" src="<?php echo "../image/hover_icon/" . $hover_icon; ?>" alt="<?php echo $icon_data['image_description']; ?>"
                        </p>
                        <p><a href="manage_icon.php">Go Back</a></p>
                    <?php
                        } else {
                    ?>
                            <h5 class="warning"><strong><?php echo $msg; ?></strong></h5>
                            <hr class="space"/>
                            <h4>Change Icon <?php echo $icon_id; ?> Picture</h4>
                            <!-- Post the form data to current file, use get value "add" to indicate that data are posted-->
                            <form action="change_icon_picture.php?id=<?php echo $icon_id; ?>&change=true" method="post" enctype="multipart/form-data">
                                <p>
                                    <label for="iconname">Icon Name: </label>
                            <?php echo strtoupper($icon_data['image_description']); ?>
                        </p>
                        <p>
                            <label>Icon Old Picture</label>
                            <img src="<?php echo "../" . $icon_data['image_normal_src']; ?>" alt="<?php echo $icon_data['image_description']; ?>"/>
                        </p>
                        <p>
                            <label for="new_normal_icon">Choose new icon</label>
                            <input type="file" name="new_normal_icon" accept="image/png, image/PNG"/>
                        </p>
                        <p>
                            <label for="new_hover_icon">Choose new icon</label>
                            <input type="file" name="new_hover_icon" accept="image/png, image/PNG"/>
                        </p>
                        <p><input class="button gray" type="submit" value="Change Icon Picture"/></p>
                    </form>
                    <p><a href="manage_icon.php">Go Back</a></p>
                    <?
                        }
                    } else {
                    ?>
                        <h4>Change Icon <?php echo $icon_id; ?> Picture</h4>
                        <!-- Post the form data to current file, use get value "add" to indicate that data are posted-->
                        <form action="change_icon_picture.php?id=<?php echo $icon_id; ?>&change=true" method="post" enctype="multipart/form-data">
                            <p>
                                <label for="iconname">Icon Name: </label>
                            <?php echo strtoupper($icon_data['image_description']); ?>
                        </p>
                        <p>
                            <label>Icon Old Picture</label>
                            <img src="<?php echo "../" . $icon_data['image_normal_src']; ?>" alt="<?php echo $icon_data['image_description']; ?>"/>
                        </p>
                        <p>
                            <label for="new_normal_icon">Choose new icon</label>
                            <input type="file" name="new_normal_icon" accept="image/png, image/PNG"/>
                        </p>
                        <p>
                            <label for="new_hover_icon">Choose new icon</label>
                            <input type="file" name="new_hover_icon" accept="image/png, image/PNG"/>
                        </p>
                        <p><input class="button gray" type="submit" value="Change Icon Picture"/></p>
                    </form>
                    <p><a href="manage_icon.php">Go Back</a></p>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
