<?php
include 'navigation.php';
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
                height: 1000px;
                border-left: 1px solid #fff;
                border-right: 1px solid #fff;
                background: gray;
            }
            p{
                color: #fff;
                font-size: 16px;
            }
            a,a:visited,a:active{
                color: #fff;
                font-size: 14px;
            }
            ul li{
                font-size: 14px;
                color: #fff;
            }
            .message{
                margin-left: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1 style="padding-top: 30px;">Setting Page</h1>
                <?php echo $menu; ?>
                <hr class="space">
                <hr class="space">
                <div class="message">
                    <h4>Welcome, Admin! </h4>
                    <p>This administrative setting page can perform the following options: </p>
                    <ul>
                        <li>
                            <a href="manage_icon.php">Manage the main page icons</a>
                            <ul>
                                <li>Change the icon picture</li>
                                <li>Choose which icons to be displayed</li>
                            </ul>
                        </li>
                        <hr class="space">
                        <li>
                            <a href="manage_slideshow.php">Manage the main looping Powerpoint slide show</a>
                            <ul>
                                <li>Add new powerpoint slide</li>
                                <li>Choose which powerpoint slide to be displayed</li>
                                <li>Delete the powerpoint slide</li>
                            </ul>
                        </li>
                        <hr class="space">
                        <li>
                            <a href="manage_content.php">Manage the contents of the icons</a>
                            <ul>
                                <li>Change the current powerpoint slideshow</li>
                                <li>Delete the powerpoint slideshow</li>
                            </ul>
                        </li>
                    </ul>
                    <hr class="space">
                    <p>Simply perform those actions by clicking the navigation bar button above. </p>
                </div>
            </div>
        </div>
    </body>
</html>
