<?php
include '../dbFunctions.php';  // connect to DB
// Get Total numbers of projects
$query1 = "SELECT count(*) AS total_icon FROM `project`;";
$doquery1 = mysqli_query($connection, $query1);
$row = mysqli_fetch_assoc($doquery1);
$total_project = $row['total_icon'];
$pageno = 1; // Default page number 1
$iconsperpage = 8; // Maxium Number of icons in one page
$max_page = ceil($total_project / $iconsperpage);
if (isset($_GET['pageno'])) {
    if (is_numeric($_GET['pageno']) && $_GET['pageno'] != 0 && $_GET['pageno'] <= $max_page) {
        $pageno = $_GET['pageno'];
    }
}
$offset = ($pageno - 1) * $iconsperpage;
$query2 = "SELECT * FROM `project` LIMIT " . $offset . "," . $iconsperpage;
$doquery = mysqli_query($connection, $query2);
while ($row = mysqli_fetch_assoc($doquery)) {
    $project_data[] = $row;
}
$total_icon = count($project_data);
$rows = ceil($total_icon / 2);
$last_icon_no = $total_icon - (($rows - 1) * 2);

// Doing paging navigation of Prev, and Next button, and showing the page number of current page
$self = $_SERVER['PHP_SELF'];
$nav = "<p>Showing page <b>" . $pageno . "</b> of <b>" . $max_page . "</b> pages</p>";

// creating previous and next link
if ($pageno > 1) {
    $page = $pageno - 1;
    $prev = " <a class='navbutton white' href=\"$self?pageno=$page\">Prev</a> ";
} else {
    $prev = '&nbsp;'; // we're on page one, don't print previous link
}

if ($pageno < $max_page) {
    $page = $pageno + 1;
    $next = " <a class='navbutton white' href=\"$self?pageno=$page\">Next</a> ";
} else {
    $next = '&nbsp;'; // we're on the last page, don't print next link
}

// print the navigation link
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Rockwell Automation - Projects</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="../favicon.ico"/>
        <!--  CSS Style -->
        <link rel="stylesheet" href="../css/mycss.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="../css/print.css" type="text/css" media="print">
        <script type="text/javascript" src="../iepngfix_tilebg.js"></script>
        <style type="text/css">
            .container{
                margin-top: 50px;
            }
            .button{
                width: 330px;
                height: 70px;
                font: 23px;
                font-weight: bold;
                padding: 10px 5px 0px;
            }
            .navbutton{
                text-align: center;
                width: 100px;
                height: 30px;
                font: 20px;
                font-weight: bold;
                padding: 3px 5px 0px;
            }
            a.white{
                text-decoration: none;
                color: #000;
            }
            a.white:hover{
                text-decoration: none;
                color: gray;
            }
            a.visited{
                text-decoration: none;
                color: gray;
            }
            p{
                font-size: 16px;
            }
            .projectbutton{
                height: 420px;
            }
        </style>
		<script type="text/javascript" src="../jquery-1.2.6.js"></script>
		<script type="text/javascript">
            //Timer function
            $(document).ready(function() {
			
                /* delay function */
                jQuery.fn.delay = function(time,func){
                    return this.each(function(){
                        setTimeout(func,time);
                    });
                };
			
			
                jQuery.fn.countDown = function(settings,to) {
                    settings = jQuery.extend({
                        startFontSize: '0px',
                        endFontSize: '0px',
                        duration: 1000,
                        startNumber: 120,
                        endNumber: 0,
                        callBack: function() { }
                    }, settings);
                    return this.each(function() {
					
                        if(!to && to != settings.endNumber) { to = settings.startNumber; }
					
                        //set the countdown to the starting number
                        //$(this).text(to).css('fontSize',settings.startFontSize);
					
                        //loopage
                        $(this).animate({
                            'fontSize': settings.endFontSize
                        },settings.duration,'',function() {
                            if(to > settings.endNumber + 1) {
                                $(this).css('fontSize',settings.startFontSize).text(to - 1).countDown(settings,to - 1);
                            }
                            else
                            {
                                settings.callBack(this);
                            }
                        });
							
                    });
                };
                // Below is to activate the above script.
                $('#countdown').countDown({
                    //Change startNumber to suit the duration of the slideshow
                    startNumber: 300,
                    callBack: function() {
                        $(window.location).attr('href','../index.php');
                    }
                });
			
            });
        </script>
    </head>
    <body class="mybackground">
        <center>
            <div class="container">
                <!-- Project Data -->
                <div class="projectbutton">
                    <?php
                    $project_id = 0;
                    for ($i = 1; $i <= $rows; $i++) {
                        if ($i != $rows) {
                    ?>
                            <center>
                                <div class="span-12">
                                    <a class="button white" href="show_project_slide.php?ID=<?php echo $project_data[$project_id]['project_id']; ?>"><?php echo $project_data[$project_id]['project_name']; ?></a>
                                </div>
                                <div class="span-12 last">
                                    <a class="button white" href="show_project_slide.php?ID=<?php echo $project_data[$project_id + 1]['project_id']; ?>"><?php echo $project_data[$project_id + 1]['project_name']; ?></a>
                                </div>
                            </center>
                            <hr class="space"/>
                    <?php
                            $project_id +=2;
                        } else {
                    ?>
                            <center>
                        <?php
                            if ($last_icon_no == 1) {
                        ?>
                                <div class="span-12">
                                    <a class="button white" href="show_project_slide.php?ID=<?php echo $project_data[$project_id]['project_id']; ?>"><?php echo $project_data[$project_id]['project_name']; ?></a>
                                </div>
                        <?php
                                $project_id +=1;
                            } else {
                        ?>
                                <div class="span-12">
                                    <a class="button white" href="show_project_slide.php?ID=<?php echo $project_data[$project_id]['project_id']; ?>"><?php echo $project_data[$project_id]['project_name']; ?></a>
                                </div>
                                <div class="span-12 last">
                                    <a class="button white" href="show_project_slide.php?ID=<?php echo $project_data[$project_id + 1]['project_id']; ?>"><?php echo $project_data[$project_id + 1]['project_name']; ?></a>
                                </div>
                        <?php
                                $project_id +=2;
                            }
                        ?>
                        </center>
                        <hr class="space"/>
                    <?php
                        }
                    }
                    ?>
                </div>
                <hr class="space"/>
                <!-- Paging Navigation -->
                <center>
                    <div class="span-8"><?php echo $prev; ?></div>
                    <div class="span-8"><?php echo $nav; ?></div>
                    <div class="span-8 last"><?php echo $next; ?></div>
                </center>
                <hr class="space"/>
                <!-- Navigation Button -->
                <center>
                    <div class="span-12">
                        <a href="../index.php"><img class="lbutton" alt="home" src="../image/home.png"/></a>
                    </div>
                    <div class="span-12 last">
                        <a href="javascript:javascript:history.go(-1)"><img class="lbutton" src="../image/back.png" alt="back"/></a>
                    </div>
                </center>
            </div>
        </center>
		<span id="countdown"></span>
    </body>
</html>
