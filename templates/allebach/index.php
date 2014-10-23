<?php defined( '_JEXEC' ) or die; 

// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$menu = $app->getMenu();
$active = $app->getMenu()->getActive();
$params = $app->getParams();
$pageclass = $params->get('pageclass_sfx');
$tpath = $this->baseurl.'/templates/'.$this->template;

// generator tag
$this->setGenerator(null);

// template css
$doc->addStyleSheet($tpath.'/css/template.css.php');

?><!doctype html>

<html lang="<?php echo $this->language; ?>">

<head>
	<jdoc:include type="head" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link rel="apple-touch-icon-precomposed" href="<?php echo $tpath; ?>/images/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $tpath; ?>/images/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $tpath; ?>/images/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $tpath; ?>/images/apple-touch-icon-144x144-precomposed.png">
    <link rel="stylesheet" type="text/css" href="//cloud.typography.com/7311712/774524/css/fonts.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $tpath; ?>/css/mobilemenu.css"/>
  
	<?php if ($menu->getActive() == $menu->getDefault()) { ?>
		<script type="text/javascript" src="<?php echo $tpath; ?>/js/js_front.js"></script>
        <script type="text/javascript">
			var images = [
				"/images/slideshow/grill.png",
				"/images/slideshow/retail-case.png",
				"/images/slideshow/snacks.png",
				"/images/slideshow/veal.png"
			];
			
			// The index variable will keep track of which image is currently showing
			var newindex = 0,oldIndex;
			
			$(document).ready(function() {	
				// Call backstretch for the first time,
				// In this case, I"m settings speed of 500ms for a fadeIn effect between images.
				newindex = Math.floor((Math.random()*images.length));
				$.backstretch(images[newindex], {
					speed: 500
				});
			
				// Set an interval that increments the index and sets the new image
				// Note: The fadeIn speed set above will be inherited
				//
				
				setInterval(function() {
				   oldIndex = newindex;
					while (oldIndex == newindex) {
						newindex = Math.floor((Math.random()*images.length));
					}
					$.backstretch(images[newindex]);
				}, 5000);
			
				// A little script for preloading all of the images
				// It"s not necessary, but generally a good idea
				$(images).each(function() {
					$("<img/>")[0].src = this;
				});
				
			});
			
			$(document).ready(function() {	
				var bar = $('.header');
				var windowheight = $( window ).height();
				var top = bar.css('top');
				$(window).scroll(function() {
					if($(this).scrollTop() > windowheight/2) {
						bar.stop().animate({'top' : '0px'}, 500);
					} else {
						bar.stop().animate({'top' : top}, 500);
					}
				});
			});
			
			$(document).ready(function(){				   
				$(".nav-button").click(function () {
				$(".nav-button,.primary-nav").toggleClass("open");
				});    
			});
			
			$(document).ready(function() {
				$('ul.thumbs').portfolio({
					cols: 4,
					transition: 'slideDown'
				});
			});
			
		</script>
    <?php } else { ?>
    	<script type="text/javascript" src="<?php echo $tpath; ?>/js/js.js"></script>
        <script type="text/javascript">
			$(document).ready(function(){				   
				$(".nav-button").click(function () {
				$(".nav-button,.primary-nav").toggleClass("open");
				});    
			});
			
			$(document).ready(function() {
				$('ul.thumbs').portfolio({
					cols: 4,
					transition: 'slideDown'
				});
			});
        </script>    
    <?php } ?>
</head>
  
<body class="<?php echo (($menu->getActive() == $menu->getDefault()) ? ('front') : ('site')).' '.$active->alias.' '.$pageclass; ?>">
	
    <?php if ($this->countModules('header-navigation')) : ?>
        <div class="header">
        	<div class="container">
            	<button class="nav-button">Toggle Navigation</button>
        		<jdoc:include type="modules" name="header-navigation" />
            </div>
        </div>
    <?php endif;?>
    
    <?php if (($menu->getActive() == $menu->getDefault()) && ($this->countModules('landing-navigation'))) { ?>
    	<div id="slide0" data-slide="0" class="slide" data-stellar-background-ratio="0">
        <div class="container">    
		    <jdoc:include type="modules" name="landing-navigation" />
        </div>
    </div>
    <?php } ?>
    <?php if ($menu->getActive() == $menu->getDefault()) { ?>
    	<a name="<?php echo $pageclass; ?>"></a>
    <?php } ?>
    <div id="slide1" data-slide="1" class="slide" data-stellar-background-ratio="0">
        <div class="container">
        	<?php if ($this->countModules('top')) : ?>
                <div class="top">
                    <jdoc:include type="modules" name="top" />
                </div>
            <?php endif;?>
            
		    <jdoc:include type="component" />
            
			<?php if ($this->countModules('bottom')) : ?>
                <div class="bottom">
                    <jdoc:include type="modules" name="bottom" />
                </div>
            <?php endif;?>
        </div>
    </div>

	<?php if ($this->countModules('footer-navigation') || $this->countModules('social-navigation') || $this->countModules('copyright')) : ?>
        <div class="footer">
        
        	<div class="container">
            
            	<div class="footer-logo footer-block">
                    <a href="">
                        <img src="<?php echo $tpath; ?>/images/allebach-logo-footer.png" />
                    </a>
                </div>
                
				<?php if ($this->countModules('footer-navigation')) : ?>
                    <div class="footer-navigation footer-block">
                        <jdoc:include type="modules" name="footer-navigation" />
                    </div>
                <?php endif;?>
                
                <?php if ($this->countModules('social-navigation')) : ?>
                    <div class="social-navigation footer-block">
                        <jdoc:include type="modules" name="social-navigation" />
                    </div>
                <?php endif;?>
                
                
                <?php if ($this->countModules('copyright')) : ?>
                    <div class="copyright">
                        <jdoc:include type="modules" name="copyright" />
                    </div>
                <?php endif;?>
                
            </div>
            
        </div>
    <?php endif;?>
  
	<jdoc:include type="modules" name="debug" />
  
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-18409671-1', 'auto');
	  ga('send', 'pageview');
	
	</script>
</body>

</html>