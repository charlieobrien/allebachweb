<?php 
/**
* @package   Widgetkit
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/


	//$widget_id  = $widget->id.'-'.uniqid();

	$settings  = array_merge(array(
		'index' 		=> null,
		'buttons' 		=> null,
		'navigation' 	=> null
	), $widget->settings);

	$navigation = array();
	$captions   = array();

	$i = 0;
?>

<div id="slideshow-<?php echo $widget_id; ?>" class="wk-slideshow wk-slideshow-default" data-widgetkit="slideshow" data-options='<?php echo json_encode($settings); ?>'>
	<div>
		<ul class="slides">

			<?php foreach ($widget->items as $key => $item) : ?>
			<?php
				$navigation[] = '<li><span></span></li>';
				$captions[]   = '<li>'.(isset($item['caption']) ? $item['caption']:"").'</li>';
			
				/* Lazy Loading */
				//$item["content"] = ($i==$settings['index']) ? $item["content"] : $this['image']->prepareLazyload($item["content"]);
			?>
			<li>
            	<div class="container">
                    <div class="media"><?php echo $item['media']; ?></div>
                    <article class="wk-content clearfix">
                    	<div class="client-logo"><img src="<?php echo $item['clientLogo']; ?>" /></div>
						<h3><?php echo $item['title']; ?></h3>
						<div class="wk-main-content"><?php echo $item['content']; ?></div>
                    </article>
                <div class="container">
			</li>
			<?php $i=$i+1;?>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php echo ($settings['navigation'] && count($navigation)) ? '<ul class="nav">'.implode('', $navigation).'</ul>' : '';?>
    <?php if (isset($settings['buttons']) && $settings['buttons']) : ?>
    <div class="buttons">
        <div class="container">
            <div class="prev">&lt;</div>
            <span class="close">Close</span>
            <div class="next">&gt;</div>
        </div>
    </div>
    <?php endif; ?>
</div>