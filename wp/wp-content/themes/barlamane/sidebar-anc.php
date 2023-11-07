<?php 
/*
if ( function_exists( 'vote_poll' ) && ! in_pollarchive() ):
?>
    <aside class="widget">
        <div class="cat-header" style="background-color:#0089D5;"><span>إستطلاع رأي</span></div>
		<?php get_poll();?>
    </aside>
<?php
endif;
*/
if(!is_search()): ?>
<aside class="widget">
	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    	<input type="text" value="<?php the_search_query(); ?>" placeholder="..." name="s" id="search_input" /><!--
		--><button type="submit" id="searchsubmit" value="Search"><i class=" fa fa-search"></i></button>
	</form>
</aside>
<?php endif; ?>
<aside class="widget">
	<div class="ads-300 ads">
		<!-- /15109906/barlamane-pave-300x250 -->
		<div id='div-gpt-ad-1536170745210-0' style='height:250px; width:300px;'>
		<script>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1536170745210-0'); });
		</script>
		</div>
	</div>
</aside>
<aside class="widget">
	<div class="cat-header" style="background-color:#333;">
		<a href="http://www.barlamane.com/category/الأخبار/" >
			آخر الأخبار
		</a>
	</div>
	<?php hybrid_posts_list(4,6,'latest','data-mrf-order="1"');?>
</aside>
<aside class="widget">
	<div class="cat-header" style="background-color:#359BED;">
		<a href="http://www.barlamane.com/category/برلمان-tv/" >
			صوت و صورة
		</a>
	</div>
	<?php hybrid_videos_list(10,4,'video','data-mrf-order="2"');?>
</aside>