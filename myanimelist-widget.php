<?php
/*
Plugin Name: MyAnimeList Widget
Plugin URI: http://vievern.com/wordpress_plugins
Description: Widget that shows your last updates on http://myanimelist.net (parsing)
Version: 1.2
Author: Vievern
Author URI: http://vievern.com/
*/

function vievs_mal_widget($args) {
$title = get_option('vievs_mal_widget_title');
$username = get_option('vievs_mal_widget_username');
$parstype = get_option('vievs_mal_pars_type');

    extract($args);
    echo $before_widget; 
    echo $before_title;
    echo (empty($title)? 'MAL Last List Updates' : $title);
    echo $after_title;

if($parstype != 'always'){
$parslast = get_option('vievs_mal_pars_last');
if($parslast != date('d-m-Y')){
$startpars = true;
}
else
{
$startpars = false;
}

}
else
{
$startpars = true;
}

$mal_dir = plugin_dir_path(__FILE__).'cache.html';

if($startpars){

if(get_option('vievs_mal_pars_conn') == 'fgc'){
$data = file_get_contents('http://myanimelist.net/profile/'.$username);
}
else
{
$chandler = curl_init();
curl_setopt($chandler, CURLOPT_URL, 'http://myanimelist.net/profile/'.$username);
curl_setopt($chandler, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($chandler);
curl_close($chandler);
}

preg_match( '#Last List Updates</strong></div>(.+?)<div class="spaceit_pad"><a href="http://myanimelist.net/history/'.$username.'">#is', $data, $matches );
unset($data);

$html = str_replace('<a href=','<a target="_blank" href=',$matches[1]);
unset($matches);
$html = str_replace(array('width="26"','style="padding-left: 0;"'),'',$html);
$html = str_replace(array('>add<','>edit<'),'><',$html);

if($parstype == 'opd'){
update_option('vievs_mal_pars_text', $html);
update_option('vievs_mal_pars_last', date('d-m-Y'));
}
else if($parstype == 'opdf'){
unlink($mal_dir);
$f = fopen($mal_dir,"w");
fwrite($f,$html);
fclose($f);
update_option('vievs_mal_pars_last', date('d-m-Y'));
}

}
else
{

if($parstype == 'opd'){
$html = get_option('vievs_mal_pars_text');
}
elseif($parstype == 'opdf'){
$html = file_get_contents($mal_dir);
}

}

echo '<style>'.get_option('vievs_mal_widget_css').'</style>
<div id="mal_parsed">'.$html.'</div>';	
unset($html);
    echo $after_widget;

}

function vievs_mal_widget_control() {
if (!empty($_REQUEST['vievs_mal_widget_title'])) { 
        update_option('vievs_mal_widget_title', $_REQUEST['vievs_mal_widget_title']);
}
if (!empty($_REQUEST['vievs_mal_widget_username'])) { 
        update_option('vievs_mal_widget_username', $_REQUEST['vievs_mal_widget_username']);
		update_option('vievs_mal_pars_last','01-01-2001');
}
if (!empty($_REQUEST['vievs_mal_pars_type'])) { 
        update_option('vievs_mal_pars_type', $_REQUEST['vievs_mal_pars_type']);
}
if (!empty($_REQUEST['vievs_mal_widget_css'])) { 
        update_option('vievs_mal_widget_css', $_REQUEST['vievs_mal_widget_css']);
}
if (!empty($_REQUEST['vievs_mal_pars_conn'])) { 
        update_option('vievs_mal_pars_conn', $_REQUEST['vievs_mal_pars_conn']);
}
?>
Widget title:<br>
<input style="width:200px;" type="text" name="vievs_mal_widget_title" value="<?= get_option('vievs_mal_widget_title'); ?>" /><br /><br />
Your MAL username:<br>
<input style="width:200px;" type="text" name="vievs_mal_widget_username" value="<?= get_option('vievs_mal_widget_username'); ?>" /><br /><br />
Parsing:<br>
<select style="width:200px;" name="vievs_mal_pars_type">
<? $vmalp = get_option('vievs_mal_pars_type'); ?>
<option value="opd"<? if($vmalp == 'opd') echo ' selected'; ?>>Once per day (option)</option>
<option value="opdf"<? if($vmalp == 'opdf') echo ' selected'; ?>>Once per day (file)</option> <? // 1.1 ?>
<option value="always"<? if($vmalp == 'always') echo ' selected'; ?>>Always</option>
<? unset($vmalp); ?>
</select>
<br /><br />

Connect:<br> <? // 1.2 ?>
<select style="width:200px;" name="vievs_mal_pars_conn">
<? $vmalc = get_option('vievs_mal_pars_conn'); ?>
<option value="fgc"<? if($vmalc == 'fgc') echo ' selected'; ?>>File_get_content</option>
<option value="curl"<? if($vmalc == 'curl') echo ' selected'; ?>>Curl</option>
<? unset($vmalc); ?>
</select>
<br /><br />

Widget css:<br>
<textarea style="width:200px;" name="vievs_mal_widget_css"><?= get_option('vievs_mal_widget_css'); ?></textarea><br />
<?
}

function vievs_mal_activate(){
update_option('vievs_mal_widget_title','MAL Last List Updates');
update_option('vievs_mal_widget_username','Xinil'); //  Default: MyAnimeList's Developer - Xinil
update_option('vievs_mal_widget_css','#mal_parsed img {
border: 1px solid black;
max-width: 30px;
}
#mal_parsed td {
vertical-align: top;
padding-left: 5px;
line-height: 110%;
padding-bottom: 15px;
border: 0px;
}
#mal_parsed a {
font-size: 12px;
font-weight: bold;
}
#mal_parsed div {
padding: 0px;
margin: 0px;
border: 0px;
}
#mal_parsed .spaceit_pad {
font-size: 10px;
font-style: italic
}
#mal_parsed .lightLink {
font-size: 10px;
font-style: italic
}');
update_option('vievs_mal_pars_last','01-01-2001');
update_option('vievs_mal_pars_type','opd');
update_option('vievs_mal_pars_text','Not yet parsed');
update_option('vievs_mal_pars_conn','fgc');
}
function vievs_mal_deactivate(){
delete_option('vievs_mal_widget_title');
delete_option('vievs_mal_widget_username');
delete_option('vievs_mal_widget_css');
delete_option('vievs_mal_pars_last');
delete_option('vievs_mal_pars_type');
delete_option('vievs_mal_pars_text');
delete_option('vievs_mal_pars_conn');
}

register_sidebar_widget('MAL Last List Updates', 'vievs_mal_widget');
register_widget_control('MAL Last List Updates', 'vievs_mal_widget_control'); 

register_activation_hook( __FILE__, 'vievs_mal_activate' );
register_deactivation_hook( __FILE__, 'vievs_mal_deactivate' );
?>