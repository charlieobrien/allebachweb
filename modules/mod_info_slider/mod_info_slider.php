<?php

/*
// Pixel Point Creative "Info Slider" Module for Joomla!
// License: http://www.gnu.org/copyleft/gpl.html
// Copyright (c) 2011 Pixel Point Creative LLC.
// http://www.pixelpointcreative.com
// Adapted from mod_slider from http://www.dynatec.at
*/

defined('_JEXEC') or die('Restricted access');

if (!function_exists('randomkeys')) {
	function randomkeys($length) {
		$key = '';
		$pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		for($i = 0; $i < $length; $i++)	{
			$key .= $pattern{rand(0,strlen($pattern)-1)};
		}
		return $key;
	}
}



global $mainframe;
$doc =& JFactory::getDocument();
// $lang =& JFactory::getLanguage(); $lang = explode('-', $lang->_lang); $lng = $lang[0];
include_once JPATH_SITE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php';
// module parameters
$pos = trim($params->get('pos'));
$catid = trim($params->get('catid'));
$uniqueid = trim($params->get('uniqueid'));
$interval = trim($params->get('interval'));
$transition = trim($params->get('transition'));
$width = trim($params->get('width'));
$height = trim($params->get('height'));
$jquery_loaded = trim($params->get('jquery_loaded'));
$display_titles = trim($params->get('display_titles'));
$randomize = trim($params->get('randomize'));
$use_keyboard = trim($params->get('use_keyboard'));
$link_titles = trim($params->get('link_titles'));
$jquery	= $params->get('jquery', '1');

if ($uniqueid == "") {
	$uid = randomkeys(16);
} else {
	$uid = $uniqueid;
}

if ($jquery) 
if( !defined('PPC_JQUERY_INC') ){
	JHTML::script('ppc.safejquery.start.js','modules/'.$module->module.'/js/');
	JHTML::script('jquery-1.5.min.js','modules/'.$module->module.'/js/');
	JHTML::script('ppc.safejquery.end.js','modules/'.$module->module.'/js/');
	define('PPC_JQUERY_INC', 1);
}
JHTML::script('ppc.safejqueryplugin.start.js','modules/'.$module->module.'/js/');
JHTML::script('jquery.tools.min.js','modules/'.$module->module.'/js/');
JHTML::script('ppc.safejqueryplugin.end.js','modules/'.$module->module.'/js/');
?>
<?php
$doc->addStyleSheet('modules/mod_info_slider/elements/style.css');
$styles .= "div.csm_scrollable.$uid, div.csm_scrollable.$uid div.csm_items div {overflow:hidden;width: " . ($width -70) . "px; height : " . $height  . "px;} \n";
$doc->addStyleDeclaration($styles);



$use_keyboard = ($use_keyboard == 0)?"keyboard:0,":"";
$transition = ($transition != '')?"speed:$transition,":"";

?>

<script type="text/javascript" language="javascript">
(function($){
	$(document).ready(function(){
		$('div.csm_scrollable.<?php echo $uid; ?>').scrollable({
			<?php echo $use_keyboard . "\n" . $transition . "\n"; ?>
			size:1,
			circular:true
		}).autoscroll(<?php echo $interval; ?>);
	});
})(jQuery);
</script>


<div style="width:<?php echo $width;?>px;">
<?php if ($params->get('nav')) : ?>
<div style="position:relative;width:20px;float:left;margin-top:<?php echo ($height) / 2 -10;?>px">
<a class="prev prevbutton"></a>
</div>

<?php endif; ?>

<div class="csm_scrollable <?php echo $uid; ?>" >
<div class="csm_items">

<?php
jimport( 'joomla.database.table.content' );
$db =& JFactory::getDBO();
$nulldate = $db->getNullDate();
$now = JFactory::getDate()->toMySQL();
if ($randomize == 1) {
	$order = "rand()";
} else {
	$order = "ordering";
}


$query = "SELECT id FROM #__content c WHERE c.state = '1' AND c.catid = '$catid' AND c.state IN(1) AND (c.publish_up   = {$db->quote($nulldate)} OR c.publish_up   <= {$db->quote($now)})
			AND (c.publish_down = {$db->quote($nulldate)} OR c.publish_down >= {$db->quote($now)}) ORDER BY $order";
			
$db->setQuery($query);
$result = $db->loadResultArray();

$csm_table =& JTable::getInstance('content');


foreach ($result as $id) {
	$csm_table->load($id);
	/*print '<pre>';
	print_r($csm_table);
	die;*/
	$title = $csm_table->title;
	$introtext = $csm_table->introtext;
	?>
	<div class="csm_item">
		<?php if ($display_titles == 1) { ?>
		<h2 class="contentheading">
			<?php
				if ($link_titles) {
					/*$link = 'index.php?option=com_content&amp;view=article&amp;id='.$id;
					if (isset($default_itemid) && $default_itemid != 0) {
						$link .= '&amp;Itemid='.$default_itemid;
					}*/
					
					$link = JRoute::_(ContentHelperRoute::getArticleRoute($id, $csm_table->catid));
					// $link .= '&amp;lang='.$lng;
					$link = '<a href="'.JRoute::_($link).'">';
					$title = $link . $title . '</a>';
				}
				echo $title; ?>
		</h2>
		<?php }
		echo $introtext; ?>
	</div>
	<?php
}
?>

	</div>
</div>

<?php if ($params->get('nav')) : ?>
<div style="position:relative;width:20px;float:right;margin-top:<?php echo ($height) / 2 -10;?>px; ">
<a class="next nextbutton" ></a>
</div>

<?php endif; ?>
</div>