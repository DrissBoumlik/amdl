<?php
/*
	Post Type : Event
*/

// Register Post Type
add_action( 'init', 'barlamane_custom_post_type' );
function barlamane_custom_post_type() {
    $labels = array(
        'name'                  =>  'أحداث',
        'singular_name'         =>  'حدث',
        'add_new_item'          =>  'أضف حدث جديد',
        'all_items'             =>  'كل الأحداث',
        'edit_item'             =>  'تحرير الحدث',
        'new_item'              =>  'حدث جديد',
        'view_item'             =>  'معاينة الحدث',
        'not_found'             =>  'الحدث غير متوفر',
        'not_found_in_trash'    =>  'الحدث غير متوفر'
    );
 
    $supports = array(
        'title',
        'editor'
    );
 
    $args = array(
        'label'         =>   'أحداث',
        'labels'        =>   $labels,
        'description'   =>   'إدارة الأحداث',
        'public'        =>   true,
        'show_in_menu'  =>   true,
        'menu_icon'     =>   'dashicons-calendar',
        'has_archive'   =>   true,
        'rewrite'       =>   true,
        'supports'      =>   $supports
    );
 
    register_post_type( 'evenement', $args );
}

// Taxonomy
add_action( 'init', 'event_taxonomy', 0 );
function event_taxonomy() {
	// Labels part for the GUI
	$labels = array(
		'name' => __('Event Categories'),
		'singular_name' => __( 'Event Category'),
		'search_items' =>  __( 'Search Event Categories' ),
		'all_items' => __( 'All Event Categories' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit Event Category' ), 
		'update_item' => __( 'Update Event Category'),
		'add_new_item' => __( 'Add New Event Category' ),
		'new_item_name' => __( 'New Event Category Name' ),
		'separate_items_with_commas' => __( 'Separate Event Categories with commas' ),
		'add_or_remove_items' => __( 'Add or remove Event Categories' ),
		'choose_from_most_used' => __( 'Choose from the most used Event Categories' ),
		'menu_name' => __( 'Event Categories' ),
	); 
	register_taxonomy('evenement_cat','evenement',array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_in_menu'=>true,
		'show_in_nav_menus'=>true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'evenements' )
	));
}

// Custom Metabox
function barlamane_add_event_metabox() {
    add_meta_box('event-metabox', 'معلومات عن الحدث', 'render_event_metabox', 'evenement', 'side', 'core');
}
add_action( 'add_meta_boxes', 'barlamane_add_event_metabox' );

