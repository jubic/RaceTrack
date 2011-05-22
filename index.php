<?php
include 'dbFunctions.php';
$selectquery = "SELECT * FROM icons WHERE is_display=1;";
$doquery = mysqli_query($connection, $selectquery);
while ($row = mysqli_fetch_assoc($doquery)) {
    $icon_display_list[] = $row;
}

$icon_no = count($icon_display_list);
if ($icon_no % 3 == 0) {
    $column_no = 3;
    if ($icon_no == 12) {
        $column_no = 4;
    }
} else {
    if ($icon_no % 4 == 0) {
        $column_no = 4;
    } else if ($icon_no == 13) {
        $column_no = 4;
    } else if ($icon_no % 4 == 2 || $icon_no % 4 == 3) {
        $column_no = 4;
    } else {
        $column_no = 3;
    }
}
$total_row = ceil($icon_no / $column_no);
$last_row_icon_no = $icon_no - (($total_row - 1) * $column_no);
if ($column_no == 3) {
    $colspan = 2;
} else {
    $colspan = 3;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Dashboard Info</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="favicon.ico"/>
        <!-- Javascript for IE png problem, icon effect and time delaying and looping-->
        <script type="text/javascript" src="iepngfix_tilebg.js"></script>
        <!--  CSS Style -->
        <link rel="stylesheet" href="css/mycss.css" type="text/css" media="screen"/>
        <script type="text/javascript">
            function mouseover(idName,imageName){
                document.getElementById(idName).src=imageName;
            }
            function mouseout(idName,imageName){
                document.getElementById(idName).src=imageName;
            }
        </script>
        <script type="text/javascript" src="jquery-1.2.6.js"></script> 
        <script type="text/javascript">
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
                        startNumber: 30,
                        endNumber: 0,
                        callBack: function() { }
                    }, settings);
                    return this.each(function() {
					
                        if(!to && to != settings.endNumber) { to = settings.startNumber; }
					
                        //set the countdown to the starting number
                        $(this).text(to).css('fontSize',settings.startFontSize);
					
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
			
                $('#countdown').countDown({
                    startNumber: 30,
                    callBack: function() {
                        $(window.location).attr('href','pps.php');
                    }
                });
			
            });
        </script>
    </head>
    <body class="mybackground">
        <div id="newiconcontent">
            <center>
                <table>
                    <?php
                    $icon_sequence = 0;
                    for ($i = 1; $i <= $total_row; $i++) {
                    ?>
                        <tr>
                        <?php
                        if ($i != $total_row) {
                            for ($a = 0; $a < $column_no; $a++) {
                                $normal_src = $icon_display_list[$icon_sequence]['image_normal_src'];
                                $hover_src = $icon_display_list[$icon_sequence]['image_hover_src'];
                        ?>
                                <td colspan="<?php echo $colspan; ?>">
                                    <center>
                                        <a href="<?php echo $icon_display_list[$icon_sequence]['image_link']; ?>">
                                            <img width="200px" height="200px" border="0" id="<?php echo $icon_display_list[$icon_sequence]['image_description']; ?>"
                                                 src="<?php echo $normal_src; ?>"
                                                 alt="<?php echo $icon_display_list[$icon_sequence]['image_description']; ?>"
                                                 onmouseover="mouseover(this.id,'<?php echo $hover_src; ?>')"
                                                 onmouseout="mouseout(this.id,'<?php echo $normal_src; ?>')"/>
                                        </a>
                                    </center>
                                </td>
                        <?php
                                $icon_sequence+=1;
                            }
                        } else {
                            if ($column_no == 3) {
                                if ($last_row_icon_no == 2) {
                                    $colspan = 3;
                                } elseif ($last_row_icon_no == 1) {
                                    $colspan = 6;
                                } else {
                                    $colspan = 2;
                                }
                            } else {
                                if ($last_row_icon_no == 3) {
                                    $colspan = 4;
                                } elseif ($last_row_icon_no == 2) {
                                    $colspan = 6;
                                } elseif ($last_row_icon_no == 1) {
                                    $colspan = 12;
                                } else {
                                    $colspan = 3;
                                }
                            }
                            for ($b = 0; $b < $last_row_icon_no; $b++) {
                                $normal_src = $icon_display_list[$icon_sequence]['image_normal_src'];
                                $hover_src = $icon_display_list[$icon_sequence]['image_hover_src'];
                        ?>
                                <td colspan="<?php echo $colspan; ?>">
                                    <center>
                                        <a href="<?php echo $icon_display_list[$icon_sequence]['image_link']; ?>">
                                            <img border="0" width="200px" height="200px" id="<?php echo $icon_display_list[$icon_sequence]['image_description']; ?>"
                                                 src="<?php echo $normal_src; ?>"
                                                 alt="<?php echo $icon_display_list[$icon_sequence]['image_description']; ?>"
                                                 onmouseover="mouseover(this.id,'<?php echo $hover_src; ?>')"
                                                 onmouseout="mouseout(this.id,'<?php echo $normal_src; ?>')"/>
                                        </a>
                                    </center>
                                </td>
                        <?php
                                $icon_sequence+=1;
                            }
                        }
                        ?>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </center>
        </div>
        <span id="countdown"></span>
    </body>
</html>

