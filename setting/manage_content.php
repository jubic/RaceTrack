<?php
include 'navigation.php';
include '../dbFunctions.php';
// Retrieve Project Data
$selectquery = "SELECT * FROM  `project`;";
$doquery = mysqli_query($connection, $selectquery);
while ($row = mysqli_fetch_assoc($doquery)) {
    $project_data[] = $row;
}
// Retrieve Initiative Data
$iniquery = "SELECT * FROM `initiative_slide`;";
$inidoquery = mysqli_query($connection, $iniquery);
while ($row = mysqli_fetch_assoc($inidoquery)) {
    $initiative_data[] = $row;
}
//Retrieve Performance Data
$p_query = "SELECT * FROM `performance`;";
$p_do_query = mysqli_query($connection, $p_query);
while ($row = mysqli_fetch_assoc($p_do_query)) {
    $performance_data[] = $row;
}
//Retrieve Training Data
$tData = scandir("../training");
foreach ($tData as $file) {
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
        $tslide[] = $file;
    }
}
//Retrieve Sharing Data
$shr_Data = scandir("../sharing");
foreach ($shr_Data as $file) {
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
        $shr_slide[] = $file;
    }
}

//Retrieve Quality Data
$qData = scandir("../quality");
foreach ($qData as $file) {
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
        $qslide[] = $file;
    }
}
//Retrieve Icon7 Data
$icon7_data = scandir("../icon7");
foreach ($icon7_data as $file) {
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
        $icon7_slide[] = $file;
    }
}
//Retrieve Icon8 Data
$icon8_data = scandir("../icon8");
foreach ($icon8_data as $file) {
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
        $icon8_slide[] = $file;
    }
}
//Retrieve Icon9 Data
$icon9_data = scandir("../icon9");
foreach ($icon9_data as $file) {
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
        $icon9_slide[] = $file;
    }
}
//Retrieve Icon7 Data
$icon10_data = scandir("../icon10");
foreach ($icon10_data as $file) {
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
        $icon10_slide[] = $file;
    }
}
//Retrieve Icon7 Data
$icon11_data = scandir("../icon11");
foreach ($icon11_data as $file) {
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
        $icon11_slide[] = $file;
    }
}
//Retrieve Icon7 Data
$icon12_data = scandir("../icon12");
foreach ($icon12_data as $file) {
    if ($file != "." && $file != ".." && $file != "index.php" && $file != "iepngfix.htc") {
        $icon12_slide[] = $file;
    }
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
            a,a:hover,a:visited,a:active{
                text-decoration: none;
                color: #fff;
            }
            table,.datafield{
                margin-left: 50px;
            }
            fieldset{
                margin-right: 50px;
            }
            table th{
                font-size: 17px;
                font-weight: bold;
            }
            a#divtitle,a:visited#divtitle,a:active#divtitle{
                text-decoration: underline;
                color: #fff;
            }
            #project,#initiative,#performance,#training,#sharing,#quality,#icon7,#icon8,#icon9,#icon10,#icon11,#icon12{
                display: none;
                margin-left: 20px;
            }
        </style>
        <script type="text/javascript" language="javascript">
            function deleteproject(id,name){
                var projectID = id;
                var projectName = name;
                var url= "do_delete_project.php?id="+projectID;
                var box= confirm("Are you sure to delete the project '"+projectName+"' ?");
                if(box == true){
                    window.location.href = url;
                }
            }
            function deleteinitiative (id, name){
                var iniID = id;
                var iniName = name;
                var url= "do_delete_initiative.php?id="+iniID;
                var questionbox= confirm("Are you sure to delete the initiative '"+iniName+"' ?");
                if(questionbox == true){
                    window.location.href = url;
                }
            }
            function deleteperformance (id, name){
                var performanceID = id;
                var performanceName = name;
                var url= "do_delete_performance.php?id="+performanceID;
                var pquestionbox= confirm("Are you sure to delete the performance '"+performanceName+"' ?");
                if(pquestionbox == true){
                    window.location.href = url;
                }
            }
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
                <!-- Setting for project -->
                <hr class="space" />
                <a name="projecttitle"></a>
                <h2><a id="divtitle" href="#projecttitle" onclick="toggle_visibility('project');">ICON 1 - PROJECT</a></h2>
                <div id="project">
                    <fieldset>
                        <center><p><a href="add_project.php" class="button gray">Add New Project</a></p></center>
                        <hr class="space"/>
                        <table>
                            <?php
                            foreach ($project_data as $project) {
                                $project_name = $project['project_name'];
                                $project_id = $project['project_id'];
                                $script = "javascript:deleteproject(" . $project_id . ",'" . $project_name . "');";
                            ?>
                                <tr>
                                    <td width="250px"><p><?php echo $project_name; ?></p></td>
                                    <td width="100px"><p><a href="update_project.php?id=<?php echo $project_id; ?>" class="button gray">Update</a></p></td>
                                    <td width="80px"><p><a href="<?php echo $script; ?>" class="button gray">Delete</a></p></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </fieldset>
                </div>
                <!-- Setting for Initiative -->
                <hr class="space" />
                <a name="initiativetitle"></a>
                <h2><a id="divtitle" href="#initiativetitle" onclick="toggle_visibility('initiative');">ICON 2 - INITIATIVES</a></h2>
                <div id="initiative">
                    <fieldset>
                        <center><p><a href="add_initiative.php" class="button gray">Add New Initiative</a></p></center>
                        <hr class="space"/>
                        <table>
                            <?php
                            foreach ($initiative_data as $initiative) {
                                $initiative_id = $initiative['slide_id'];
                                $initiative_name = $initiative['slide_name'];
                                $update_link = "update_initiative.php?id=$initiative_id";
                                $iniscript = "javascript:deleteinitiative(" . $initiative_id . ",'" . $initiative_name . "');";
                            ?>
                                <tr>
                                    <td width="250px"><p><?php echo $initiative_name; ?></p></td>
                                    <td width="100px"><p><a href="<?php echo $update_link; ?>" class="button gray">Update</a></p></td>
                                    <td width="80px"><p><a href="<?php echo $iniscript; ?>" class="button gray">Delete</a></p></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </fieldset>
                </div>

                <!-- Setting for Performance -->
                <hr class="space" />
                <a name="performancetitle"></a>
                <h2><a id="divtitle" href="#performancetitle" onclick="toggle_visibility('performance');">ICON 3 - PERFORMANCE</a></h2>
                <div id="performance">
                    <fieldset>
                        <center><p><a href="add_performance.php" class="button gray">Add New Performance</a></p></center>
                        <hr class="space"/>
                        <table>
                            <?php
                            foreach ($performance_data as $performance) {
                                $performance_id = $performance['performance_id'];
                                $performance_name = $performance['performance_name'];
                                $p_update_link = "update_performance.php?id=$performance_id";
                                $p_script = "javascript:deleteperformance(" . $performance_id . ",'" . $performance_name . "');";
                            ?>
                                <tr>
                                    <td width="250px"><p><?php echo $performance_name; ?></p></td>
                                    <td width="100px"><p><a href="<?php echo $p_update_link; ?>" class="button gray">Update</a></p></td>
                                    <td width="80px"><p><a href="<?php echo $p_script; ?>" class="button gray">Delete</a></p></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </fieldset>
                </div>
                <!-- Setting for Training-->
                <hr class="space" />
                <a name="trainingtitle"></a>
                <h2><a id="divtitle" href="#trainingtitle" onclick="toggle_visibility('training');">ICON 4 - TRAINING</a></h2>
                <div id="training">
                    <fieldset>
                        <br/>
                        <table>
                            <tr><th colspan="2">Training Slide</th></tr>
                            <tr>
                                <td width="150px"><p name="slide"><?php echo $tslide[0]; ?></p></td>
                                <td width="100px">
                                    <p><a href="update_data.php?cat=training" class="button gray">Update</a></p>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- Setting for Sharing -->
                <hr class="space" />
                <a name="sharingtitle"></a>
                <h2><a id="divtitle" href="#sharingtitle" onclick="toggle_visibility('sharing');">ICON 5 - SHARING</a></h2>
                <div id="sharing">
                    <fieldset>
                        <br/>
                        <table>
                            <tr><th colspan="2">Sharing Slide</th></tr>
                            <tr>
                                <td width="150px"><p name="slide"><?php echo $shr_slide[0]; ?></p></td>
                                <td width="100px">
                                    <p><a href="update_data.php?cat=sharing" class="button gray">Update</a></p>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- Setting for Quality -->
                <hr class="space" />
                <a name="qualitytitle"></a>
                <h2><a id="divtitle" href="#qualitytitle" onclick="toggle_visibility('quality');">ICON 6 - QUALITY</a></h2>
                <div id="quality">
                    <fieldset>
                        <br/>
                        <table>
                            <tr><th colspan="2">Quality Slide</th></tr>
                            <tr>
                                <td width="150px"><p name="slide"><?php echo $qslide[0]; ?></p></td>
                                <td width="100px">
                                    <p><a href="update_data.php?cat=quality" class="button gray">Update</a></p>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- Setting for Icon 7 -->
                <hr class="space" />
                <a name="icon7title"></a>
                <h2><a id="divtitle" href="#icon7title" onclick="toggle_visibility('icon7');">ICON 7</a></h2>
                <div id="icon7">
                    <fieldset>
                        <br/>
                        <table>
                            <tr><th colspan="2">Icon 7 Slide</th></tr>
                            <tr>
                                <td width="150px"><p name="slide"><?php echo $icon7_slide[0]; ?></p></td>
                                <td width="100px">
                                    <p><a href="update_data.php?cat=icon7" class="button gray">Update</a></p>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- Setting for Icon 8 -->
                <hr class="space" />
                <a name="icon8title"></a>
                <h2><a id="divtitle" href="#icon8title" onclick="toggle_visibility('icon8');">ICON 8</a></h2>
                <div id="icon8">
                    <fieldset>
                        <br/>
                        <table>
                            <tr><th colspan="2">Icon 8 Slide</th></tr>
                            <tr>
                                <td width="150px"><p name="slide"><?php echo $icon8_slide[0]; ?></p></td>
                                <td width="100px">
                                    <p><a href="update_data.php?cat=icon8" class="button gray">Update</a></p>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- Setting for Icon 9 -->
                <hr class="space" />
                <a name="icon9title"></a>
                <h2><a id="divtitle" href="#icon9title" onclick="toggle_visibility('icon9');">ICON 9</a></h2>
                <div id="icon9">
                    <fieldset>
                        <br/>
                        <table>
                            <tr><th colspan="2">Icon 9 Slide</th></tr>
                            <tr>
                                <td width="150px"><p name="slide"><?php echo $icon9_slide[0]; ?></p></td>
                                <td width="100px">
                                    <p><a href="update_data.php?cat=icon9" class="button gray">Update</a></p>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- Setting for Icon 10 -->
                <hr class="space" />
                <a name="icon10title"></a>
                <h2><a id="divtitle" href="#icon10title" onclick="toggle_visibility('icon10');">ICON 10</a></h2>
                <div id="icon10">
                    <fieldset>
                        <br/>
                        <table>
                            <tr><th colspan="2">Icon 10 Slide</th></tr>
                            <tr>
                                <td width="150px"><p name="slide"><?php echo $icon10_slide[0]; ?></p></td>
                                <td width="100px">
                                    <p><a href="update_data.php?cat=icon10" class="button gray">Update</a></p>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- Setting for Icon 11 -->
                <hr class="space" />
                <a name="icon11title"></a>
                <h2><a id="divtitle" href="#icon11title" onclick="toggle_visibility('icon11');">ICON 11</a></h2>
                <div id="icon11">
                    <fieldset>
                        <br/>
                        <table>
                            <tr><th colspan="2">Icon 11 Slide</th></tr>
                            <tr>
                                <td width="150px"><p name="slide"><?php echo $icon11_slide[0]; ?></p></td>
                                <td width="100px">
                                    <p><a href="update_data.php?cat=icon11" class="button gray">Update</a></p>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>

                <!-- Setting for Icon 12 -->
                <hr class="space" />
                <a name="icon12title"></a>
                <h2><a id="divtitle" href="#icon12title" onclick="toggle_visibility('icon12');">ICON 12</a></h2>
                <div id="icon12">
                    <fieldset>
                        <legend></legend>
                        <br/>
                        <table>
                            <tr><th colspan="2">Icon 12 Slide</th></tr>
                            <tr>
                                <td width="150px"><p name="slide"><?php echo $icon12_slide[0]; ?></p></td>
                                <td width="100px">
                                    <p><a href="update_data.php?cat=icon12" class="button gray">Update</a></p>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
            </div>
        </div>
    </body>
</html>