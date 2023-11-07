<?php 
	get_header();
?>
<div class="container">
	<div class="right-content">
		<div class="main-content single-content main-content-left">
        	<article class="post-content opinion">
			<?php 
				while ( have_posts() ) : the_post();
					$custom = get_post_custom();
			?>
					<div class="opinion-meta">
                    	<div class="author-thumb">
                        <?php
							if ( has_post_thumbnail() ){
								the_post_thumbnail('barlamane-opinion-thumb');
							}
						?>
                        </div>
                        <div class="meta">
                        	<span class="author-name">
                            	<i class="fa fa-user"></i> <?php echo $custom["avis_author"][0];?>
							</span>
                        	<span class="opinion-date">
								<i class="fa fa-clock-o"></i> <?php the_time('G:i - j F Y'); ?>
							</span>
                        </div>
                        <h1 class="opinion-title"><?php the_title() ;?></h1>
                        <div class="clear"></div>
                    </div>
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
                    <div class="content">
                        <?php the_content();?>
                        <hr>
                        <p style="font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;font-weight:700;color:#244E8C">
							الآراء الواردة في هذا المقال تعبر عن مواقف صاحبها ولا تلزم موقع برلمان.كوم
						</p>
                    </div>
			<?php
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
			</article>
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
        <?php get_sidebar(); ?>
	</div>
    <div class="clear"></div>
</div>
<?php
	get_footer();
?> 