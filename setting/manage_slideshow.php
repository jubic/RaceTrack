<?php
$session = session_start();
if (isset($_SESSION)) {
    if (isset($_SESSION['upload_ppt_msg'])) {
        $message = $_SESSION['upload_ppt_msg'];
        if ($message != "") {
            echo "<script type='text/javascript'>alert('$message');</script>";
            $_SESSION['upload_ppt_msg'] = "";
        }
    }
    if (isset($_SESSION['delete_ppt_msg'])) {
        $message = $_SESSION['delete_ppt_msg'];
        if ($message != "") {
            echo "<script type='text/javascript'>alert('$message');</script>";
            $_SESSION['delete_ppt_msg'] = "";
        }
    }
    if (isset($_SESSION['display_ppt_msg'])) {
        $message = $_SESSION['display_ppt_msg'];
        if ($message != "") {
            echo "<script type='text/javascript'>alert('$message');</script>";
            $_SESSION['display_ppt_msg'] = "";
        }
    }
}
include 'navigation.php';
include "../dbFunctions.php"; // Make connection
// Fetch Slideshow Data
$selectppt = "SELECT * FROM slideshows";
$fetchpptdata = mysqli_query($connection, $selectppt);
while ($row = mysqli_fetch_assoc($fetchpptdata)) {
    $ppt_data[] = $row;
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
                height: 900px;
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
            a#divtitle,a:visited#divtitle,a:active#divtitle{
                text-decoration: underline;
                color: #fff;
            }
            #addppt,#changeppt,#deleteppt{
                display: none;
            }
        </style>
        <!-- Toggle Function -->
        <script type="text/javascript">
            function toggle_visibility(id) {
                var e = document.getElementById(id);
                if(e.style.display == 'block')
                    e.style.display = 'none';
                else
                    e.style.display = 'block';
            }
        </script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1 style="padding-top: 30px;">Setting Page</h1>
                <?php echo $menu; ?>
                <!-- Upload Powerpoint -->
                <hr class="space"/>
                <h2><a id="divtitle" href="#addppt" onclick="toggle_visibility('addppt');">Add new Powerpoint Slide</a></h2>
                <div id="addppt">
                    <form action="do_add_ppt.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <table cellpadding="20">
                                <tr>
                                    <td width="180px"><label for="ppt">Choose Powerpoint </label></td>
                                    <td><input type="file" name="ppt" accept="application/vnd.ms-powerpoint"/></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input type="submit" value="Upload new presentation"/></td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                </div>
                <!-- Change the display Powerpoint -->
                <hr class="space"/>
                <h2><a id="divtitle" href="#changeppt" onclick="toggle_visibility('changeppt');">Choose which powerpoint to be displayed</a></h2>
                <div id="changeppt">
                    <fieldset>
                        <legend>Choose the PowerPoint Slideshow to be displayeded</legend>
                        <br/>
                        <form method='post' action='change_display_ppt.php'>
                            <table>
                                <tr>
                                    <td>
                                        <select name="displayppt">
                                            <option selected="selected">Select a presentation to display</option>
                                            <?php
                                            foreach ($ppt_data as $ppt) {
                                                $pptname = $ppt['name'];
                                                $ppt_id = $ppt['id'];
                                            ?>
                                                <option value="<?php echo $ppt_id; ?>"><?php echo $pptname; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="submit" value="Save Preference"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                </div>
                <!-- Delete unwanted PPT -->
                <hr class="space"/>
                <h2><a id="divtitle" href="#deleteppt" onclick="toggle_visibility('deleteppt');">Delete the powerpoint slideshow</a></h2>
                <div id="deleteppt">
                    <fieldset>
                        <br/>
                        <p>After you have deleted the currently display powerpoint, you have to choose another powerpoint to be displayed.</p>
                        <form method='post' action='do_delete_ppt.php'>
                            <p>
                                <select name="pptid">
                                    <option selected="selected">Select a presentation to delete</option>
                                    <?php
                                            foreach ($ppt_data as $ppt) {
                                                $pptname = $ppt['name'];
                                                $ppt_id = $ppt['id'];
                                    ?>
                                                <option value="<?php echo $ppt_id; ?>"><?php echo $pptname; ?></option>
                                    <?php
                                            }
                                    ?>
                                        </select>
                                        <input type="hidden" name="pptname" value="<?php echo $pptname; ?>"/>
                                <input type='submit' value='Delete' />
                            </p>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </body>
</html>
