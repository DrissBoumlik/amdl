<?php
/*
	Post Type : Personality
*/

add_image_size( 'barlamane-personality-thumb', 180, 220, true );

// Register Post Type
function personalities_type() {
    $labels = array(
        'name'                  =>  'شخصيات',
        'singular_name'         =>  'شخصية',
        'add_new_item'          =>  'أضف شخصية جديدة',
        'all_items'             =>  'كل الشخصيات',
        'edit_item'             =>  'تحرير الشخصية',
        'new_item'              =>  'شخصية جديدة',
        'view_item'             =>  'معاينة الشخصية',
        'not_found'             =>  'الشخصية غير متوفرة',
        'not_found_in_trash'    =>  'الشخصية غير متوفرة'
    );
    $supports = array(
        'title',
        'editor',
		'thumbnail',
		'excerpt'
    );
    $args = array(
        'label'         =>   'شخصيات',
        'labels'        =>   $labels,
        'description'   =>   'إدارة الشخصيات',
        'public'        =>   true,
        'show_in_menu'  =>   true,
        'menu_icon'     =>   'dashicons-admin-users',
        'has_archive'   =>   true,
        'rewrite'       =>   true,
        'supports'      =>   $supports
    );
    register_post_type( 'personality', $args );
}
add_action( 'init', 'personalities_type' );

// Custom Metabox
function barlamane_add_personality_metabox() {
    add_meta_box('personality-metabox','معلومات حول الشخصية', 'render_personality_metabox', 'personality', 'side', 'core');
}
add_action( 'add_meta_boxes', 'barlamane_add_personality_metabox' );

function render_personality_metabox($post) {
 
    // generate a nonce field
    wp_nonce_field( basename( __FILE__ ), 'barlamane-personality-info-nonce' );
 
    // get previously saved meta values (if any)
    $personality_status = get_post_meta( $post->ID, 'barlamane-personality-status', true );
 
    ?>
        <label for="barlamane-personality-status">صفة</label>
		<input class="widefat personality-status-input" id="barlamane-personality-status" type="text" name="barlamane-personality-status" value="<?php echo $personality_status; ?>" />
	<?php
}

// To the db
function barlamane_save_personality_info( $post_id ) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['barlamane-personality-info-nonce'] ) && ( wp_verify_nonce( $_POST['barlamane-personality-info-nonce'], basename( __FILE__ ) ) ) ) ? true : false; 

    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }
    if ( 'personality' != $_POST['post_type'] ) {
        return;
    }
 
    // checking for the values and performing necessary actions
    if ( isset( $_POST['barlamane-personality-status'] ) ) {
        update_post_meta( $post_id, 'barlamane-personality-status', $_POST['barlamane-personality-status']);
    }
}
add_action( 'save_post', 'barlamane_save_personality_info' );

// Collums
function barlamane_custom_columns_head( $defaults ) {
 
    $defaults['personality_status'] ='صفة';
 
    return $defaults;
}
add_filter( 'manage_edit-personality_columns', 'barlamane_custom_columns_head', 10 );
function barlamane_custom_columns_content( $column, $post_id ) {
    if ($column == 'personality_status') {
        $personality_status = get_post_meta( $post_id, 'barlamane-personality-status', true );
        echo $personality_status;
    }
}
add_action( 'manage_personality_posts_custom_column', 'barlamane_custom_columns_content', 10, 2 );

// Taxonomy
function personality_taxonomy() {
	// Labels part for the GUI
	$labels = array(
		'name' => __('تصنيفات الشخصيات'),
		'singular_name' => __( 'تصنيف الشخصيات'),
		'search_items' =>  __( 'البحث عن تصنيفات الشخصيات' ),
		'all_items' => __( 'كل تصنيفات الشخصيات' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'تحرير تصنيفات الشخصيات' ), 
		'update_item' => __( 'تحديث تصنيفات الشخصيات '),
		'add_new_item' => __( 'إضافة  تصنيف الشخصيات جديد' ),
		'new_item_name' => __( 'إسم تصنيف الشخصيات جديد' ),
		'separate_items_with_commas' => __( 'المرجو فصل تصنيف الشخصيات بإستعمال الفاصلة' ),
		'add_or_remove_items' => __( 'إضافة أو حذف تصنيف الشخصيات' ),
		'menu_name' => __( 'تصنيفات الشخصيات' ),
	); 
	register_taxonomy('personality_cat','personality',array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_menu'=>true,
		'show_in_nav_menus'=>true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'personality_category' )
	));
}
add_action( 'init', 'personality_taxonomy', 0 );

