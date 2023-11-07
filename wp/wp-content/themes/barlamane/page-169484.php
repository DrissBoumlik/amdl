<?php 
	global $wp_query;
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<head>
    <title><?php wp_title(); ?></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="msvalidate.01" content="D02E6454583A82FE167E3510F0589BE1" />
    <meta name="p:domain_verify" content="05401254cd279306c59e633090175889"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="icon" href="http://www.barlamane.com/wp-content/uploads/2014/05/favicon2.png" type="image/png"/>
	<link rel="shortcut icon" href="http://www.barlamane.com/wp-content/uploads/2014/05/favicon-1.png" />
    <?php wp_head(); ?>
</head>
<body>
	<div class="main-content single-content main-content-left">
       	<article class="post-content">
			<?php 
				echo '<div class="content">';
				$authors = array (25,40,38,32,47,44,46,31);
				$today = getdate();
				$day = get_query_var('dd',$today["mday"]);
				$month = get_query_var('mm',$today["mon"]);
				$year = get_query_var('yy',$today["year"]);
			?>
				<div class="rapport-search-form">
					<form action="#">
						<input type="text" name="dd" class="day" value="<?php echo $day?>"/>
						<select id="mm" name="mm" class="month">
							<option value="1" data-text="يناير" <?php selected( $month, '1' ); ?>>01-يناير</option>
							<option value="2" data-text="فبراير" <?php selected( $month, '2' ); ?>>02-فبراير</option>
							<option value="3" data-text="مارس" <?php selected( $month, '3' ); ?>>03-مارس</option>
							<option value="4" data-text="أبريل" <?php selected( $month, '4' ); ?>>04-أبريل</option>
							<option value="5" data-text="مايو" <?php selected( $month, '5' ); ?>>05-مايو</option>
							<option value="6" data-text="يونيو" <?php selected( $month, '6' ); ?>>06-يونيو</option>
							<option value="7" data-text="يوليو" <?php selected( $month, '7' ); ?>>07-يوليو</option>
							<option value="8" data-text="أغسطس" <?php selected( $month, '8' ); ?>>08-أغسطس</option>
							<option value="9" data-text="سبتمبر" <?php selected( $month, '9' ); ?>>09-سبتمبر</option>
							<option value="10" data-text="أكتوبر" <?php selected( $month, '10' ); ?>>10-أكتوبر</option>
							<option value="11" data-text="نوفمبر" <?php selected( $month, '11' ); ?>>11-نوفمبر</option>
							<option value="12" data-text="ديسمبر" <?php selected( $month, '12' ); ?>>12-ديسمبر</option>
						</select>
						<input type="text" name="yy" class="year" value="<?php echo $year?>"/>
						<input type="submit" value="تحديث">
					</form>
				</div>
			<?php
				foreach($authors as $author) {
					$args = array(
						'author'        => $author,
						'order'         =>  'ASC' ,
						'year' => $year,
						'monthnum' => $month,
						'day' => $day,
						'post_status' => array('publish', 'future','pending')
					);
					query_posts( $args );
					echo '<h2>' . get_user_by('ID',$author)->data->display_name . ' - ' . $wp_query->found_posts . '</h2>';
					echo '<ul class="content">';
					
					while ( have_posts() ) : the_post();
			?>
						<li class="rapport-post">
							<?php the_time(); ?> - 
                        	<?php
								if( get_post_status() == 'future' )
									echo '<span style="color: #24C353">مجدول<span> - ';
								elseif( get_post_status() == 'pending' )
									echo '<span style="color: #ff0000;">بانتظار المراجعة<span> - ';
                            ?>
                           	<a href="<?php the_permalink();?>"><?php the_title() ;?></a>
						</li>
			<?php
					endwhile;
					echo '</ul>';
					wp_reset_query();
				}
				echo '</div>';
			?>
		</article>
		<h2>هذا الشهر</h2>
        <article class="post-content">
		<?php 
			echo '<div class="content">';
			$month_1 = $today["mon"];
			$year_1 = $today["year"];
			foreach($authors as $author) {
				$args_1 = array(
					'author'        => $author,
					'order'         =>  'ASC' ,
					'year' => $year_1,
					'monthnum' => $month_1,
					'post_status' => array('publish', 'future','pending')
				);
				query_posts( $args_1 );
				echo '<h2>' . get_user_by('ID',$author)->data->display_name . ' - ' . $wp_query->found_posts . '</h2>';
				wp_reset_query();
			}
			echo '</div>';
		?>
		</article>
	</div>
	<?php
		wp_footer();
	?>
</body>
</html>