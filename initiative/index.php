<?php
include '../dbFunctions.php';
//Get total number of initiative
$query = "SELECT COUNT(*) AS total FROM `initiative_slide`";
$doquery = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($doquery);
$total = $row['total'];
$rowperpage = 4; // Maximum icon(row) in one page
$maxpage = ceil($total / $rowperpage);
$pageno = 1; //Default page number
//Clarify page no from the URL
if (isset($_GET['pageno'])) {
    $p_no = $_GET['pageno'];
    if (is_numeric($p_no) && $p_no > 0 && $p_no <= $maxpage) {
        $pageno = $p_no;
    }
}
$offset = ($pageno - 1) * $rowperpage;
$query2 = "SELECT * FROM `initiative_slide` LIMIT " . $offset . "," . $rowperpage;
$doquery2 = mysqli_query($connection, $query2);
while ($row = mysqli_fetch_assoc($doquery2)) {
    $data[] = $row;
}

// Doing paging navigation of Prev, and Next button, and showing the page number of current page
$self = $_SERVER['PHP_SELF'];
$nav = "<p>Showing page <b>" . $pageno . "</b> of <b>" . $maxpage . "</b> pages</p>";

// creating previous and next link
if ($pageno > 1) {
    $page = $pageno - 1;
    $prev = " <a class='navbutton white' href=\"$self?pageno=$page\">Prev</a> ";
} else {
    $prev = '&nbsp;'; // we're on page one, don't print previous link
}

if ($pageno < $maxpage) {
    $page = $pageno + 1;
    $next = " <a class='navbutton white' href=\"$self?pageno=$page\">Next</a> ";
} else {
    $next = '&nbsp;'; // we're on the last page, don't print next link
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Rockwell Automation - Initiatives</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="../favicon.ico"/>
        <!--  CSS Style -->
        <link rel="stylesheet" href="../css/mycss.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="../css/print.css" type="text/css" media="print">
        <script type="text/javascript" src="../iepngfix_tilebg.js"></script>
        <!-- Script for image hover effect-->
        <style type="text/css">
            .container{
                margin-top: 50px;
                color: #fff;
            }

            h1,h2,h3,h4,h5,h6,p{
                color: #fff;
            }
            .white{
                font-size: 30px;
                font-variant: normal;
            }
            .button{
                width: 450px;
                height: 70px;
                padding: 20px 10px;
            }
            .navbutton{
                text-align: center;
                width: 100px;
                height: 30px;
                font: 20px;
                font-weight: bold;
                padding: 3px 5px 0px;
            }
            p{
                font-size: 16px;
            }
            a.white{
                text-decoration: none;
                color: #000;
            }
            a.visited{
                text-decoration: none;
                color: gray;
            }
            a.white:hover{
                text-decoration: none;
                color: gray;
            }
            .ini_button{
                height: 400px;
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
            <!-- Show Initiative Data -->
            <div align="center" class="container">
                <div class="ini_button">
                    <?php
                    if(count($data) <3){
                        echo "<hr class='space'/><hr class='space'/><hr class='space'/>";
                    }
                    foreach ($data as $initiative) {
                    ?>
                        <div class="span-24">
                            <a class="button white" href="show_initiative_slide.php?id=<?php echo $initiative['slide_id']; ?>"><?php echo $initiative['slide_name']; ?></a>
                        </div>
                    <?php
                        if(count($data) <4){
                            echo "<hr class='space'/><hr class='space'/>";
                        }else{
                            echo "<hr class='space'/>";
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
                <!-- Navigation button -->
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