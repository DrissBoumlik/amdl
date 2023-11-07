<?php 
	get_header();
	$custom = get_post_custom();
	$content = get_the_content();
/*	$author_name = '';
	$author = get_the_author();

	if( !$custom['normal_post_author'][0] ) {
		//$author_name = $author-
	}*/
?>
<div class="container">
	<div class="right-content">
		<div class="main-content single-content">
			<?php
			/*
				if(is_user_logged_in()) {
			?>
            	<div class="logged-in" style="margin: 0 0 20px;border: solid 1px #ccc;background-color: #fff;font-weight:bold;padding: 10px 20px;">
					<span style="color: #C40003;">كاتب المقال :</span> <?php the_author_meta( 'display_name'); ?>
                </div>
            <?php 
				}
				*/
			?>
        	<article class="post-content">
			<?php
				while ( have_posts() ) : the_post();
			?>
                    <div class="date"><i class="fa fa-clock-o"></i> <?php the_time('G:i - j F Y'); ?></div>
                    <h1 class="title"><?php the_title() ;?></h1>
				<?php
					if ( has_post_thumbnail() && !in_category(4) && !in_category(17534)){
						$image_caption= get_post(get_post_thumbnail_id())->post_content;
				?>
						<div style="background-color:#000;">
							<div class="thumb">
								<?php 
									the_post_thumbnail('barlamane-single-post-thumb');
									if($image_caption){
										echo '<div class="image-caption" style="display:none;">'.$image_caption.'</div>';
									}
								?>
							</div>
						</div>
				<?php
					}
					if($custom['normal_post_author'])
						echo '<div class="author"><i class="fa fa-user"></i> ' . (!empty($custom['normal_post_author'][0]) ? $custom['normal_post_author'][0]  : 'برلمانكم') . '</div>';
					else
						echo '<div class="author"><i class="fa fa-user"></i>برلمانكم</div>';
					
						
				?>
					<div class="social">
						<!-- twitter -->
						<div class="twitter">
							<a href="https://twitter.com/share" class="twitter-share-button" data-lang="fr">Tweeter</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
						</div>
						<!-- facebook -->
						<div class="facebook">
							<div class="fb-like" data-action="like" data-layout="button_count" data-share="true" data-show-faces="false" ></div>
						</div>
						<div class="clear"></div>
					</div>
				<?php
					if($content){
						echo '<div class="content">';
							the_content();
						echo'</div><div class="clear"></div>';
					}
				?>
				<?php
				/*
					$tags=get_the_tags();
					$tags_html = '';
					if($tags){
						foreach ( $tags as $tag ) {
							$tag_link = get_tag_link( $tag->term_id );
									
							$tags_html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
							$tags_html .= "{$tag->name}</a>";
						}
						echo '<div class="tags" ><div class="tags-title">كلمات مفتاحية :</div>'.$tags_html.'</div>';

					}
					*/
				endwhile;
			?>

        <center>
	<div class="bilboardbarla" style="margin-top:20px;margin-bottom:5px;">
<!-- /105888583/Barlamane-Mobile-300x100 -->
<div id='div-gpt-ad-1538566620415-0' style='height:100px; width:300px;'>
<script>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1538566620415-0'); });
</script>
</div>

</div>

		</center>
			<center>
			<div class="ads-300 ads">
<!-- /105888583/barlamane-pave-300x600 -->
<div id='div-gpt-ad-1539950505438-0' style='height:600px; width:300px;'>
<script>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1539950505438-0'); });
</script>
</div>
	         </div>
			</center>
			</article>
            <?php 
				hybrid_related_posts();
				//hybrid_post_nav();
			?>
			<div class="post-comments">
            <?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			?>
			</div>
		</div>
	</div>
	<div class="sidebar single-sidebar-main">
		<?php
			get_sidebar();
		?>
	</div>
    <div class="clear"></div>
</div>
<?php
	get_footer();
?> 