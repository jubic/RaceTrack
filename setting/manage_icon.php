<?php
$session = session_start();
if (isset($_SESSION)) {
    if (isset($_SESSION['change_icon'])) {
        $msg = $_SESSION['change_icon'];
        if ($msg != "") {
            echo "<script type='text/javascript'>alert('$msg');</script>";
            $_SESSION['change_icon'] = "";
        }
    }
    if (isset($_SESSION['save_img_msg'])) {
        $message = $_SESSION['save_img_msg'];
        if ($message != "") {
            echo "<script type='text/javascript'>alert('$message');</script>";
            $_SESSION['save_img_msg'] = "";
        }
    }
}
include 'navigation.php';
include "../dbFunctions.php"; // Make connection
//Fetch Icon Data
$selectquery = "SELECT * FROM icons";
$doquery = mysqli_query($connection, $selectquery);
while ($icondata = mysqli_fetch_assoc($doquery)) {
    $iconarray[] = $icondata;
}
$icon_no = count($iconarray);
$row_no = ceil($icon_no / 4);
$last_row_icon_no = $icon_no - (($row_no - 1) * 4);
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
                height: 900px;;
                border-left: 1px solid #fff;
                border-right: 1px solid #fff;
                background: gray;
            }
            h2{
                margin-left: 20px;
                font-size: 22px;
                font-weight: normal;
            }
            p{
                color: #fff;
                font-size: 14px;
            }
            a,a:hover,a:visited,a:active{
                text-decoration: none;
                color: #fff;
            }
            #changedisplayicon,#updateicon{
                display: none;
            }
            #updateicon table{
                margin-left: 50px;
                width: 600px
            }
            a#divtitle,a:visited#divtitle,a:active#divtitle{
                text-decoration: underline;
                color: #fff;
            }
        </style>
        <script type="text/javascript">
            function toggle_visibility(id) {
                var e = document.getElementById(id);
                if(e.style.display == 'block')
                    e.style.display = 'none';
                else
                    e.style.display = 'block';
                    e.focus();
            }
        </script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1 style="padding-top: 30px;">Setting Page</h1>
                <?php echo $menu; ?>
                <hr class="space"/>      
                <h2><a id="divtitle" href="#updateicon" onclick="toggle_visibility('updateicon');">Change Icon Picture</a></h2>
                <div id="updateicon">
                    <form action="do_add_icon.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <table border="0" cellpadding="10" cellspacing="0">
                                <?php
                                foreach ($iconarray as $icon) {
                                    $iconsrc = "../" . $icon['image_normal_src'];
                                    $iconname = "ICON " . $icon['image_id'];
                                    $link = "change_icon_picture.php?id=" . $icon['image_id'];
                                ?>
                                    <tr>
                                        <td width="200px"><p><?php echo $iconname; ?></p></td>
                                        <td width="200px"><img alt="<?php echo $icon['image_description']; ?>"border="0" width="150px" height="150px" src="<?php echo $iconsrc; ?>"</td>
                                        <td width="200px"><a class="button gray" href="<?php echo $link; ?>">Change picture</a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><hr class="space"/></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </fieldset>
                    </form>
                </div>
                <hr class="space"/>
                <h2><a id="divtitle" href="#changedisplayicon" onclick="toggle_visibility('changedisplayicon');">Select the icons to be displayed</a></h2>
                <div id="changedisplayicon">
                    <form action="change_display_icon.php" method="post">
                        <fieldset>
                            <table border="0" cellspacing="8">
                                <?php
                                $icon_id = 0;
                                for ($i = 1; $i <= $row_no; $i++) {
                                ?>
                                    <tr>
                                    <?php
                                    if ($i != $row_no) {
                                        for ($a = 0; $a < 4; $a++) {
                                            $link = $iconarray[$icon_id]['image_link'];
                                            $imagesrc = "../" . $iconarray[$icon_id]['image_normal_src'];
                                            $imagename = $iconarray[$icon_id]['image_description'];
                                            $image_id = $iconarray[$icon_id]['image_id'];
                                    ?>
                                            <td>
                                                <input type="checkbox" name="icon_display[]" value="<?php echo $image_id; ?>"/>
                                                <br/>
                                                <img border="0" width="150px" height="150px" src="<?php echo $imagesrc; ?>" alt="<?php echo $imagename; ?>"/>
                                            </td>
                                    <?php
                                            $icon_id+=1;
                                        }
                                    } else {
                                        for ($b = 0; $b < $last_row_icon_no; $b++) {
                                            $link = $iconarray[$icon_id]['image_link'];
                                            $imagesrc = "../" . $iconarray[$icon_id]['image_normal_src'];
                                            $imagename = $iconarray[$icon_id]['image_description'];
                                            $image_id = $iconarray[$icon_id]['image_id'];
                                    ?>
                                            <td>
                                                <input type="checkbox" name="icon_display[]" value="<?php echo $image_id; ?>"/>
                                                <br/>
                                                <img border="0" width="150px" height="150px" src="<?php echo $imagesrc; ?>" alt="<?php echo $imagename; ?>"/>
                                            </td>
                                    <?php
                                            $icon_id+=1;
                                        }
                                    }
                                    ?>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
                            <input type="submit" value="Change disply icons"/>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
