<?php
	get_header();
	
	$milaf_img = 'https://www.barlamane.com/wp-content/uploads/2018/06/34586105_1003218399843144_9068372916319551488_n.jpg';
?> 
<div class="container">
	<div class="right-content">
		<div class="main-content slider-tmp main-content-right">
		<?php
			ht_slider(14,15);
			hybrid_home_box('سياسة','#d61d00','https://www.barlamane.com/category/الأخبار/سياسة/',10);
			hybrid_home_box('مجتمع','#6A678A','https://www.barlamane.com/category/الأخبار/مجتمع/',13);
			hybrid_home_box('إقتصاد','#27ae60','https://www.barlamane.com/category/الأخبار/مال-و-أعمال/',11);
			hybrid_home_box('رياضة','#D8841A','https://www.barlamane.com/category/الأخبار/رياضة/',12);
			hybrid_home_box('ثقافة','#32475b','https://www.barlamane.com/category/الأخبار/ثقافة/',65);
			hybrid_home_box('محليات','#e74c3c','https://www.barlamane.com/category/الأخبار/محليات/',1076);
			hybrid_home_box('خارج الحدود','#596127','https://www.barlamane.com/category/الأخبار/خارج-الحدود/',17);
		?>
		</div>
		<div class="sidebar home-sidebar-second">
			<?php /* <div class="widget">
                <a href="https://www.barlamane.com/category/%D8%AE%D8%A7%D8%B5-%D8%A8%D9%85%D9%88%D8%A7%D8%B2%D9%8A%D9%86/"><img src="https://www.barlamane.com/wp-content/uploads/2018/06/special-mawazine-ar.jpg" alt="miw-ads" /></a>
            </div>
            */ ?>
            <div class="widget">
                <div class="cat-header" style="background-color:#eb8b46;">
                    <a href="https://www.barlamane.com/category/الأخبار/فن/" >
                   		فن
					</a>
                </div>
				<?php hybrid_posts_list(7,64,'scope');?>
            </div>
            <div class="widget">
                <div class="cat-header" style="background-color:#34495e;">
                    <a href="https://www.barlamane.com/category/برلمانيات/" >
                		شؤون برلمانية	
					</a>
                </div>
				<?php hybrid_posts_list(4,3,'latest');?>
            </div>
			<div class="widget">
				<div class="cat-header" style="background-color:#0099CC;">
					<a href="https://www.barlamane.com/category/الأخبار/بيئة-وعلوم/" >
						بيئة و علوم	
					</a>
				</div>
				<?php hybrid_posts_list(7,20,'scope');?>
			</div>
        	<div class="widget">
    			<div class="cat-header" style="background-color:#34495e;">
                    <a href="https://www.barlamane.com/category/%D8%A7%D9%84%D8%A3%D8%AE%D8%A8%D8%A7%D8%B1/%D9%85%D9%84%D9%81-%D8%A7%D9%84%D8%A3%D8%B3%D8%A8%D9%88%D8%B9/" >
    					ملف الأسبوع
    				</a>
    			</div>
    			<div class="newspappers">
    				<?php
    					$args = array(
                            'posts_per_page'=>1,
                        	'cat'=>'41327' 		
    					);
    					query_posts( $args );
    					while ( have_posts() ) : the_post();
                    		$title=get_the_title(); 
    				?>
    					<a href="<?php the_permalink() ?>">
    						<span class="thumb">
    							<?php
                                	the_post_thumbnail('barlamane-single-post-thumb');
                            	?>
                            </span>
                        	<span class="title"><?php echo hybrid_cutter($title,20); ?></span>
                    	</a>
    				<?php
    					endwhile;
                    	wp_reset_query();
    				?>
    			</div>
            </div>
			<div class="widget">
				<div class="cat-header" style="background-color:#3C5B9B;">
            		<a href="<?php echo esc_url(home_url("type/رأي-في-قضية/")); ?>">
						رأي في قضية
            	    </a>
				</div>
				<?php hybrid_opinion_list(5);?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="sidebar home-sidebar-main">
    	<div class="widget">
			<div class="cat-header" style="background-color:#34495e;">
                <a href="https://www.barlamane.com/category/الأخبار/جديد-الصحف/" >
                    جديد الصحف
                </a>
			</div>
			<div class="newspappers">
				<?php
					$args = array(
                        'posts_per_page'=>1,
                    	'cat'=>'7995' 		
					);
					query_posts( $args );
					while ( have_posts() ) : the_post();
                		$title=get_the_title(); 
				?>
					<a href="<?php the_permalink() ?>">
						<span class="thumb">
							<?php
                            	the_post_thumbnail('barlamane-single-post-thumb');
                        	?>
                        </span>
                    	<span class="title"><?php echo hybrid_cutter($title,20); ?></span>
                	</a>
				<?php
					endwhile;
                	wp_reset_query();
				?>
			</div>
        </div>
    	<div class="widget">
            <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                <input type="text" value="<?php the_search_query(); ?>" placeholder="..." name="s" id="search_input" /><!--
                --><button type="submit" id="searchsubmit" value="Search"><i class=" fa fa-search"></i></button>
            </form>
        </div>
		<div class="widget">
			<div class="cat-header" style="background-color: #185f7d;">
				<a href="http://www.barlamane.com/category/%D8%A8%D8%B1%D9%84%D9%85%D8%A7%D9%86-%D8%AA%D9%8A%D9%81%D9%8A/">
					برلمان تيفي
				</a>
			</div>
			<?php hybrid_videos_list(6,17534,'video');?>
		</div>
		<div class="widget">
			<div class="cat-header" style="background-color:#359BED;">
				<a href="https://www.barlamane.com/category/برلمان-tv/" >
					صوت و صورة
				</a>
			</div>
			<?php hybrid_videos_list(16,4,'video');?>
		</div>
	</div>
    <div class="clear"></div>
</div>
<?php
	get_footer();
?>

