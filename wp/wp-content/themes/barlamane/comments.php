<?php
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="content-box">
	<?php
		hybrid_comment_form();
		if ( have_comments() ) :
		?>
        <ul class="comment-list unstyle-list">
			<?php
                $args = array(
                    'callback'          => 'hybrid_comment',
                    'type'              => 'comment',
                    'avatar_size'		=> 50
                );
                wp_list_comments($args);
            ?>
        </ul>
		<?php
		endif;
	?>
</div>

