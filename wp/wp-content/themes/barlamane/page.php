<?php 
	get_header();
?>
<div class="container">
	<div class="right-content">
		<div class="main-content single-content main-content-left">
        	<article class="post-content">
			<?php 
				while ( have_posts() ) : the_post(); 
			?>
					<h2 class="title"><?php the_title() ;?></h2>
					<div class="content">
						<?php the_content();?>
					</div>
			<?php
				endwhile;
			?>
			</article>
		</div>
	</div>
	<div class="sidebar single-sidebar-main">
        <?php get_sidebar(); ?>
	</div>
    <div class="clear"></div>
</div>
<?php
	get_footer();
?> 