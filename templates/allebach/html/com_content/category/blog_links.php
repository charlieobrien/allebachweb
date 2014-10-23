<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


$linkcount = 0;

?>

<ul class="thumbs nav nav-tabs nav-stacked">
<?php
	foreach ($this->lead_items as &$item) :
		$images  = json_decode($item->images);
?>
	<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
        <li class="thumb thumb<?php echo $linkcount; ?>">
            <a href="#thumb<?php echo $linkcount; ?>" class="thumbnail" style="background-image: url('<?php echo $images->image_intro; ?>')">
                
                <?php if ((isset($item->title) && !empty($item->title)) || (isset($item->introtext) && !empty($item->introtext))) : ?>
                	<span class="description"><h4><?php echo $item->title; ?></h4><?php echo $item->introtext; ?></span>
                <?php endif; ?>
            </a>
        </li>
        <?php $linkcount++; ?>
	<?php endif; ?>
   
<?php endforeach; ?>
</ul>