<?php /* Template Name: Demo Page Template */ get_header(); ?>

	
	<!-- fullscreen -->
	<header class="header">
		<div class="menu">
			<nav class="navbar navbar-default menu-top">
				<div class="container-fluid">
					<div id="navbar-top" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right social">
							<li><a href="#"><i class="fas fa-rss"></i></a></li>
							<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
							<li><a href="#"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#"><i class="fab fa-youtube"></i></a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right menu-top-items">
							<li><a href="#"><img src="./assets/img/top-menu/sound.png" alt=""> Annonces</a></li>
							<li><a href="#"><img src="./assets/img/top-menu/newsletter.png" alt=""> Newsletter</a></li>
							<li><a href="#"><img src="./assets/img/top-menu/faq.png" alt=""> FAQ</a></li>
							<li><a href="#"><img src="./assets/img/top-menu/contact.png" alt=""> Contact</a></li>
							<li class="dropdown langues">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
									aria-haspopup="true" aria-expanded="true"><img src="./assets/img/top-menu/lang.png"
										alt=""> langues<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#" class="capitalize">français</a></li>
									<li><a href="#" class="capitalize">anglais</a></li>
									<li><a href="#" class="capitalize">amazigh</a></li>
									<li><a href="#" class="capitalize">arabe</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<!--/.nav-collapse -->
				</div>
				<!--/.container-fluid -->
			</nav>
			<hr class="nav-line" />
			<nav class="navbar navbar-default menu-primary">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
							data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							<img src="./assets/img/logos/logo-amdl.png" alt="">
						</a>
					</div>
					<div id="navbar-primary" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li><a href="#">ACCUEIL</a></li>
							<li class="active"><a href="#">AMDL</a></li>
							<li><a href="#">LA LOGISTIQUE AU MAROC</a></li>
							<li><a href="#">ZONES LOGISTIQUES</a></li>
							<li><a href="#">ACTEURS LOGISTIQUES</a></li>
						</ul>
					</div>
					<!--/.nav-collapse -->
				</div>
				<!--/.container-fluid -->
			</nav>
		</div>
		<div id="carousel" class="carousel slide carousel-fullscreen carousel-fade" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel" data-slide-to="0" class="active"></li>
				<li data-target="#carousel" data-slide-to="1"></li>
				<li data-target="#carousel" data-slide-to="2"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<div class="overlay"></div>
					<div class="carousel-caption">
						<div class="carousel-caption-wrapper">
							<div class="row">
								<div class="col-md-12">
									<div class="carousel-caption-container">
										<p class="super-date uppercase">Rabat, le 16 janvier 2018</p>
										<h1 class="super-heading">le conseil d'administration de l'amdl a adopté son
											plan d'actions et son budget au titre de l'année 2019</h1>
										<p class="super-paragraph">L'année 2018 a été particlièrement marquée par une
											ouverture effective de l'Agence</p>
									</div>
								</div>
							</div>
						</div>
						<button class="btn carousel-caption-btn"><a href="#">LIRE PLUS</a></button>
					</div>
				</div>
				<div class="item">
					<div class="overlay"></div>
					<div class="carousel-caption">
						<div class="carousel-caption-wrapper">
							<div class="row">
								<div class="col-md-12">
									<div class="carousel-caption-container">
										<p class="super-date uppercase">Rabat</p>
										<h1 class="super-heading">le conseil d'administration de l'amdl a adopté son
											plan d'actions et son budget au titre de l'année 2019</h1>
										<p class="super-paragraph">L'année 2018 a été particlièrement marquée par une
											ouverture effective de l'Agence</p>
									</div>
								</div>
							</div>
						</div>
						<button class="btn carousel-caption-btn"><a href="#">LIRE PLUS</a></button>
					</div>
				</div>
				<div class="item">
					<div class="overlay"></div>
					<div class="carousel-caption">
						<div class="carousel-caption-wrapper">
							<div class="row">
								<div class="col-md-12">
									<div class="carousel-caption-container">
										<p class="super-date uppercase">Rabat</p>
										<h1 class="super-heading">le conseil d'administration de l'amdl a adopté son
											plan d'actions et son budget au titre de l'année 2019</h1>
										<p class="super-paragraph">L'année 2018 a été particlièrement marquée par une
											ouverture effective de l'Agence</p>
									</div>
								</div>
							</div>
						</div>
						<button class="btn carousel-caption-btn"><a href="#">LIRE PLUS</a></button>
					</div>
				</div>
			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</header>
	<div class="section brands">
		<div class="container">
			<div class="wrapper">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-3"><img src="./assets/img/logos/pme-logis.png" alt=""></div>
							<div class="col-md-9">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
									Ipsum
									has been the industry's standard dummy text ever since the 1500s, when an unknown
									printer took a galley of type and scrambled.</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-3"><img src="./assets/img/logos/mla.png" alt=""></div>
							<div class="col-md-9">
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
									Ipsum
									has been the industry's standard dummy text ever since the 1500s, when an unknown
									printer took a galley of type and scrambled.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="section updates">
		<div class="container">
			<div class="row headline">
				<h1 class="uppercase">Actualités</h1>
				<hr>
				<hr>
			</div>
			<div class="row articles">
				<div class="col-md-4">
					<div class="card">
						<img class="card-img-top" src="./assets/img/articles/art1.jpg" alt="Card image cap">
						<div class="card-body">
							<div class="row">
								<div class="col-md-3">
									<div class="article-date">
										<span class="day bold">19</span>
										<hr>
										<span class="month">NOV 2018</span>
									</div>
								</div>
								<div class="col-md-9">
									<div class="article">
										<h3 class="uppercase article-title">Lorem Ipsum is simply dummy text of the
											printing and
											typesetting industry.
										</h3>
										<p class="article-body">Lorem Ipsum is simply dummy text of the printing and
											typesetting industry.
										</p>
										<span><i class="fas fa-long-arrow-alt-right"></i><a href="#"
												class="uppercase bold">Lire plus</a></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card">
						<img class="card-img-top" src="./assets/img/articles/art3.png" alt="Card image cap">
						<div class="card-body">
							<div class="row">
								<div class="col-md-3">
									<div class="article-date">
										<span class="day bold">19</span>
										<hr>
										<span class="month">NOV 2018</span>
									</div>
								</div>
								<div class="col-md-9">
									<div class="article">
										<h3 class="uppercase article-title">Lorem Ipsum is simply dummy text of the
											printing and
											typesetting industry.
										</h3>
										<p class="article-body">Lorem Ipsum is simply dummy text of the printing and
											typesetting industry.
										</p>
										<span><i class="fas fa-long-arrow-alt-right"></i><a href="#"
												class="uppercase bold">Lire plus</a></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card">
						<img class="card-img-top" src="./assets/img/articles/art2.jpg" alt="Card image cap">
						<div class="card-body">
							<div class="row">
								<div class="col-md-3">
									<div class="article-date">
										<span class="day bold">19</span>
										<hr>
										<span class="month">NOV 2018</span>
									</div>
								</div>
								<div class="col-md-9">
									<div class="article">
										<h3 class="uppercase article-title">Lorem Ipsum is simply dummy text of the
											printing and
											typesetting industry.
										</h3>
										<p class="article-body">Lorem Ipsum is simply dummy text of the printing and
											typesetting industry.
										</p>
										<span><i class="fas fa-long-arrow-alt-right"></i><a href="#"
												class="uppercase bold">Lire plus</a></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<ol class="updates-indicators">
					<li class="active"></li>
					<li></li>
					<li></li>
				</ol>
			</div>
		</div>
	</div>
	<div class="section media-sections">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="row carte">
						<div class="col-md-12">
							<img src="./assets/img/media/carte.png" alt="">
							<p class="uppercase bold">carte intéractive</p>
						</div>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-1">
					<div class="row media">
						<div class="col-md-4">
							<img src="./assets/img/media/camera.png" alt="">
							<p class="uppercase bold">carte intéractive</p>
						</div>
						<div class="col-md-4">
							<img src="./assets/img/media/video.png" alt="">
							<p class="uppercase bold">carte intéractive</p>
						</div>
						<div class="col-md-4">
							<img src="./assets/img/media/pubs.png" alt="">
							<p class="uppercase bold">carte intéractive</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="section agenda">
		<div class="container">
			<div class="row headline">
				<h1 class="uppercase">agenda</h1>
				<hr>
				<hr>
			</div>
			<div class="row">
				<div class="col-md-1">
					<div class="timeline" id="timeline">
						<div class="active uppercase"><span></span><span>21 Mars</span></div>
						<div class="uppercase"><span></span><span>02 Janvier</span></div>
						<div class="uppercase"><span></span><span>15 Fevrier</span></div>
					</div>
				</div>
				<div class="col-md-6 col-md-offsetff-1">
					<h2 class="article-title uppercase">Lorem Ipsum is simply dummy text of the printing and
						typesetting industry</h2>
					<p class="article-body">Lorem Ipsum is simply dummy text of the printing and typesetting
						industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when
						an
						unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem
						Ipsum is
						simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
						industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
						of type and
						scrambled it to make a type specimen book.</p>
				</div>
				<div class="col-md-4">
					<img src="./assets/img/articles/art4.jpg" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="section partners">
		<div class="container">
			<div class="row headline">
				<h1 class="uppercase">partenaires institutionnels</h1>
				<hr>
				<hr>
			</div>
			<div class="partners-logos">
				<div class="row">
					<div class="col-md-2 col-md-offset-1"><img src="./assets/img/partners/partner1.png" alt=""></div>
					<div class="col-md-2"><img src="./assets/img/partners/partner2.png" alt=""></div>
					<div class="col-md-2"><img src="./assets/img/partners/partner3.png" alt=""></div>
					<div class="col-md-2"><img src="./assets/img/partners/partner4.png" alt=""></div>
					<div class="col-md-2"><img src="./assets/img/partners/partner5.png" alt=""></div>
				</div>

				<a class="left" href="#">
					<span class="fa fa-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right" href="#">
					<span class="fa fa-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
	<div class="section community">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<h2 class="uppercase blue-ciel-2"><i class="fas fa-folder"></i>communauté logistique</h2>
					<p>Vous voulez figurer dans notre annuaire professionnel ? Vous avez un événement logistique à
						promouvoir ?</p>
					<p>Cliquez ici pour remplir le formulaire de contact</p>
				</div>
				<div class="col-md-2">
					<button class="btn uppercase join-btn bold">rejoindre</button>
				</div>
			</div>
		</div>
	</div>
<!-- <?php //get_sidebar(); ?> -->

<?php get_footer(); ?>
