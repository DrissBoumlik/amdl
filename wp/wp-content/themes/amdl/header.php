<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta name="description" content="<?php bloginfo('description'); ?>">

	<?php wp_head(); ?>

	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<meta http-equiv='X-UA-Compatible' content='ie=edge'>
	<link href="<?php echo get_template_directory_uri(); ?>/img/logos/favicon.ico" rel="shortcut icon">

	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' type='text/css' media='all' />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/animate.css" crossorigin="anonymous">
	<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/style.css'> -->

	<!-- Latest compiled and minified JavaScript -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script> -->
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->

	<title>Document</title>

</head>

<body <?php body_class(); ?>>
	<header class="header">
		<div class="menu">
			<nav class="navbar navbar-default menu-top">
				<div class="container">
					<div id="navbar-top" class="navbar-collapse collapse">
						<?php
						wp_nav_menu(array(
							'theme_location'    => 'top-menu',
							'depth'             => 2,
							'container'         => 'div',
							'container_class'   => 'collapse navbar-collapse',
							'container_id'      => 'navbar-top',
							'menu_class'        => 'nav navbar-nav navbar-right menu-top-items',
							'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
							'walker'            => new WP_Bootstrap_Navwalker(),
						));
						?>
						<!-- <ul class="nav navbar-nav navbar-right menu-top-items">
							<li class="main-items"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/top-menu/sound.png" alt="">
									Annonces</a></li>
							<li class="main-items"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/top-menu/newsletter.png" alt=""> Newsletter</a></li>
							<li class="main-items"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/top-menu/faq.png" alt="">
									FAQ</a></li>
							<li class="main-items"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/img/top-menu/contact.png" alt=""> Contact</a></li>
							<li class="dropdown langues">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><img src="<?php echo get_template_directory_uri(); ?>/img/top-menu/lang.png" alt="">
									langues<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#" class="capitalize">français</a></li>
									<li><a href="#" class="capitalize">anglais</a></li>
									<li><a href="#" class="capitalize">amazigh</a></li>
									<li><a href="#" class="capitalize">arabe</a></li>
								</ul>
							<li class="social"><a href="#"><i class="fas fa-rss"></i></a></li>
							<li class="social"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li class="social"><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li class="social"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
							<li class="social"><a href="#"><i class="fab fa-instagram"></i></a></li>
							<li class="social"><a href="#"><i class="fab fa-youtube"></i></a></li>
							</li>
						</ul> -->
					</div>
					<!--/.nav-collapse -->
				</div>
				<!--/.container-fluid -->
			</nav>
			<hr class="nav-line" />
			<nav class="navbar navbar-default menu-primary">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							<img src="<?php echo get_template_directory_uri(); ?>/img/logos/logo-amdl.png" alt="">
						</a>
					</div>
					<div id="navbar" class="navbar-collapse collapse" aria-expanded="true">
					<?php
					wp_nav_menu(array(
						'theme_location'    => 'primary-menu',
						'depth'             => 2,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'navbar',
						'menu_class'        => 'nav navbar-nav navbar-right',
						'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						'walker'            => new WP_Bootstrap_Navwalker(),
					));
					?>
					</div>
					<!-- <div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li><a href="#">ACCUEIL</a></li>
							<li class="active"><a href="#">AMDL</a></li>
							<li><a href="#">LA LOGISTIQUE AU MAROC</a></li>
							<li><a href="#">ZONES LOGISTIQUES</a></li>
							<li><a href="#">ACTEURS LOGISTIQUES</a></li>
						</ul>
					</div> -->
					<!--/.nav-collapse -->
				</div>
				<!--/.container-fluid -->
			</nav>
		</div>
	</header>