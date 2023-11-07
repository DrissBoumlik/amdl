<?php 
	get_header();
?>
<div class="container">
	<div class="right-content">
		<div class="main-content main-content-left category-content">
			<div class="search-bar">
                <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                    <input type="text" value="<?php the_search_query(); ?>" placeholder="..." name="s" id="search_input" /><!--
					--><button type="submit" id="searchsubmit" value="Search"><i class=" fa fa-search"></i></button>
                </form>
        	</div>
        	<?php hybrid_category_loop();?>
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