function render_event_metabox($post) {
 
    // generate a nonce field
    wp_nonce_field( basename( __FILE__ ), 'barlamane-event-info-nonce' );
	$event_city = '';

	// get previously saved meta values (if any)
	$event_start_date = get_post_meta( $post->ID, 'barlamane-event-start-date', true );
	$event_city = get_post_meta( $post->ID, 'barlamane-event-city', true );
 
 	var_dump($event_city);
    // if there is previously saved value then retrieve it, else set it to the current time
    $event_start_date = ! empty( $event_start_date ) ? $event_start_date : time();

	$morocan_cities = array(
		'الدار البيضاء' => 'الدار البيضاء',
		'الرباط' => 'الرباط',
		'فاس' => 'فاس',
		'مراكش' => 'مراكش',
		'أكادير' => 'أكادير',
		'طنجة' => 'طنجة',
		'مكناس' => 'مكناس',
		'وجدة' => 'وجدة',
		'القنيطرة' => 'القنيطرة',
		'تطوان' => 'تطوان',
		'خريبكة' => 'خريبكة',
		'تمارة' => 'تمارة',
		'المحمدية' => 'المحمدية',
		'العيون' => 'العيون',
		'آسفي' => 'آسفي',
		'بني ملال' => 'بني ملال',
		'الجديدة' => 'الجديدة',
		'تازة' => 'تازة',
		'الناظور' => 'الناظور',
		'سطات' => 'سطات',
		'القصر الكبير' => 'القصر الكبير',
		'العرائش' => 'العرائش',
		'الخميسات' => 'الخميسات',
		'تزنيت' => 'تزنيت',
		'برشيد' => 'برشيد',
		'وادي زم' => 'وادي زم',
		'الفقيه بنصالح' => 'الفقيه بنصالح',
		'تاوريرت' => 'تاوريرت',
		'بركان' => 'بركان',
		'سيدي سليمان' => 'سيدي سليمان',
		'الراشيدية' => 'الراشيدية',
		'سيدي قاسم' => 'سيدي قاسم',
		'خنيفرة' => 'خنيفرة',
		'تيفلت' => 'تيفلت',
		'الصويرة' => 'الصويرة',
		'تارودانت' => 'تارودانت',
		'قلعة السراغنة' => 'قلعة السراغنة',
		'اولاد التايمة' => 'اولاد التايمة',
		'اليوسفية' => 'اليوسفية',
		'صفرو' => 'صفرو',
		'بنجرير' => 'بنجرير',
		'طانطان' => 'طانطان',
		'وزان' => 'وزان',
		'جرسيف' => 'جرسيف',
		'ورزازات' => 'ورزازات',
		'الحسيمة' => 'الحسيمة',
		'جرادة' => 'جرادة',
		'شفشاون' => 'شفشاون',
		'الفنيدق' => 'الفنيدق',
		'سلا الجديدة' => 'سلا الجديدة',
		'تاهلة' => 'تاهلة'
	);
?>
	<p>
		<label for="barlamane-event-start-date">تاريخ بداية الحدث</label>
		<input class="widefat event-date-input" id="barlamane-event-start-date" type="text" name="barlamane-event-start-date" data-field="date" readonly value="<?php echo date( 'd-m-Y', $event_start_date ); ?>" />
	</p>
	<p>
		<label for="barlamane-event-city">المدينة</label>
		<select id="barlamane-event-city" name="barlamane-event-city"/>
			<?php
				foreach($morocan_cities as $city) {
					echo '<option value="' . $city. '" ' . selected( $event_city, $city ) .'>' . $city. '</option>';
				}
			?>
		</select>
	</p>
	<div id="dtBox"></div>
<?php
}

// To the db
function barlamane_save_event_info( $post_id ) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['barlamane-event-info-nonce'] ) && ( wp_verify_nonce( $_POST['barlamane-event-info-nonce'], basename( __FILE__ ) ) ) ) ? true : false; 

    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }
    if ( 'evenement' != $_POST['post_type'] ) {
        return;
    }
 
    // checking for the values and performing necessary actions
    if ( isset( $_POST['barlamane-event-start-date'] ) ) {
        update_post_meta( $post_id, 'barlamane-event-start-date', strtotime( $_POST['barlamane-event-start-date'] ) );
        update_post_meta( $post_id, 'barlamane-event-city', $_POST['barlamane-event-city'] );
    }
}
add_action( 'save_post', 'barlamane_save_event_info' );

// Scripts
function barlamane_event_admin_script_style( $hook ) {
    global $post_type;
    if ( ( 'post.php' == $hook || 'post-new.php' == $hook ) && ( 'evenement' == $post_type ) ) {
		wp_enqueue_style( 'datetimepicker',HYBRID_ROOT.'/css/DateTimePicker.css', array(), 'dunnow');
		wp_enqueue_script( 'datetimepicker', HYBRID_ROOT.'/js/DateTimePicker.js',array('jquery'),'', true);
        wp_enqueue_script('barlamane-events', HYBRID_ROOT . '/js/events.js',array( 'jquery'),'1.0', true);
    }
}
add_action( 'admin_enqueue_scripts', 'barlamane_event_admin_script_style' );

//Functions
function hybrid_events_list($n){
	$args = array(
		'posts_per_page'=>$n		
	);
	$args['post_type']='event';
	if (is_singular('post')) {
		$args['post__not_in']=array(get_the_ID());
	}
	// The Query
	query_posts( $args );
	echo '<ul class="event-posts unstyle-list">';
	// The Loop
	while ( have_posts() ) : the_post();
		$title=get_the_title();
		$custom = get_post_custom();
?>
		<li class="event">
        	<a href="<?php the_permalink() ?>">
				<span class="title"><i class="fa fa-flag"></i> <?php echo hybrid_cutter($title,10); ?></span>
				<span class="start-date"><?php echo date("d F Y",$custom["organ-event-start-date"][0])?></span>
			</a>
			<div class="clear"></div>
		</li>
<?php
    endwhile;
	echo '</ul><div class="clear"></div>';
	wp_reset_query();
}