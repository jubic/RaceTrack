<?php
include "dbFunctions.php";
// Retrieve slideshow name which is set to be displayed
$selectquery = "SELECT * FROM slideshows WHERE is_display=1";
$doquery = mysqli_query($connection, $selectquery);
$ppt_data = mysqli_fetch_assoc($doquery);
$ppt_path = "slideshows/" . $ppt_data['name'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard Slideshow</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="favicon.ico"/>
        <script type="text/javascript" src="jquery-1.2.6.js"></script>
        <script type="text/javascript" src="iepngfix_tilebg.js"></script>
        <!--  CSS Style -->
        <link rel="stylesheet" href="css/mycss.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="css/print.css" type="text/css" media="print">
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
                    startNumber: 120,
                    callBack: function() {
                        $(window.location).attr('href','index.php');
                    }
                });
			
            });
        </script>
        <style type="text/css">
            .span-12{
                width:  650px;
            }
        </style>
    </head>
    <!--edit using rowspan/colspan-->
    <body class="mybackground">
        <!--Change the src to the file you want, which must be located in the same folder of this file. The height & width variables to the preferred resolution-->
        <iframe id="powerpoint" align="center" src="<?php echo $ppt_path; ?>"  frameborder="0" scrolling="no"></iframe>
        <br/>
        <!-- Navigation button -->
        <center>
            <div class="span-12">
                <a href="index.php"><img class="lbutton" alt="home" src="image/home.png"/></a>
            </div>
            <div class="span-12 last">
                <a href="javascript:javascript:history.go(-1)"><img class="lbutton" src="image/back.png" alt="back"/></a>
            </div>
        </center>
        <span id="countdown"></span>
    </body>
</html>