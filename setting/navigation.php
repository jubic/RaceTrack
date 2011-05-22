<?php
$items = array(
    array("link" => "index.php", "label" => "HOME"),
    array("link" => "manage_icon.php", "label" => "ICONS"),
    array("link" => "manage_slideshow.php", "label" => "SLIDESHOW"),
    array("link" => "manage_content.php", "label" => "CONTENTS"));

$menu = '';
$menu .= '<ul id="nav">';
foreach ($items as $val) {
    $menu .= '<li><a href="' . $val['link'] . '"';
    if (basename($_SERVER['SCRIPT_NAME']) == $val['link'])
        $menu .= ' class="current"';
    $menu .= '>' . $val['label'] . '</a></li>';
}
$menu .= '</ul>'
?>