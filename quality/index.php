<?php
//Retrieve the powerpoint file inside this folder
$dir= scandir('.');
foreach($dir as $file){
    if($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc"){
        $files[]= $file;
    }
}
$slide_name= $files[0];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Rockwell Automation - Quality</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="../favicon.ico"/>
        <!--  CSS Style -->
        <link rel="stylesheet" href="../css/mycss.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="../css/print.css" type="text/css" media="print">
        <style type="text/css">
            .container{
                width: 100%;
            }
            .span-12{
                width:  650px;
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
                <!-- Powerpoint -->
                <iframe name="powerpoint" id="powerpoint" align="center" src="<?php echo $slide_name; ?>" frameborder="0" scrolling="no" width=""></iframe>
                <br/>
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