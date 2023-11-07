<!DOCTYPE html>
<html dir="rtl" lang="ar" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<head>
    <title><?php wp_title('&laquo;', true, 'right'); ?></title>
    <meta name="google-site-verification" content="nthMK72Bl2TOqYqitdmysIz9Do_ohBQUzJiaDkwznWg" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="msvalidate.01" content="D02E6454583A82FE167E3510F0589BE1" />
    <meta name="p:domain_verify" content="05401254cd279306c59e633090175889"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
    <!-- Start Alexa Certify Javascript -->
    <script type="text/javascript">
    _atrk_opts = { atrk_acct:"Pt/+l1aU8KL34B", domain:"barlamane.com",dynamic: true};
    (function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
    </script>
    <noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=Pt/+l1aU8KL34B" style="display:none" height="1" width="1" alt="" /></noscript>
    <!-- End Alexa Certify Javascript -->
    <script async src='//barlamane.engine.adglare.net/?252336704|904832806|846441087|920549203'></script>
</head>
<body <?php body_class(); ?> style="padding-bottom:0px;">
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-69480264-1', 'auto');
	  ga('send', 'pageview');
	
	</script>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.4&appId=1651322518487691";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
	<header>
		<?php
			hybrid_news_ticker(8615,'مستجدات',10);
		?>
        <!-- Logo + Banner Container -->
    	<div class="container" style="margin-top:35px;">
            <div class="top-header">
                <div id="logo-top" class="logo-top">
                    <a href="http://www.barlamane.com">
						<img src="http://www.barlamane.com/wp-content/uploads/2015/10/logo_barlamane2-1.png" alt='barlamane-logo' />
                    </a>
                </div>
                <div class="clear"></div>
            </div>
		</div>
        <!-- Menu -->
       	<div id="top-nav-container">
			<div class="container">
                <div class="top-nav">
                    <nav class="main-nav megamenu" id="main-nav">
						<div class="nav-toggle noselect" id="main-nav-toggle">
							<i class="fa fa-bars"></i>
							<i class="fa fa-times"></i>
						</div>
                    	<div class="secondary-logo">
                        	<a href="http://www.barlamane.com">
                                <?php
									if(is_home())
										echo '<h1>Barlamane.com</h1>';
									else
										echo '<h2>Barlamane.com</h2>';
                                ?>
                        	</a>
                        </div>
                        <div class="lang">
							<a href="http://www.barlamane.com/fr">
								Français
							</a>
						</div>
						<?php
                            if ( has_nav_menu( 'main_menu' ) ) :
                                wp_nav_menu( array(
                                    'theme_location'    => 'main_menu',
                                    'depth'             => 2,
                                    'container'         => '',
                                    'container_class'   => '',
                                    'menu_class'        => 'unstyle-list',
                                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                                    'walker'            => new wp_bootstrap_navwalker())
                                );
                            endif;
						?>
						<div class="clear"></div>
					</nav>
                </div>
            </div>
        </div>
	</header>
    <div class="container">
    <?php 
		top_posts();
	?>
    </div>
	<div class="container">
        	<article class="post-content" style="text-align:center;font-size:90px;font-weight:bold;padding:50px 10px;background:#222;color:#fff;">
            	404
                <div style="font-size:32px;color:#09C;">الملف غير موجود</div>
			</article>
	</div>
<?php
	get_footer();
?> 