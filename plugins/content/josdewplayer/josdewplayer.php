<?php
/**
*# Josdewplayer based on mosdewplayer, Joomla 1.7 native plugin
*# License http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL, see LICENSE.php
*# By infograf768
*# Version 2.0 compatible with J 1.6/1.7
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin');

class plgContentJosdewplayer extends JPlugin
{
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}
	
	public function onContentPrepare($context, &$article, &$params, $page=0 )
	{
		// simple performance check to determine whether plugin should process further
		if ( JString::strpos( $article->text, 'play' ) === false ) {
			return true;
		}

		// define the regular expression for the plugin
		$regex = "#{play}(.*?){/play}#s";

		// perform the replacement
		$article->text = preg_replace_callback( $regex, array(&$this,'plgJosdewplayer_replacer'), $article->text );
		return true;
	}

	protected function plgJosdewplayer_replacer ( &$matches) 
	{
		$LiveSite = JURI::base();
		$plugin = JPluginHelper::getPlugin('content', 'josdewplayer');
		$pluginParams = $this->params;
		$thisParams = explode("|",$matches[1]);
		
		// Get params values
		$autoplay = $pluginParams->get('autoplay', 0);
		$autoreplay = $pluginParams->get('autoreplay', 0);
		
		// Look for and replace general parameters by local ones if present
		for($i = 1; $i < count($thisParams); $i++)
		{
			if(!strcmp($thisParams[$i], '[AUTOPLAY]')) {
				$autoplay = 1;
			} else if(!strcmp($thisParams[$i], '[AUTOREPLAY]')) {
				$autoreplay = 1;
			}
		}

		//Multiplayer
		$playList = explode('*', $thisParams[0]);
		for($i = 0; $i < count($playList); $i++)
		{
 			if ($i >0) {
  				if (strpos( $playList[$i], 'http') !==false) {
   					$path .= '|'. $playList[$i];
  			 	} else {
   					$path .='|'.$LiveSite.$playList[$i];
  				}
  				if ($pluginParams->get('multirect', 1)) {
  					$player = 'dewplayer-rect.swf';
  				} else {
  					$player = 'dewplayer-multi.swf';
  				}
  				$width= '240';
	  		} else {
  				$path = $playList[$i];
   					if (strpos( $path, 'http') !==false) {
  						$path = $path;
  					} else {
   						$path = $LiveSite.$path;
   					}
  				$player = 'dewplayer.swf';
  				$width= '200';
  			}
 		}
 		$height = '20';
 		$value = 'mp3=';
 		
 		//Playlist player
 		if (strpos($path, 'xml')  !== false)
 		{
			if (strpos( $path, 'http') !== false) {
				$path = $path;
			} else {
				$path = $LiveSite.$path;
	  		}

 			$player = 'dewplayer-playlist.swf';
			$width ='240';
			$height = '200';
			$value = 'xml=';
		}

		$text = '<object type="application/x-shockwave-flash" data="'. $LiveSite .'plugins/content/josdewplayer/'.$player.'" width="'.$width.'" height="'.$height.'" id="dewplayer" name="dewplayer">  <param name="wmode" value="transparent" /><param name="movie" value="'. $LiveSite .'plugins/content/josdewplayer/'.$player.'" /><param name="flashvars" value="'.$value. $path.'&amp;autostart='.$autoplay.'&amp;autoreplay='.$autoreplay.'&amp;showtime=1" /></object>';
		return $text;
	}
}