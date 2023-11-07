<?php 
	get_header();
?>
<div class="container">
	<div class="right-content">
		<div class="main-content category-content">
            <div class="tax-container">
			<?php
                if ( is_day() ) :
					echo '<span class="tax-value">'.get_the_date().'</span>' ;
                elseif ( is_month() ) :
					echo '<span class="tax-value">'.get_the_date('F Y').'</span>' ;
                elseif ( is_year() ) :
					echo '<span class="tax-value">'.get_the_date('Y').'</span>' ;
                else :
                    echo 'Archives';
                endif;
            ?>
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