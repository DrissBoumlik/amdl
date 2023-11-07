<?php 
	get_header();
?>
<div class="container">
	<div class="right-content">
		<div class="main-content category-content">
            <div class="tax-container"><span class="tax-name">الوسم :</span> <?php single_cat_title(); ?></div>
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
