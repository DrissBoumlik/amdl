<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 *
 * Class Vc_IconPicker
 * @since 4.4
 * See example usage in shortcode 'vc_icon'
 *
 *      `` example
 *        array(
 *            'type' => 'iconpicker',
 *            'heading' => __( 'Icon', 'js_composer' ),
 *            'param_name' => 'icon_fontawesome',
 *            'settings' => array(
 *                'emptyIcon' => false, // default true, display an "EMPTY"
 *     icon? - if false it will display first icon from set as default.
 *                'iconsPerPage' => 200, // default 100, how many icons
 *     per/page to display
 *            ),
 *            'dependency' => array(
 *                'element' => 'type',
 *                'value' => 'fontawesome',
 *            ),
 *        ),
 * vc_filter: vc_iconpicker-type-{your_icon_font_name} - filter to add new icon
 *     font type. see example for vc_iconpicker-type-fontawesome in bottom of
 *     this file Also // SEE HOOKS FOLDER FOR FONTS REGISTERING/ENQUEUE IN BASE
 * @path "/include/autoload/hook-vc-iconpicker-param.php"
 */
class Vc_IconPicker {
	/**
	 * @since 4.4
	 * @var array - save current param data array from vc_map
	 */
	protected $settings;
	/**
	 * @since 4.4
	 * @var string - save a current field value
	 */
	protected $value;
	/**
	 * @since 4.4
	 * @var array - optional, can be used as self source from self array., you
	 *     can pass it also with filter see Vc_IconPicker::setDefaults
	 */
	protected $source = array();

	/**
	 * @since 4.4
	 *
	 * @param $settings - param field data array
	 * @param $value - param field value
	 */
	public function __construct( $settings, $value ) {
		$this->settings = $settings;
		$this->setDefaults();

		$this->value = $value; // param field value
	}

	/**
	 * Set default function will extend current settings with defaults
	 * It can be used in Vc_IconPicker::render, but also it is passed to input
	 * field and was hooked in composer-atts.js file See vc.atts.iconpicker in
	 * wp-content/plugins/js_composer/assets/js/params/composer-atts.js init
	 * method
	 *  - it initializes javascript logic, you can provide ANY default param to
	 * it with 'settings' key
	 * @since 4.4
	 */
	protected function setDefaults() {
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['type'] ) ) {
			$this->settings['settings']['type'] = 'fontawesome'; // Default type for icons
		}

		// More about this you can read in http://codeb.it/fonticonpicker/
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['hasSearch'] ) ) {
			// Whether or not to show the search bar.
			$this->settings['settings']['hasSearch'] = true;
		}
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['emptyIcon'] ) ) {
			// Whether or not empty icon should be shown on the icon picker
			$this->settings['settings']['emptyIcon'] = true;
		}
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['allCategoryText'] ) ) {
			// If categorized then use this option
			$this->settings['settings']['allCategoryText'] = __( 'From all categories', 'js_composer' );
		}
		if ( ! isset( $this->settings['settings'], $this->settings['settings']['unCategorizedText'] ) ) {
			// If categorized then use this option
			$this->settings['settings']['unCategorizedText'] = __( 'Uncategorized', 'js_composer' );
		}

		/**
		 * Source for icons, can be passed via "mapping" or with filter vc_iconpicker-type-{your_type} (default fontawesome)
		 * vc_filter: vc_iconpicker-type-{your_type} (default fontawesome)
		 */
		if ( isset( $this->settings['settings'], $this->settings['settings']['source'] ) ) {
			$this->source = $this->settings['settings']['source'];
			unset( $this->settings['settings']['source'] ); // We don't need this on frontend.(js)
		}
	}

	/**
	 * Render edit form field type 'iconpicker' with selected settings and
	 * provided value. It uses javascript file vc-icon-picker
	 * (vc_iconpicker_base_register_js, vc_iconpicker_editor_jscss), see
	 * wp-content/plugins/js_composer/include/autoload/hook-vc-iconpicker-param.php
	 * folder
	 * @since 4.4
	 * @return string - rendered param field for editor panel
	 */
	public function render() {

		$output = '<div class="vc-iconpicker-wrapper"><select class="vc-iconpicker">';

		// call filter vc_iconpicker-type-{your_type}, e.g. vc_iconpicker-type-fontawesome with passed source from shortcode(default empty array). to get icons
		$arr = apply_filters( 'vc_iconpicker-type-' . esc_attr( $this->settings['settings']['type'] ), $this->source );
		if ( isset( $this->settings['settings'], $this->settings['settings']['emptyIcon'] ) && true === $this->settings['settings']['emptyIcon'] ) {
			array_unshift( $arr, array() );
		}
		if ( ! empty( $arr ) ) {
			foreach ( $arr as $group => $icons ) {
				if ( ! is_array( $icons ) || ! is_array( current( $icons ) ) ) {
					$class_key = key( $icons );
					$output .= '<option value="' . esc_attr( $class_key ) . '" ' . ( strcmp( $class_key, $this->value ) === 0 ? 'selected' : '' ) . '>' . esc_html( current( $icons ) ) . '</option>' . "\n";
				} else {
					$output .= '<optgroup label="' . esc_attr( $group ) . '">' . "\n";
					foreach ( $icons as $key => $label ) {
						$class_key = key( $label );
						$output .= '<option value="' . esc_attr( $class_key ) . '" ' . ( strcmp( $class_key, $this->value ) === 0 ? 'selected' : '' ) . '>' . esc_html( current( $label ) ) . '</option>' . "\n";
					}
					$output .= '</optgroup>' . "\n";
				}
			}
		}
		$output .= '</select></div>';

		$output .= '<input name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value  ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $this->value ) . '" ' . ( ( isset( $this->settings['settings'] ) && ! empty( $this->settings['settings'] ) ) ? ' data-settings="' . esc_attr( json_encode( $this->settings['settings'] ) ) . '" ' : '' ) . ' />';

		return $output;
	}
}

/**
 * Function for rendering param in edit form (add element)
 * Parse settings from vc_map and entered values.
 *
 * @param $settings
 * @param $value
 * @param $tag
 *
 * @since 4.4
 * @return string - rendered template for params in edit form
 *
 */
function vc_iconpicker_form_field( $settings, $value, $tag ) {

	$icon_picker = new Vc_IconPicker( $settings, $value );

	return apply_filters( 'vc_iconpicker_render_filter', $icon_picker->render() );
}

// SEE HOOKS FOLDER FOR FONTS REGISTERING/ENQUEUE IN BASE @path "/include/autoload/hook-vc-iconpicker-param.php"

add_filter( 'vc_iconpicker-type-fontawesome', 'vc_iconpicker_type_fontawesome' );

/**
 * Fontawesome icons from FontAwesome :)
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @since 4.4
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
function vc_iconpicker_type_fontawesome( $icons ) {
	// Categorized icons ( you can also output simple array ( key=> value ), where key = icon class, value = icon readable name ).
	/**
	 * @version 4.7
	 */
	$fontawesome_icons = array(
		'New in 4.7' => array(
			array( 'fa fa-handshake-o' => 'Handshake Outlined' ),
			array( 'fa fa-envelope-open' => 'Envelope Open(email, e-mail, letter, support, mail, message, notification)' ),
			array( 'fa fa-envelope-open-o' => 'Envelope Open Outlined(email, e-mail, letter, support, mail, message, notification)' ),
			array( 'fa fa-linode' => 'Linode' ),
			array( 'fa fa-address-book' => 'Address Book' ),
			array( 'fa fa-address-book-o' => 'Address Book Outlined' ),
			array( 'fa fa-address-card' => 'Address Card(vcard)' ),
			array( 'fa fa-address-card-o' => 'Address Card Outlined(vcard-o)' ),
			array( 'fa fa-user-circle' => 'User Circle' ),
			array( 'fa fa-user-circle-o' => 'User Circle Outlined' ),
			array( 'fa fa-user-o' => 'User Outlined' ),
			array( 'fa fa-id-badge' => 'Identification Badge' ),
			array( 'fa fa-id-card' => 'Identification Card(drivers-license)' ),
			array( 'fa fa-id-card-o' => 'Identification Card Outlined(drivers-license-o)' ),
			array( 'fa fa-quora' => 'Quora' ),
			array( 'fa fa-free-code-camp' => 'Free Code Camp' ),
			array( 'fa fa-telegram' => 'Telegram' ),
			array( 'fa fa-thermometer-full' => 'Thermometer Full(thermometer-4, thermometer)' ),
			array( 'fa fa-thermometer-three-quarters' => 'Thermometer 3/4 Full(thermometer-3)' ),
			array( 'fa fa-thermometer-half' => 'Thermometer 1/2 Full(thermometer-2)' ),
			array( 'fa fa-thermometer-quarter' => 'Thermometer 1/4 Full(thermometer-1)' ),
			array( 'fa fa-thermometer-empty' => 'Thermometer Empty(thermometer-0)' ),
			array( 'fa fa-shower' => 'Shower' ),
			array( 'fa fa-bath' => 'Bath(bathtub, s15)' ),
			array( 'fa fa-podcast' => 'Podcast' ),
			array( 'fa fa-window-maximize' => 'Window Maximize' ),
			array( 'fa fa-window-minimize' => 'Window Minimize' ),
			array( 'fa fa-window-restore' => 'Window Restore' ),
			array( 'fa fa-window-close' => 'Window Close(times-rectangle)' ),
			array( 'fa fa-window-close-o' => 'Window Close Outline(times-rectangle-o)' ),
			array( 'fa fa-bandcamp' => 'Bandcamp' ),
			array( 'fa fa-grav' => 'Grav' ),
			array( 'fa fa-etsy' => 'Etsy' ),
			array( 'fa fa-imdb' => 'IMDB' ),
			array( 'fa fa-ravelry' => 'Ravelry' ),
			array( 'fa fa-eercast' => 'Eercast' ),
			array( 'fa fa-microchip' => 'Microchip' ),
			array( 'fa fa-snowflake-o' => 'Snowflake Outlined' ),
			array( 'fa fa-superpowers' => 'Superpowers' ),
			array( 'fa fa-wpexplorer' => 'WPExplorer' ),
			array( 'fa fa-meetup' => 'Meetup' ),
		),
		'Web Application Icons' => array(
			array( 'fa fa-glass' => 'Glass(martini, drink, bar, alcohol, liquor)' ),
			array( 'fa fa-music' => 'Music(note, sound)' ),
			array( 'fa fa-search' => 'Search(magnify, zoom, enlarge, bigger)' ),
			array( 'fa fa-envelope-o' => 'Envelope Outlined(email, e-mail, letter, support, mail, message, notification)' ),
			array( 'fa fa-heart' => 'Heart(love, like, favorite)' ),
			array( 'fa fa-star' => 'Star(award, achievement, night, rating, score, favorite)' ),
			array( 'fa fa-star-o' => 'Star Outlined(award, achievement, night, rating, score, favorite)' ),
			array( 'fa fa-user' => 'User(person, man, head, profile)' ),
			array( 'fa fa-film' => 'Film(movie)' ),
			array( 'fa fa-check' => 'Check(checkmark, done, todo, agree, accept, confirm, tick, ok)' ),
			array( 'fa fa-times' => 'Times(close, exit, x, cross)(remove, close)' ),
			array( 'fa fa-search-plus' => 'Search Plus(magnify, zoom, enlarge, bigger)' ),
			array( 'fa fa-search-minus' => 'Search Minus(magnify, minify, zoom, smaller)' ),
			array( 'fa fa-power-off' => 'Power Off(on)' ),
			array( 'fa fa-signal' => 'signal(graph, bars)' ),
			array( 'fa fa-cog' => 'cog(settings)(gear)' ),
			array( 'fa fa-trash-o' => 'Trash Outlined(garbage, delete, remove, trash, hide)' ),
			array( 'fa fa-home' => 'home(main, house)' ),
			array( 'fa fa-clock-o' => 'Clock Outlined(watch, timer, late, timestamp)' ),
			array( 'fa fa-road' => 'road(street)' ),
			array( 'fa fa-download' => 'Download(import)' ),
			array( 'fa fa-inbox' => 'inbox' ),
			array( 'fa fa-refresh' => 'refresh(reload, sync)' ),
			array( 'fa fa-lock' => 'lock(protect, admin, security)' ),
			array( 'fa fa-flag' => 'flag(report, notification, notify)' ),
			array( 'fa fa-headphones' => 'headphones(sound, listen, music, audio)' ),
			array( 'fa fa-volume-off' => 'volume-off(audio, mute, sound, music)' ),
			array( 'fa fa-volume-down' => 'volume-down(audio, lower, quieter, sound, music)' ),
			array( 'fa fa-volume-up' => 'volume-up(audio, higher, louder, sound, music)' ),
			array( 'fa fa-qrcode' => 'qrcode(scan)' ),
			array( 'fa fa-barcode' => 'barcode(scan)' ),
			array( 'fa fa-tag' => 'tag(label)' ),
			array( 'fa fa-tags' => 'tags(labels)' ),
			array( 'fa fa-book' => 'book(read, documentation)' ),
			array( 'fa fa-bookmark' => 'bookmark(save)' ),
			array( 'fa fa-print' => 'print' ),
			array( 'fa fa-camera' => 'camera(photo, picture, record)' ),
			array( 'fa fa-video-camera' => 'Video Camera(film, movie, record)' ),
			array( 'fa fa-picture-o' => 'Picture Outlined(photo, image)' ),
			array( 'fa fa-pencil' => 'pencil(write, edit, update)' ),
			array( 'fa fa-map-marker' => 'map-marker(map, pin, location, coordinates, localize, address, travel, where, place)' ),
			array( 'fa fa-adjust' => 'adjust(contrast)' ),
			array( 'fa fa-tint' => 'tint(raindrop, waterdrop, drop, droplet)' ),
			array( 'fa fa-pencil-square-o' => 'Pencil Square Outlined(write, edit, update)(edit)' ),
			array( 'fa fa-share-square-o' => 'Share Square Outlined(social, send, arrow)' ),
			array( 'fa fa-check-square-o' => 'Check Square Outlined(todo, done, agree, accept, confirm, ok)' ),
			array( 'fa fa-arrows' => 'Arrows(move, reorder, resize)' ),
			array( 'fa fa-plus-circle' => 'Plus Circle(add, new, create, expand)' ),
			array( 'fa fa-minus-circle' => 'Minus Circle(delete, remove, trash, hide)' ),
			array( 'fa fa-times-circle' => 'Times Circle(close, exit, x)' ),
			array( 'fa fa-check-circle' => 'Check Circle(todo, done, agree, accept, confirm, ok)' ),
			array( 'fa fa-question-circle' => 'Question Circle(help, information, unknown, support)' ),
			array( 'fa fa-info-circle' => 'Info Circle(help, information, more, details)' ),
			array( 'fa fa-crosshairs' => 'Crosshairs(picker)' ),
			array( 'fa fa-times-circle-o' => 'Times Circle Outlined(close, exit, x)' ),
			array( 'fa fa-check-circle-o' => 'Check Circle Outlined(todo, done, agree, accept, confirm, ok)' ),
			array( 'fa fa-ban' => 'ban(delete, remove, trash, hide, block, stop, abort, cancel)' ),
			array( 'fa fa-share' => 'Share(mail-forward)' ),
			array( 'fa fa-plus' => 'plus(add, new, create, expand)' ),
			array( 'fa fa-minus' => 'minus(hide, minify, delete, remove, trash, hide, collapse)' ),
			array( 'fa fa-asterisk' => 'asterisk(details)' ),
			array( 'fa fa-exclamation-circle' => 'Exclamation Circle(warning, error, problem, notification, alert)' ),
			array( 'fa fa-gift' => 'gift(present)' ),
			array( 'fa fa-leaf' => 'leaf(eco, nature, plant)' ),
			array( 'fa fa-fire' => 'fire(flame, hot, popular)' ),
			array( 'fa fa-eye' => 'Eye(show, visible, views)' ),
			array( 'fa fa-eye-slash' => 'Eye Slash(toggle, show, hide, visible, visiblity, views)' ),
			array( 'fa fa-exclamation-triangle' => 'Exclamation Triangle(warning, error, problem, notification, alert)(warning)' ),
			array( 'fa fa-plane' => 'plane(travel, trip, location, destination, airplane, fly, mode)' ),
			array( 'fa fa-calendar' => 'calendar(date, time, when, event)' ),
			array( 'fa fa-random' => 'random(sort, shuffle)' ),
			array( 'fa fa-comment' => 'comment(speech, notification, note, chat, bubble, feedback, message, texting, sms, conversation)' ),
			array( 'fa fa-magnet' => 'magnet' ),
			array( 'fa fa-retweet' => 'retweet(refresh, reload, share)' ),
			array( 'fa fa-shopping-cart' => 'shopping-cart(checkout, buy, purchase, payment)' ),
			array( 'fa fa-folder' => 'Folder' ),
			array( 'fa fa-folder-open' => 'Folder Open' ),
			array( 'fa fa-arrows-v' => 'Arrows Vertical(resize)' ),
			array( 'fa fa-arrows-h' => 'Arrows Horizontal(resize)' ),
			array( 'fa fa-bar-chart' => 'Bar Chart(graph, analytics, statistics)(bar-chart-o)' ),
			array( 'fa fa-camera-retro' => 'camera-retro(photo, picture, record)' ),
			array( 'fa fa-key' => 'key(unlock, password)' ),
			array( 'fa fa-cogs' => 'cogs(settings)(gears)' ),
			array( 'fa fa-comments' => 'comments(speech, notification, note, chat, bubble, feedback, message, texting, sms, conversation)' ),
			array( 'fa fa-thumbs-o-up' => 'Thumbs Up Outlined(like, approve, favorite, agree, hand)' ),
			array( 'fa fa-thumbs-o-down' => 'Thumbs Down Outlined(dislike, disapprove, disagree, hand)' ),
			array( 'fa fa-star-half' => 'star-half(award, achievement, rating, score)' ),
			array( 'fa fa-heart-o' => 'Heart Outlined(love, like, favorite)' ),
			array( 'fa fa-sign-out' => 'Sign Out(log out, logout, leave, exit, arrow)' ),
			array( 'fa fa-thumb-tack' => 'Thumb Tack(marker, pin, location, coordinates)' ),
			array( 'fa fa-external-link' => 'External Link(open, new)' ),
			array( 'fa fa-sign-in' => 'Sign In(enter, join, log in, login, sign up, sign in, signin, signup, arrow)' ),
			array( 'fa fa-trophy' => 'trophy(award, achievement, cup, winner, game)' ),
			array( 'fa fa-upload' => 'Upload(import)' ),
			array( 'fa fa-lemon-o' => 'Lemon Outlined(food)' ),
			array( 'fa fa-phone' => 'Phone(call, voice, number, support, earphone, telephone)' ),
			array( 'fa fa-square-o' => 'Square Outlined(block, square, box)' ),
			array( 'fa fa-bookmark-o' => 'Bookmark Outlined(save)' ),
			array( 'fa fa-phone-square' => 'Phone Square(call, voice, number, support, telephone)' ),
			array( 'fa fa-unlock' => 'unlock(protect, admin, password, lock)' ),
			array( 'fa fa-credit-card' => 'credit-card(money, buy, debit, checkout, purchase, payment)' ),
			array( 'fa fa-rss' => 'rss(blog)(feed)' ),
			array( 'fa fa-hdd-o' => 'HDD(harddrive, hard drive, storage, save)' ),
			array( 'fa fa-bullhorn' => 'bullhorn(announcement, share, broadcast, louder, megaphone)' ),
			array( 'fa fa-bell' => 'bell(alert, reminder, notification)' ),
			array( 'fa fa-certificate' => 'certificate(badge, star)' ),
			array( 'fa fa-globe' => 'Globe(world, planet, map, place, travel, earth, global, translate, all, language, localize, location, coordinates, country)' ),
			array( 'fa fa-wrench' => 'Wrench(settings, fix, update, spanner)' ),
			array( 'fa fa-tasks' => 'Tasks(progress, loading, downloading, downloads, settings)' ),
			array( 'fa fa-filter' => 'Filter(funnel, options)' ),
			array( 'fa fa-briefcase' => 'Briefcase(work, business, office, luggage, bag)' ),
			array( 'fa fa-users' => 'Users(people, profiles, persons)(group)' ),
			array( 'fa fa-cloud' => 'Cloud(save)' ),
			array( 'fa fa-flask' => 'Flask(science, beaker, experimental, labs)' ),
			array( 'fa fa-square' => 'Square(block, box)' ),
			array( 'fa fa-bars' => 'Bars(menu, drag, reorder, settings, list, ul, ol, checklist, todo, list, hamburger)(navicon, reorder)' ),
			array( 'fa fa-magic' => 'magic(wizard, automatic, autocomplete)' ),
			array( 'fa fa-truck' => 'truck(shipping)' ),
			array( 'fa fa-money' => 'Money(cash, money, buy, checkout, purchase, payment)' ),
			array( 'fa fa-sort' => 'Sort(order)(unsorted)' ),
			array( 'fa fa-sort-desc' => 'Sort Descending(dropdown, more, menu, arrow)(sort-down)' ),
			array( 'fa fa-sort-asc' => 'Sort Ascending(arrow)(sort-up)' ),
			array( 'fa fa-envelope' => 'Envelope(email, e-mail, letter, support, mail, message, notification)' ),
			array( 'fa fa-gavel' => 'Gavel(judge, lawyer, opinion)(legal)' ),
			array( 'fa fa-tachometer' => 'Tachometer(speedometer, fast)(dashboard)' ),
			array( 'fa fa-comment-o' => 'comment-o(speech, notification, note, chat, bubble, feedback, message, texting, sms, conversation)' ),
			array( 'fa fa-comments-o' => 'comments-o(speech, notification, note, chat, bubble, feedback, message, texting, sms, conversation)' ),
			array( 'fa fa-bolt' => 'Lightning Bolt(lightning, weather)(flash)' ),
			array( 'fa fa-sitemap' => 'Sitemap(directory, hierarchy, organization)' ),
			array( 'fa fa-umbrella' => 'Umbrella' ),
			array( 'fa fa-lightbulb-o' => 'Lightbulb Outlined(idea, inspiration)' ),
			array( 'fa fa-exchange' => 'Exchange(transfer, arrows, arrow)' ),
			array( 'fa fa-cloud-download' => 'Cloud Download(import)' ),
			array( 'fa fa-cloud-upload' => 'Cloud Upload(import)' ),
			array( 'fa fa-suitcase' => 'Suitcase(trip, luggage, travel, move, baggage)' ),
			array( 'fa fa-bell-o' => 'Bell Outlined(alert, reminder, notification)' ),
			array( 'fa fa-coffee' => 'Coffee(morning, mug, breakfast, tea, drink, cafe)' ),
			array( 'fa fa-cutlery' => 'Cutlery(food, restaurant, spoon, knife, dinner, eat)' ),
			array( 'fa fa-building-o' => 'Building Outlined(work, business, apartment, office, company)' ),
			array( 'fa fa-fighter-jet' => 'fighter-jet(fly, plane, airplane, quick, fast, travel)' ),
			array( 'fa fa-beer' => 'beer(alcohol, stein, drink, mug, bar, liquor)' ),
			array( 'fa fa-plus-square' => 'Plus Square(add, new, create, expand)' ),
			array( 'fa fa-desktop' => 'Desktop(monitor, screen, desktop, computer, demo, device)' ),
			array( 'fa fa-laptop' => 'Laptop(demo, computer, device)' ),
			array( 'fa fa-tablet' => 'tablet(ipad, device)' ),
			array( 'fa fa-mobile' => 'Mobile Phone(cell phone, cellphone, text, call, iphone, number, telephone)(mobile-phone)' ),
			array( 'fa fa-circle-o' => 'Circle Outlined' ),
			array( 'fa fa-quote-left' => 'quote-left' ),
			array( 'fa fa-quote-right' => 'quote-right' ),
			array( 'fa fa-spinner' => 'Spinner(loading, progress)' ),
			array( 'fa fa-circle' => 'Circle(dot, notification)' ),
			array( 'fa fa-reply' => 'Reply(mail-reply)' ),
			array( 'fa fa-folder-o' => 'Folder Outlined' ),
			array( 'fa fa-folder-open-o' => 'Folder Open Outlined' ),
			array( 'fa fa-smile-o' => 'Smile Outlined(face, emoticon, happy, approve, satisfied, rating)' ),
			array( 'fa fa-frown-o' => 'Frown Outlined(face, emoticon, sad, disapprove, rating)' ),
			array( 'fa fa-meh-o' => 'Meh Outlined(face, emoticon, rating, neutral)' ),
			array( 'fa fa-gamepad' => 'Gamepad(controller)' ),
			array( 'fa fa-keyboard-o' => 'Keyboard Outlined(type, input)' ),
			array( 'fa fa-flag-o' => 'Flag Outlined(report, notification)' ),
			array( 'fa fa-flag-checkered' => 'flag-checkered(report, notification, notify)' ),
			array( 'fa fa-terminal' => 'Terminal(command, prompt, code)' ),
			array( 'fa fa-code' => 'Code(html, brackets)' ),
			array( 'fa fa-reply-all' => 'reply-all(mail-reply-all)' ),
			array( 'fa fa-star-half-o' => 'Star Half Outlined(award, achievement, rating, score)(star-half-empty, star-half-full)' ),
			array( 'fa fa-location-arrow' => 'location-arrow(map, coordinates, location, address, place, where)' ),
			array( 'fa fa-crop' => 'crop' ),
			array( 'fa fa-code-fork' => 'code-fork(git, fork, vcs, svn, github, rebase, version, merge)' ),
			array( 'fa fa-question' => 'Question(help, information, unknown, support)' ),
			array( 'fa fa-info' => 'Info(help, information, more, details)' ),
			array( 'fa fa-exclamation' => 'exclamation(warning, error, problem, notification, notify, alert)' ),
			array( 'fa fa-eraser' => 'eraser(remove, delete)' ),
			array( 'fa fa-puzzle-piece' => 'Puzzle Piece(addon, add-on, section)' ),
			array( 'fa fa-microphone' => 'microphone(record, voice, sound)' ),
			array( 'fa fa-microphone-slash' => 'Microphone Slash(record, voice, sound, mute)' ),
			array( 'fa fa-shield' => 'shield(award, achievement, security, winner)' ),
			array( 'fa fa-calendar-o' => 'calendar-o(date, time, when, event)' ),
			array( 'fa fa-fire-extinguisher' => 'fire-extinguisher' ),
			array( 'fa fa-rocket' => 'rocket(app)' ),
			array( 'fa fa-anchor' => 'Anchor(link)' ),
			array( 'fa fa-unlock-alt' => 'Unlock Alt(protect, admin, password, lock)' ),
			array( 'fa fa-bullseye' => 'Bullseye(target)' ),
			array( 'fa fa-ellipsis-h' => 'Ellipsis Horizontal(dots)' ),
			array( 'fa fa-ellipsis-v' => 'Ellipsis Vertical(dots)' ),
			array( 'fa fa-rss-square' => 'RSS Square(feed, blog)' ),
			array( 'fa fa-ticket' => 'Ticket(movie, pass, support)' ),
			array( 'fa fa-minus-square' => 'Minus Square(hide, minify, delete, remove, trash, hide, collapse)' ),
			array( 'fa fa-minus-square-o' => 'Minus Square Outlined(hide, minify, delete, remove, trash, hide, collapse)' ),
			array( 'fa fa-level-up' => 'Level Up(arrow)' ),
			array( 'fa fa-level-down' => 'Level Down(arrow)' ),
			array( 'fa fa-check-square' => 'Check Square(checkmark, done, todo, agree, accept, confirm, ok)' ),
			array( 'fa fa-pencil-square' => 'Pencil Square(write, edit, update)' ),
			array( 'fa fa-external-link-square' => 'External Link Square(open, new)' ),
			array( 'fa fa-share-square' => 'Share Square(social, send)' ),
			array( 'fa fa-compass' => 'Compass(safari, directory, menu, location)' ),
			array( 'fa fa-caret-square-o-down' => 'Caret Square Outlined Down(more, dropdown, menu)(toggle-down)' ),
			array( 'fa fa-caret-square-o-up' => 'Caret Square Outlined Up(toggle-up)' ),
			array( 'fa fa-caret-square-o-right' => 'Caret Square Outlined Right(next, forward)(toggle-right)' ),
			array( 'fa fa-sort-alpha-asc' => 'Sort Alpha Ascending' ),
			array( 'fa fa-sort-alpha-desc' => 'Sort Alpha Descending' ),
			array( 'fa fa-sort-amount-asc' => 'Sort Amount Ascending' ),
			array( 'fa fa-sort-amount-desc' => 'Sort Amount Descending' ),
			array( 'fa fa-sort-numeric-asc' => 'Sort Numeric Ascending(numbers)' ),
			array( 'fa fa-sort-numeric-desc' => 'Sort Numeric Descending(numbers)' ),
			array( 'fa fa-thumbs-up' => 'thumbs-up(like, favorite, approve, agree, hand)' ),
			array( 'fa fa-thumbs-down' => 'thumbs-down(dislike, disapprove, disagree, hand)' ),
			array( 'fa fa-female' => 'Female(woman, user, person, profile)' ),
			array( 'fa fa-male' => 'Male(man, user, person, profile)' ),
			array( 'fa fa-sun-o' => 'Sun Outlined(weather, contrast, lighter, brighten, day)' ),
			array( 'fa fa-moon-o' => 'Moon Outlined(night, darker, contrast)' ),
			array( 'fa fa-archive' => 'Archive(box, storage)' ),
			array( 'fa fa-bug' => 'Bug(report, insect)' ),
			array( 'fa fa-caret-square-o-left' => 'Caret Square Outlined Left(previous, back)(toggle-left)' ),
			array( 'fa fa-dot-circle-o' => 'Dot Circle Outlined(target, bullseye, notification)' ),
			array( 'fa fa-wheelchair' => 'Wheelchair(handicap, person)' ),
			array( 'fa fa-plus-square-o' => 'Plus Square Outlined(add, new, create, expand)' ),
			array( 'fa fa-space-shuttle' => 'Space Shuttle' ),
			array( 'fa fa-envelope-square' => 'Envelope Square(email, e-mail, letter, support, mail, message, notification)' ),
			array( 'fa fa-university' => 'University(institution, bank)' ),
			array( 'fa fa-graduation-cap' => 'Graduation Cap(learning, school, student)(mortar-board)' ),
			array( 'fa fa-language' => 'Language(translate)' ),
			array( 'fa fa-fax' => 'Fax' ),
			array( 'fa fa-building' => 'Building(work, business, apartment, office, company)' ),
			array( 'fa fa-child' => 'Child' ),
			array( 'fa fa-paw' => 'Paw(pet)' ),
			array( 'fa fa-spoon' => 'spoon' ),
			array( 'fa fa-cube' => 'Cube' ),
			array( 'fa fa-cubes' => 'Cubes' ),
			array( 'fa fa-recycle' => 'Recycle' ),
			array( 'fa fa-car' => 'Car(vehicle)(automobile)' ),
			array( 'fa fa-taxi' => 'Taxi(vehicle)(cab)' ),
			array( 'fa fa-tree' => 'Tree' ),
			array( 'fa fa-database' => 'Database' ),
			array( 'fa fa-file-pdf-o' => 'PDF File Outlined' ),
			array( 'fa fa-file-word-o' => 'Word File Outlined' ),
			array( 'fa fa-file-excel-o' => 'Excel File Outlined' ),
			array( 'fa fa-file-powerpoint-o' => 'Powerpoint File Outlined' ),
			array( 'fa fa-file-image-o' => 'Image File Outlined(file-photo-o, file-picture-o)' ),
			array( 'fa fa-file-archive-o' => 'Archive File Outlined(file-zip-o)' ),
			array( 'fa fa-file-audio-o' => 'Audio File Outlined(file-sound-o)' ),
			array( 'fa fa-file-video-o' => 'Video File Outlined(file-movie-o)' ),
			array( 'fa fa-file-code-o' => 'Code File Outlined' ),
			array( 'fa fa-life-ring' => 'Life Ring(life-bouy, life-buoy, life-saver, support)' ),
			array( 'fa fa-circle-o-notch' => 'Circle Outlined Notched' ),
			array( 'fa fa-paper-plane' => 'Paper Plane(send)' ),
			array( 'fa fa-paper-plane-o' => 'Paper Plane Outlined(send-o)' ),
			array( 'fa fa-history' => 'History' ),
			array( 'fa fa-circle-thin' => 'Circle Outlined Thin' ),
			array( 'fa fa-sliders' => 'Sliders(settings)' ),
			array( 'fa fa-share-alt' => 'Share Alt' ),
			array( 'fa fa-share-alt-square' => 'Share Alt Square' ),
			array( 'fa fa-bomb' => 'Bomb' ),
			array( 'fa fa-futbol-o' => 'Futbol Outlined(soccer-ball-o)' ),
			array( 'fa fa-tty' => 'TTY' ),
			array( 'fa fa-binoculars' => 'Binoculars' ),
			array( 'fa fa-plug' => 'Plug(power, connect)' ),
			array( 'fa fa-newspaper-o' => 'Newspaper Outlined(press)' ),
			array( 'fa fa-wifi' => 'WiFi' ),
			array( 'fa fa-calculator' => 'Calculator' ),
			array( 'fa fa-bell-slash' => 'Bell Slash' ),
			array( 'fa fa-bell-slash-o' => 'Bell Slash Outlined' ),
			array( 'fa fa-trash' => 'Trash(garbage, delete, remove, hide)' ),
			array( 'fa fa-copyright' => 'Copyright' ),
			array( 'fa fa-at' => 'At(email, e-mail)' ),
			array( 'fa fa-eyedropper' => 'Eyedropper' ),
			array( 'fa fa-paint-brush' => 'Paint Brush' ),
			array( 'fa fa-birthday-cake' => 'Birthday Cake' ),
			array( 'fa fa-area-chart' => 'Area Chart(graph, analytics, statistics)' ),
			array( 'fa fa-pie-chart' => 'Pie Chart(graph, analytics, statistics)' ),
			array( 'fa fa-line-chart' => 'Line Chart(graph, analytics, statistics)' ),
			array( 'fa fa-toggle-off' => 'Toggle Off' ),
			array( 'fa fa-toggle-on' => 'Toggle On' ),
			array( 'fa fa-bicycle' => 'Bicycle(vehicle, bike)' ),
			array( 'fa fa-bus' => 'Bus(vehicle)' ),
			array( 'fa fa-cc' => 'Closed Captions' ),
			array( 'fa fa-cart-plus' => 'Add to Shopping Cart(add, shopping)' ),
			array( 'fa fa-cart-arrow-down' => 'Shopping Cart Arrow Down(shopping)' ),
			array( 'fa fa-diamond' => 'Diamond(gem, gemstone)' ),
			array( 'fa fa-ship' => 'Ship(boat, sea)' ),
			array( 'fa fa-user-secret' => 'User Secret(whisper, spy, incognito, privacy)' ),
			array( 'fa fa-motorcycle' => 'Motorcycle(vehicle, bike)' ),
			array( 'fa fa-street-view' => 'Street View(map)' ),
			array( 'fa fa-heartbeat' => 'Heartbeat(ekg)' ),
			array( 'fa fa-server' => 'Server' ),
			array( 'fa fa-user-plus' => 'Add User(sign up, signup)' ),
			array( 'fa fa-user-times' => 'Remove User' ),
			array( 'fa fa-bed' => 'Bed(travel)(hotel)' ),
			array( 'fa fa-battery-full' => 'Battery Full(power)(battery-4, battery)' ),
			array( 'fa fa-battery-three-quarters' => 'Battery 3/4 Full(power)(battery-3)' ),
			array( 'fa fa-battery-half' => 'Battery 1/2 Full(power)(battery-2)' ),
			array( 'fa fa-battery-quarter' => 'Battery 1/4 Full(power)(battery-1)' ),
			array( 'fa fa-battery-empty' => 'Battery Empty(power)(battery-0)' ),
			array( 'fa fa-mouse-pointer' => 'Mouse Pointer' ),
			array( 'fa fa-i-cursor' => 'I Beam Cursor' ),
			array( 'fa fa-object-group' => 'Object Group' ),
			array( 'fa fa-object-ungroup' => 'Object Ungroup' ),
			array( 'fa fa-sticky-note' => 'Sticky Note' ),
			array( 'fa fa-sticky-note-o' => 'Sticky Note Outlined' ),
			array( 'fa fa-clone' => 'Clone(copy)' ),
			array( 'fa fa-balance-scale' => 'Balance Scale' ),
			array( 'fa fa-hourglass-o' => 'Hourglass Outlined' ),
			array( 'fa fa-hourglass-start' => 'Hourglass Start(hourglass-1)' ),
			array( 'fa fa-hourglass-half' => 'Hourglass Half(hourglass-2)' ),
			array( 'fa fa-hourglass-end' => 'Hourglass End(hourglass-3)' ),
			array( 'fa fa-hourglass' => 'Hourglass' ),
			array( 'fa fa-hand-rock-o' => 'Rock (Hand)(hand-grab-o)' ),
			array( 'fa fa-hand-paper-o' => 'Paper (Hand)(stop)(hand-stop-o)' ),
			array( 'fa fa-hand-scissors-o' => 'Scissors (Hand)' ),
			array( 'fa fa-hand-lizard-o' => 'Lizard (Hand)' ),
			array( 'fa fa-hand-spock-o' => 'Spock (Hand)' ),
			array( 'fa fa-hand-pointer-o' => 'Hand Pointer' ),
			array( 'fa fa-hand-peace-o' => 'Hand Peace' ),
			array( 'fa fa-trademark' => 'Trademark' ),
			array( 'fa fa-registered' => 'Registered Trademark' ),
			array( 'fa fa-creative-commons' => 'Creative Commons' ),
			array( 'fa fa-television' => 'Television(display, computer, monitor)(tv)' ),
			array( 'fa fa-calendar-plus-o' => 'Calendar Plus Outlined' ),
			array( 'fa fa-calendar-minus-o' => 'Calendar Minus Outlined' ),
			array( 'fa fa-calendar-times-o' => 'Calendar Times Outlined' ),
			array( 'fa fa-calendar-check-o' => 'Calendar Check Outlined(ok)' ),
			array( 'fa fa-industry' => 'Industry(factory)' ),
			array( 'fa fa-map-pin' => 'Map Pin' ),
			array( 'fa fa-map-signs' => 'Map Signs' ),
			array( 'fa fa-map-o' => 'Map Outlined' ),
			array( 'fa fa-map' => 'Map' ),
			array( 'fa fa-commenting' => 'Commenting(speech, notification, note, chat, bubble, feedback, message, texting, sms, conversation)' ),
			array( 'fa fa-commenting-o' => 'Commenting Outlined(speech, notification, note, chat, bubble, feedback, message, texting, sms, conversation)' ),
			array( 'fa fa-credit-card-alt' => 'Credit Card(money, buy, debit, checkout, purchase, payment, credit card)' ),
			array( 'fa fa-shopping-bag' => 'Shopping Bag' ),
			array( 'fa fa-shopping-basket' => 'Shopping Basket' ),
			array( 'fa fa-hashtag' => 'Hashtag' ),
			array( 'fa fa-bluetooth' => 'Bluetooth' ),
			array( 'fa fa-bluetooth-b' => 'Bluetooth' ),
			array( 'fa fa-percent' => 'Percent' ),
			array( 'fa fa-universal-access' => 'Universal Access' ),
			array( 'fa fa-wheelchair-alt' => 'Wheelchair Alt(handicap, person)' ),
			array( 'fa fa-question-circle-o' => 'Question Circle Outlined' ),
			array( 'fa fa-blind' => 'Blind' ),
			array( 'fa fa-audio-description' => 'Audio Description' ),
			array( 'fa fa-volume-control-phone' => 'Volume Control Phone(telephone)' ),
			array( 'fa fa-braille' => 'Braille' ),
			array( 'fa fa-assistive-listening-systems' => 'Assistive Listening Systems' ),
			array( 'fa fa-american-sign-language-interpreting' => 'American Sign Language Interpreting(asl-interpreting)' ),
			array( 'fa fa-deaf' => 'Deaf(deafness, hard-of-hearing)' ),
			array( 'fa fa-sign-language' => 'Sign Language(signing)' ),
			array( 'fa fa-low-vision' => 'Low Vision' ),
			array( 'fa fa-handshake-o' => 'Handshake Outlined' ),
			array( 'fa fa-envelope-open' => 'Envelope Open(email, e-mail, letter, support, mail, message, notification)' ),
			array( 'fa fa-envelope-open-o' => 'Envelope Open Outlined(email, e-mail, letter, support, mail, message, notification)' ),
			array( 'fa fa-address-book' => 'Address Book' ),
			array( 'fa fa-address-book-o' => 'Address Book Outlined' ),
			array( 'fa fa-address-card' => 'Address Card(vcard)' ),
			array( 'fa fa-address-card-o' => 'Address Card Outlined(vcard-o)' ),
			array( 'fa fa-user-circle' => 'User Circle' ),
			array( 'fa fa-user-circle-o' => 'User Circle Outlined' ),
			array( 'fa fa-user-o' => 'User Outlined' ),
			array( 'fa fa-id-badge' => 'Identification Badge' ),
			array( 'fa fa-id-card' => 'Identification Card(drivers-license)' ),
			array( 'fa fa-id-card-o' => 'Identification Card Outlined(drivers-license-o)' ),
			array( 'fa fa-thermometer-full' => 'Thermometer Full(thermometer-4, thermometer)' ),
			array( 'fa fa-thermometer-three-quarters' => 'Thermometer 3/4 Full(thermometer-3)' ),
			array( 'fa fa-thermometer-half' => 'Thermometer 1/2 Full(thermometer-2)' ),
			array( 'fa fa-thermometer-quarter' => 'Thermometer 1/4 Full(thermometer-1)' ),
			array( 'fa fa-thermometer-empty' => 'Thermometer Empty(thermometer-0)' ),
			array( 'fa fa-shower' => 'Shower' ),
			array( 'fa fa-bath' => 'Bath(bathtub, s15)' ),
			array( 'fa fa-podcast' => 'Podcast' ),
			array( 'fa fa-window-maximize' => 'Window Maximize' ),
			array( 'fa fa-window-minimize' => 'Window Minimize' ),
			array( 'fa fa-window-restore' => 'Window Restore' ),
			array( 'fa fa-window-close' => 'Window Close(times-rectangle)' ),
			array( 'fa fa-window-close-o' => 'Window Close Outline(times-rectangle-o)' ),
			array( 'fa fa-microchip' => 'Microchip' ),
			array( 'fa fa-snowflake-o' => 'Snowflake Outlined' ),
		),
		'Medical Icons' => array(
			array( 'fa fa-heart' => 'Heart(love, like, favorite)' ),
			array( 'fa fa-heart-o' => 'Heart Outlined(love, like, favorite)' ),
			array( 'fa fa-user-md' => 'user-md(doctor, profile, medical, nurse)' ),
			array( 'fa fa-stethoscope' => 'Stethoscope' ),
			array( 'fa fa-hospital-o' => 'hospital Outlined(building)' ),
			array( 'fa fa-ambulance' => 'ambulance(vehicle, support, help)' ),
			array( 'fa fa-medkit' => 'medkit(first aid, firstaid, help, support, health)' ),
			array( 'fa fa-h-square' => 'H Square(hospital, hotel)' ),
			array( 'fa fa-plus-square' => 'Plus Square(add, new, create, expand)' ),
			array( 'fa fa-wheelchair' => 'Wheelchair(handicap, person)' ),
			array( 'fa fa-heartbeat' => 'Heartbeat(ekg)' ),
			array( 'fa fa-wheelchair-alt' => 'Wheelchair Alt(handicap, person)' ),
		),
		'Text Editor Icons' => array(
			array( 'fa fa-th-large' => 'th-large(blocks, squares, boxes, grid)' ),
			array( 'fa fa-th' => 'th(blocks, squares, boxes, grid)' ),
			array( 'fa fa-th-list' => 'th-list(ul, ol, checklist, finished, completed, done, todo)' ),
			array( 'fa fa-file-o' => 'File Outlined(new, page, pdf, document)' ),
			array( 'fa fa-repeat' => 'Repeat(redo, forward)(rotate-right)' ),
			array( 'fa fa-list-alt' => 'list-alt(ul, ol, checklist, finished, completed, done, todo)' ),
			array( 'fa fa-font' => 'font(text)' ),
			array( 'fa fa-bold' => 'bold' ),
			array( 'fa fa-italic' => 'italic(italics)' ),
			array( 'fa fa-text-height' => 'text-height' ),
			array( 'fa fa-text-width' => 'text-width' ),
			array( 'fa fa-align-left' => 'align-left(text)' ),
			array( 'fa fa-align-center' => 'align-center(middle, text)' ),
			array( 'fa fa-align-right' => 'align-right(text)' ),
			array( 'fa fa-align-justify' => 'align-justify(text)' ),
			array( 'fa fa-list' => 'list(ul, ol, checklist, finished, completed, done, todo)' ),
			array( 'fa fa-outdent' => 'Outdent(dedent)' ),
			array( 'fa fa-indent' => 'Indent' ),
			array( 'fa fa-link' => 'Link(chain)(chain)' ),
			array( 'fa fa-scissors' => 'Scissors(cut)' ),
			array( 'fa fa-files-o' => 'Files Outlined(duplicate, clone, copy)(copy)' ),
			array( 'fa fa-paperclip' => 'Paperclip(attachment)' ),
			array( 'fa fa-floppy-o' => 'Floppy Outlined(save)' ),
			array( 'fa fa-list-ul' => 'list-ul(ul, ol, checklist, todo, list)' ),
			array( 'fa fa-list-ol' => 'list-ol(ul, ol, checklist, list, todo, list, numbers)' ),
			array( 'fa fa-strikethrough' => 'Strikethrough' ),
			array( 'fa fa-underline' => 'Underline' ),
			array( 'fa fa-table' => 'table(data, excel, spreadsheet)' ),
			array( 'fa fa-columns' => 'Columns(split, panes)' ),
			array( 'fa fa-undo' => 'Undo(back)(rotate-left)' ),
			array( 'fa fa-clipboard' => 'Clipboard(copy)(paste)' ),
			array( 'fa fa-file-text-o' => 'File Text Outlined(new, page, pdf, document)' ),
			array( 'fa fa-chain-broken' => 'Chain Broken(remove)(unlink)' ),
			array( 'fa fa-superscript' => 'superscript(exponential)' ),
			array( 'fa fa-subscript' => 'subscript' ),
			array( 'fa fa-eraser' => 'eraser(remove, delete)' ),
			array( 'fa fa-file' => 'File(new, page, pdf, document)' ),
			array( 'fa fa-file-text' => 'File Text(new, page, pdf, document)' ),
			array( 'fa fa-header' => 'header(heading)' ),
			array( 'fa fa-paragraph' => 'paragraph' ),
		),
		'Spinner Icons' => array(
			array( 'fa fa-cog' => 'cog(settings)(gear)' ),
			array( 'fa fa-refresh' => 'refresh(reload, sync)' ),
			array( 'fa fa-spinner' => 'Spinner(loading, progress)' ),
			array( 'fa fa-circle-o-notch' => 'Circle Outlined Notched' ),
		),
		'File Type Icons' => array(
			array( 'fa fa-file-o' => 'File Outlined(new, page, pdf, document)' ),
			array( 'fa fa-file-text-o' => 'File Text Outlined(new, page, pdf, document)' ),
			array( 'fa fa-file' => 'File(new, page, pdf, document)' ),
			array( 'fa fa-file-text' => 'File Text(new, page, pdf, document)' ),
			array( 'fa fa-file-pdf-o' => 'PDF File Outlined' ),
			array( 'fa fa-file-word-o' => 'Word File Outlined' ),
			array( 'fa fa-file-excel-o' => 'Excel File Outlined' ),
			array( 'fa fa-file-powerpoint-o' => 'Powerpoint File Outlined' ),
			array( 'fa fa-file-image-o' => 'Image File Outlined(file-photo-o, file-picture-o)' ),
			array( 'fa fa-file-archive-o' => 'Archive File Outlined(file-zip-o)' ),
			array( 'fa fa-file-audio-o' => 'Audio File Outlined(file-sound-o)' ),
			array( 'fa fa-file-video-o' => 'Video File Outlined(file-movie-o)' ),
			array( 'fa fa-file-code-o' => 'Code File Outlined' ),
		),
		'Directional Icons' => array(
			array( 'fa fa-arrow-circle-o-down' => 'Arrow Circle Outlined Down(download)' ),
			array( 'fa fa-arrow-circle-o-up' => 'Arrow Circle Outlined Up' ),
			array( 'fa fa-arrows' => 'Arrows(move, reorder, resize)' ),
			array( 'fa fa-chevron-left' => 'chevron-left(bracket, previous, back)' ),
			array( 'fa fa-chevron-right' => 'chevron-right(bracket, next, forward)' ),
			array( 'fa fa-arrow-left' => 'arrow-left(previous, back)' ),
			array( 'fa fa-arrow-right' => 'arrow-right(next, forward)' ),
			array( 'fa fa-arrow-up' => 'arrow-up' ),
			array( 'fa fa-arrow-down' => 'arrow-down(download)' ),
			array( 'fa fa-chevron-up' => 'chevron-up' ),
			array( 'fa fa-chevron-down' => 'chevron-down' ),
			array( 'fa fa-arrows-v' => 'Arrows Vertical(resize)' ),
			array( 'fa fa-arrows-h' => 'Arrows Horizontal(resize)' ),
			array( 'fa fa-hand-o-right' => 'Hand Outlined Right(point, right, next, forward, finger)' ),
			array( 'fa fa-hand-o-left' => 'Hand Outlined Left(point, left, previous, back, finger)' ),
			array( 'fa fa-hand-o-up' => 'Hand Outlined Up(point, finger)' ),
			array( 'fa fa-hand-o-down' => 'Hand Outlined Down(point, finger)' ),
			array( 'fa fa-arrow-circle-left' => 'Arrow Circle Left(previous, back)' ),
			array( 'fa fa-arrow-circle-right' => 'Arrow Circle Right(next, forward)' ),
			array( 'fa fa-arrow-circle-up' => 'Arrow Circle Up' ),
			array( 'fa fa-arrow-circle-down' => 'Arrow Circle Down(download)' ),
			array( 'fa fa-arrows-alt' => 'Arrows Alt(expand, enlarge, fullscreen, bigger, move, reorder, resize, arrow)' ),
			array( 'fa fa-caret-down' => 'Caret Down(more, dropdown, menu, triangle down, arrow)' ),
			array( 'fa fa-caret-up' => 'Caret Up(triangle up, arrow)' ),
			array( 'fa fa-caret-left' => 'Caret Left(previous, back, triangle left, arrow)' ),
			array( 'fa fa-caret-right' => 'Caret Right(next, forward, triangle right, arrow)' ),
			array( 'fa fa-exchange' => 'Exchange(transfer, arrows, arrow)' ),
			array( 'fa fa-angle-double-left' => 'Angle Double Left(laquo, quote, previous, back, arrows)' ),
			array( 'fa fa-angle-double-right' => 'Angle Double Right(raquo, quote, next, forward, arrows)' ),
			array( 'fa fa-angle-double-up' => 'Angle Double Up(arrows)' ),
			array( 'fa fa-angle-double-down' => 'Angle Double Down(arrows)' ),
			array( 'fa fa-angle-left' => 'angle-left(previous, back, arrow)' ),
			array( 'fa fa-angle-right' => 'angle-right(next, forward, arrow)' ),
			array( 'fa fa-angle-up' => 'angle-up(arrow)' ),
			array( 'fa fa-angle-down' => 'angle-down(arrow)' ),
			array( 'fa fa-chevron-circle-left' => 'Chevron Circle Left(previous, back, arrow)' ),
			array( 'fa fa-chevron-circle-right' => 'Chevron Circle Right(next, forward, arrow)' ),
			array( 'fa fa-chevron-circle-up' => 'Chevron Circle Up(arrow)' ),
			array( 'fa fa-chevron-circle-down' => 'Chevron Circle Down(more, dropdown, menu, arrow)' ),
			array( 'fa fa-caret-square-o-down' => 'Caret Square Outlined Down(more, dropdown, menu)(toggle-down)' ),
			array( 'fa fa-caret-square-o-up' => 'Caret Square Outlined Up(toggle-up)' ),
			array( 'fa fa-caret-square-o-right' => 'Caret Square Outlined Right(next, forward)(toggle-right)' ),
			array( 'fa fa-long-arrow-down' => 'Long Arrow Down' ),
			array( 'fa fa-long-arrow-up' => 'Long Arrow Up' ),
			array( 'fa fa-long-arrow-left' => 'Long Arrow Left(previous, back)' ),
			array( 'fa fa-long-arrow-right' => 'Long Arrow Right' ),
			array( 'fa fa-arrow-circle-o-right' => 'Arrow Circle Outlined Right(next, forward)' ),
			array( 'fa fa-arrow-circle-o-left' => 'Arrow Circle Outlined Left(previous, back)' ),
			array( 'fa fa-caret-square-o-left' => 'Caret Square Outlined Left(previous, back)(toggle-left)' ),
		),
		'Video Player Icons' => array(
			array( 'fa fa-play-circle-o' => 'Play Circle Outlined' ),
			array( 'fa fa-step-backward' => 'step-backward(rewind, previous, beginning, start, first)' ),
			array( 'fa fa-fast-backward' => 'fast-backward(rewind, previous, beginning, start, first)' ),
			array( 'fa fa-backward' => 'backward(rewind, previous)' ),
			array( 'fa fa-play' => 'play(start, playing, music, sound)' ),
			array( 'fa fa-pause' => 'pause(wait)' ),
			array( 'fa fa-stop' => 'stop(block, box, square)' ),
			array( 'fa fa-forward' => 'forward(forward, next)' ),
			array( 'fa fa-fast-forward' => 'fast-forward(next, end, last)' ),
			array( 'fa fa-step-forward' => 'step-forward(next, end, last)' ),
			array( 'fa fa-eject' => 'eject' ),
			array( 'fa fa-expand' => 'Expand(enlarge, bigger, resize)' ),
			array( 'fa fa-compress' => 'Compress(collapse, combine, contract, merge, smaller)' ),
			array( 'fa fa-random' => 'random(sort, shuffle)' ),
			array( 'fa fa-arrows-alt' => 'Arrows Alt(expand, enlarge, fullscreen, bigger, move, reorder, resize, arrow)' ),
			array( 'fa fa-play-circle' => 'Play Circle(start, playing)' ),
			array( 'fa fa-youtube-play' => 'YouTube Play(start, playing)' ),
			array( 'fa fa-pause-circle' => 'Pause Circle' ),
			array( 'fa fa-pause-circle-o' => 'Pause Circle Outlined' ),
			array( 'fa fa-stop-circle' => 'Stop Circle' ),
			array( 'fa fa-stop-circle-o' => 'Stop Circle Outlined' ),
		),
		'Form Control Icons' => array(
			array( 'fa fa-check-square-o' => 'Check Square Outlined(todo, done, agree, accept, confirm, ok)' ),
			array( 'fa fa-square-o' => 'Square Outlined(block, square, box)' ),
			array( 'fa fa-square' => 'Square(block, box)' ),
			array( 'fa fa-plus-square' => 'Plus Square(add, new, create, expand)' ),
			array( 'fa fa-circle-o' => 'Circle Outlined' ),
			array( 'fa fa-circle' => 'Circle(dot, notification)' ),
			array( 'fa fa-minus-square' => 'Minus Square(hide, minify, delete, remove, trash, hide, collapse)' ),
			array( 'fa fa-minus-square-o' => 'Minus Square Outlined(hide, minify, delete, remove, trash, hide, collapse)' ),
			array( 'fa fa-check-square' => 'Check Square(checkmark, done, todo, agree, accept, confirm, ok)' ),
			array( 'fa fa-dot-circle-o' => 'Dot Circle Outlined(target, bullseye, notification)' ),
			array( 'fa fa-plus-square-o' => 'Plus Square Outlined(add, new, create, expand)' ),
		),
		'Transportation Icons' => array(
			array( 'fa fa-plane' => 'plane(travel, trip, location, destination, airplane, fly, mode)' ),
			array( 'fa fa-truck' => 'truck(shipping)' ),
			array( 'fa fa-ambulance' => 'ambulance(vehicle, support, help)' ),
			array( 'fa fa-fighter-jet' => 'fighter-jet(fly, plane, airplane, quick, fast, travel)' ),
			array( 'fa fa-rocket' => 'rocket(app)' ),
			array( 'fa fa-wheelchair' => 'Wheelchair(handicap, person)' ),
			array( 'fa fa-space-shuttle' => 'Space Shuttle' ),
			array( 'fa fa-car' => 'Car(vehicle)(automobile)' ),
			array( 'fa fa-taxi' => 'Taxi(vehicle)(cab)' ),
			array( 'fa fa-bicycle' => 'Bicycle(vehicle, bike)' ),
			array( 'fa fa-bus' => 'Bus(vehicle)' ),
			array( 'fa fa-ship' => 'Ship(boat, sea)' ),
			array( 'fa fa-motorcycle' => 'Motorcycle(vehicle, bike)' ),
			array( 'fa fa-train' => 'Train' ),
			array( 'fa fa-subway' => 'Subway' ),
			array( 'fa fa-wheelchair-alt' => 'Wheelchair Alt(handicap, person)' ),
		),
		'Chart Icons' => array(
			array( 'fa fa-bar-chart' => 'Bar Chart(graph, analytics, statistics)(bar-chart-o)' ),
			array( 'fa fa-area-chart' => 'Area Chart(graph, analytics, statistics)' ),
			array( 'fa fa-pie-chart' => 'Pie Chart(graph, analytics, statistics)' ),
			array( 'fa fa-line-chart' => 'Line Chart(graph, analytics, statistics)' ),
		),
		'Brand Icons' => array(
			array( 'fa fa-twitter-square' => 'Twitter Square(tweet, social network)' ),
			array( 'fa fa-facebook-square' => 'Facebook Square(social network)' ),
			array( 'fa fa-linkedin-square' => 'LinkedIn Square' ),
			array( 'fa fa-github-square' => 'GitHub Square(octocat)' ),
			array( 'fa fa-twitter' => 'Twitter(tweet, social network)' ),
			array( 'fa fa-facebook' => 'Facebook(social network)(facebook-f)' ),
			array( 'fa fa-github' => 'GitHub(octocat)' ),
			array( 'fa fa-pinterest' => 'Pinterest' ),
			array( 'fa fa-pinterest-square' => 'Pinterest Square' ),
			array( 'fa fa-google-plus-square' => 'Google Plus Square(social network)' ),
			array( 'fa fa-google-plus' => 'Google Plus(social network)' ),
			array( 'fa fa-linkedin' => 'LinkedIn' ),
			array( 'fa fa-github-alt' => 'GitHub Alt(octocat)' ),
			array( 'fa fa-maxcdn' => 'MaxCDN' ),
			array( 'fa fa-html5' => 'HTML 5 Logo' ),
			array( 'fa fa-css3' => 'CSS 3 Logo(code)' ),
			array( 'fa fa-btc' => 'Bitcoin (BTC)(bitcoin)' ),
			array( 'fa fa-youtube-square' => 'YouTube Square(video, film)' ),
			array( 'fa fa-youtube' => 'YouTube(video, film)' ),
			array( 'fa fa-xing' => 'Xing' ),
			array( 'fa fa-xing-square' => 'Xing Square' ),
			array( 'fa fa-youtube-play' => 'YouTube Play(start, playing)' ),
			array( 'fa fa-dropbox' => 'Dropbox' ),
			array( 'fa fa-stack-overflow' => 'Stack Overflow' ),
			array( 'fa fa-instagram' => 'Instagram' ),
			array( 'fa fa-flickr' => 'Flickr' ),
			array( 'fa fa-adn' => 'App.net' ),
			array( 'fa fa-bitbucket' => 'Bitbucket(git)' ),
			array( 'fa fa-bitbucket-square' => 'Bitbucket Square(git)' ),
			array( 'fa fa-tumblr' => 'Tumblr' ),
			array( 'fa fa-tumblr-square' => 'Tumblr Square' ),
			array( 'fa fa-apple' => 'Apple(osx, food)' ),
			array( 'fa fa-windows' => 'Windows(microsoft)' ),
			array( 'fa fa-android' => 'Android(robot)' ),
			array( 'fa fa-linux' => 'Linux(tux)' ),
			array( 'fa fa-dribbble' => 'Dribbble' ),
			array( 'fa fa-skype' => 'Skype' ),
			array( 'fa fa-foursquare' => 'Foursquare' ),
			array( 'fa fa-trello' => 'Trello' ),
			array( 'fa fa-gratipay' => 'Gratipay (Gittip)(heart, like, favorite, love)(gittip)' ),
			array( 'fa fa-vk' => 'VK' ),
			array( 'fa fa-weibo' => 'Weibo' ),
			array( 'fa fa-renren' => 'Renren' ),
			array( 'fa fa-pagelines' => 'Pagelines(leaf, leaves, tree, plant, eco, nature)' ),
			array( 'fa fa-stack-exchange' => 'Stack Exchange' ),
			array( 'fa fa-vimeo-square' => 'Vimeo Square' ),
			array( 'fa fa-slack' => 'Slack Logo(hashtag, anchor, hash)' ),
			array( 'fa fa-wordpress' => 'WordPress Logo' ),
			array( 'fa fa-openid' => 'OpenID' ),
			array( 'fa fa-yahoo' => 'Yahoo Logo' ),
			array( 'fa fa-google' => 'Google Logo' ),
			array( 'fa fa-reddit' => 'reddit Logo' ),
			array( 'fa fa-reddit-square' => 'reddit Square' ),
			array( 'fa fa-stumbleupon-circle' => 'StumbleUpon Circle' ),
			array( 'fa fa-stumbleupon' => 'StumbleUpon Logo' ),
			array( 'fa fa-delicious' => 'Delicious Logo' ),
			array( 'fa fa-digg' => 'Digg Logo' ),
			array( 'fa fa-pied-piper-pp' => 'Pied Piper PP Logo (Old)' ),
			array( 'fa fa-pied-piper-alt' => 'Pied Piper Alternate Logo' ),
			array( 'fa fa-drupal' => 'Drupal Logo' ),
			array( 'fa fa-joomla' => 'Joomla Logo' ),
			array( 'fa fa-behance' => 'Behance' ),
			array( 'fa fa-behance-square' => 'Behance Square' ),
			array( 'fa fa-steam' => 'Steam' ),
			array( 'fa fa-steam-square' => 'Steam Square' ),
			array( 'fa fa-spotify' => 'Spotify' ),
			array( 'fa fa-deviantart' => 'deviantART' ),
			array( 'fa fa-soundcloud' => 'SoundCloud' ),
			array( 'fa fa-vine' => 'Vine' ),
			array( 'fa fa-codepen' => 'Codepen' ),
			array( 'fa fa-jsfiddle' => 'jsFiddle' ),
			array( 'fa fa-rebel' => 'Rebel Alliance(ra, resistance)' ),
			array( 'fa fa-empire' => 'Galactic Empire(ge)' ),
			array( 'fa fa-git-square' => 'Git Square' ),
			array( 'fa fa-git' => 'Git' ),
			array( 'fa fa-hacker-news' => 'Hacker News(y-combinator-square, yc-square)' ),
			array( 'fa fa-tencent-weibo' => 'Tencent Weibo' ),
			array( 'fa fa-qq' => 'QQ' ),
			array( 'fa fa-weixin' => 'Weixin (WeChat)(wechat)' ),
			array( 'fa fa-share-alt' => 'Share Alt' ),
			array( 'fa fa-share-alt-square' => 'Share Alt Square' ),
			array( 'fa fa-slideshare' => 'Slideshare' ),
			array( 'fa fa-twitch' => 'Twitch' ),
			array( 'fa fa-yelp' => 'Yelp' ),
			array( 'fa fa-paypal' => 'Paypal' ),
			array( 'fa fa-google-wallet' => 'Google Wallet' ),
			array( 'fa fa-cc-visa' => 'Visa Credit Card' ),
			array( 'fa fa-cc-mastercard' => 'MasterCard Credit Card' ),
			array( 'fa fa-cc-discover' => 'Discover Credit Card' ),
			array( 'fa fa-cc-amex' => 'American Express Credit Card(amex)' ),
			array( 'fa fa-cc-paypal' => 'Paypal Credit Card' ),
			array( 'fa fa-cc-stripe' => 'Stripe Credit Card' ),
			array( 'fa fa-lastfm' => 'last.fm' ),
			array( 'fa fa-lastfm-square' => 'last.fm Square' ),
			array( 'fa fa-ioxhost' => 'ioxhost' ),
			array( 'fa fa-angellist' => 'AngelList' ),
			array( 'fa fa-meanpath' => 'meanpath' ),
			array( 'fa fa-buysellads' => 'BuySellAds' ),
			array( 'fa fa-connectdevelop' => 'Connect Develop' ),
			array( 'fa fa-dashcube' => 'DashCube' ),
			array( 'fa fa-forumbee' => 'Forumbee' ),
			array( 'fa fa-leanpub' => 'Leanpub' ),
			array( 'fa fa-sellsy' => 'Sellsy' ),
			array( 'fa fa-shirtsinbulk' => 'Shirts in Bulk' ),
			array( 'fa fa-simplybuilt' => 'SimplyBuilt' ),
			array( 'fa fa-skyatlas' => 'skyatlas' ),
			array( 'fa fa-facebook-official' => 'Facebook Official' ),
			array( 'fa fa-pinterest-p' => 'Pinterest P' ),
			array( 'fa fa-whatsapp' => 'What\'s App' ),
			array( 'fa fa-viacoin' => 'Viacoin' ),
			array( 'fa fa-medium' => 'Medium' ),
			array( 'fa fa-y-combinator' => 'Y Combinator(yc)' ),
			array( 'fa fa-optin-monster' => 'Optin Monster' ),
			array( 'fa fa-opencart' => 'OpenCart' ),
			array( 'fa fa-expeditedssl' => 'ExpeditedSSL' ),
			array( 'fa fa-cc-jcb' => 'JCB Credit Card' ),
			array( 'fa fa-cc-diners-club' => 'Diner\'s Club Credit Card' ),
			array( 'fa fa-gg' => 'GG Currency' ),
			array( 'fa fa-gg-circle' => 'GG Currency Circle' ),
			array( 'fa fa-tripadvisor' => 'TripAdvisor' ),
			array( 'fa fa-odnoklassniki' => 'Odnoklassniki' ),
			array( 'fa fa-odnoklassniki-square' => 'Odnoklassniki Square' ),
			array( 'fa fa-get-pocket' => 'Get Pocket' ),
			array( 'fa fa-wikipedia-w' => 'Wikipedia W' ),
			array( 'fa fa-safari' => 'Safari(browser)' ),
			array( 'fa fa-chrome' => 'Chrome(browser)' ),
			array( 'fa fa-firefox' => 'Firefox(browser)' ),
			array( 'fa fa-opera' => 'Opera' ),
			array( 'fa fa-internet-explorer' => 'Internet-explorer(browser, ie)' ),
			array( 'fa fa-contao' => 'Contao' ),
			array( 'fa fa-500px' => '500px' ),
			array( 'fa fa-amazon' => 'Amazon' ),
			array( 'fa fa-houzz' => 'Houzz' ),
			array( 'fa fa-vimeo' => 'Vimeo' ),
			array( 'fa fa-black-tie' => 'Font Awesome Black Tie' ),
			array( 'fa fa-fonticons' => 'Fonticons' ),
			array( 'fa fa-reddit-alien' => 'reddit Alien' ),
			array( 'fa fa-edge' => 'Edge Browser(browser, ie)' ),
			array( 'fa fa-codiepie' => 'Codie Pie' ),
			array( 'fa fa-modx' => 'MODX' ),
			array( 'fa fa-fort-awesome' => 'Fort Awesome' ),
			array( 'fa fa-usb' => 'USB' ),
			array( 'fa fa-product-hunt' => 'Product Hunt' ),
			array( 'fa fa-mixcloud' => 'Mixcloud' ),
			array( 'fa fa-scribd' => 'Scribd' ),
			array( 'fa fa-bluetooth' => 'Bluetooth' ),
			array( 'fa fa-bluetooth-b' => 'Bluetooth' ),
			array( 'fa fa-gitlab' => 'GitLab' ),
			array( 'fa fa-wpbeginner' => 'WPBeginner' ),
			array( 'fa fa-wpforms' => 'WPForms' ),
			array( 'fa fa-envira' => 'Envira Gallery(leaf)' ),
			array( 'fa fa-glide' => 'Glide' ),
			array( 'fa fa-glide-g' => 'Glide G' ),
			array( 'fa fa-viadeo' => 'Viadeo' ),
			array( 'fa fa-viadeo-square' => 'Viadeo Square' ),
			array( 'fa fa-snapchat' => 'Snapchat' ),
			array( 'fa fa-snapchat-ghost' => 'Snapchat Ghost' ),
			array( 'fa fa-snapchat-square' => 'Snapchat Square' ),
			array( 'fa fa-pied-piper' => 'Pied Piper Logo' ),
			array( 'fa fa-first-order' => 'First Order' ),
			array( 'fa fa-yoast' => 'Yoast' ),
			array( 'fa fa-themeisle' => 'ThemeIsle' ),
			array( 'fa fa-google-plus-official' => 'Google Plus Official(google-plus-circle)' ),
			array( 'fa fa-font-awesome' => 'Font Awesome(fa)' ),
			array( 'fa fa-linode' => 'Linode' ),
			array( 'fa fa-quora' => 'Quora' ),
			array( 'fa fa-free-code-camp' => 'Free Code Camp' ),
			array( 'fa fa-telegram' => 'Telegram' ),
			array( 'fa fa-bandcamp' => 'Bandcamp' ),
			array( 'fa fa-grav' => 'Grav' ),
			array( 'fa fa-etsy' => 'Etsy' ),
			array( 'fa fa-imdb' => 'IMDB' ),
			array( 'fa fa-ravelry' => 'Ravelry' ),
			array( 'fa fa-eercast' => 'Eercast' ),
			array( 'fa fa-superpowers' => 'Superpowers' ),
			array( 'fa fa-wpexplorer' => 'WPExplorer' ),
			array( 'fa fa-meetup' => 'Meetup' ),
		),
		'Hand Icons' => array(
			array( 'fa fa-thumbs-o-up' => 'Thumbs Up Outlined(like, approve, favorite, agree, hand)' ),
			array( 'fa fa-thumbs-o-down' => 'Thumbs Down Outlined(dislike, disapprove, disagree, hand)' ),
			array( 'fa fa-hand-o-right' => 'Hand Outlined Right(point, right, next, forward, finger)' ),
			array( 'fa fa-hand-o-left' => 'Hand Outlined Left(point, left, previous, back, finger)' ),
			array( 'fa fa-hand-o-up' => 'Hand Outlined Up(point, finger)' ),
			array( 'fa fa-hand-o-down' => 'Hand Outlined Down(point, finger)' ),
			array( 'fa fa-thumbs-up' => 'thumbs-up(like, favorite, approve, agree, hand)' ),
			array( 'fa fa-thumbs-down' => 'thumbs-down(dislike, disapprove, disagree, hand)' ),
			array( 'fa fa-hand-rock-o' => 'Rock (Hand)(hand-grab-o)' ),
			array( 'fa fa-hand-paper-o' => 'Paper (Hand)(stop)(hand-stop-o)' ),
			array( 'fa fa-hand-scissors-o' => 'Scissors (Hand)' ),
			array( 'fa fa-hand-lizard-o' => 'Lizard (Hand)' ),
			array( 'fa fa-hand-spock-o' => 'Spock (Hand)' ),
			array( 'fa fa-hand-pointer-o' => 'Hand Pointer' ),
			array( 'fa fa-hand-peace-o' => 'Hand Peace' ),
		),
		'Payment Icons' => array(
			array( 'fa fa-credit-card' => 'credit-card(money, buy, debit, checkout, purchase, payment)' ),
			array( 'fa fa-paypal' => 'Paypal' ),
			array( 'fa fa-google-wallet' => 'Google Wallet' ),
			array( 'fa fa-cc-visa' => 'Visa Credit Card' ),
			array( 'fa fa-cc-mastercard' => 'MasterCard Credit Card' ),
			array( 'fa fa-cc-discover' => 'Discover Credit Card' ),
			array( 'fa fa-cc-amex' => 'American Express Credit Card(amex)' ),
			array( 'fa fa-cc-paypal' => 'Paypal Credit Card' ),
			array( 'fa fa-cc-stripe' => 'Stripe Credit Card' ),
			array( 'fa fa-cc-jcb' => 'JCB Credit Card' ),
			array( 'fa fa-cc-diners-club' => 'Diner\'s Club Credit Card' ),
			array( 'fa fa-credit-card-alt' => 'Credit Card(money, buy, debit, checkout, purchase, payment, credit card)' ),
		),
		'Currency Icons' => array(
			array( 'fa fa-money' => 'Money(cash, money, buy, checkout, purchase, payment)' ),
			array( 'fa fa-eur' => 'Euro (EUR)(euro)' ),
			array( 'fa fa-gbp' => 'GBP' ),
			array( 'fa fa-usd' => 'US Dollar(dollar)' ),
			array( 'fa fa-inr' => 'Indian Rupee (INR)(rupee)' ),
			array( 'fa fa-jpy' => 'Japanese Yen (JPY)(cny, rmb, yen)' ),
			array( 'fa fa-rub' => 'Russian Ruble (RUB)(ruble, rouble)' ),
			array( 'fa fa-krw' => 'Korean Won (KRW)(won)' ),
			array( 'fa fa-btc' => 'Bitcoin (BTC)(bitcoin)' ),
			array( 'fa fa-try' => 'Turkish Lira (TRY)(turkish-lira)' ),
			array( 'fa fa-ils' => 'Shekel (ILS)(shekel, sheqel)' ),
			array( 'fa fa-gg' => 'GG Currency' ),
			array( 'fa fa-gg-circle' => 'GG Currency Circle' ),
		),
		'Accessibility Icons' => array(
			array( 'fa fa-wheelchair' => 'Wheelchair(handicap, person)' ),
			array( 'fa fa-tty' => 'TTY' ),
			array( 'fa fa-cc' => 'Closed Captions' ),
			array( 'fa fa-universal-access' => 'Universal Access' ),
			array( 'fa fa-wheelchair-alt' => 'Wheelchair Alt(handicap, person)' ),
			array( 'fa fa-question-circle-o' => 'Question Circle Outlined' ),
			array( 'fa fa-blind' => 'Blind' ),
			array( 'fa fa-audio-description' => 'Audio Description' ),
			array( 'fa fa-volume-control-phone' => 'Volume Control Phone(telephone)' ),
			array( 'fa fa-braille' => 'Braille' ),
			array( 'fa fa-assistive-listening-systems' => 'Assistive Listening Systems' ),
			array( 'fa fa-american-sign-language-interpreting' => 'American Sign Language Interpreting(asl-interpreting)' ),
			array( 'fa fa-deaf' => 'Deaf(deafness, hard-of-hearing)' ),
			array( 'fa fa-sign-language' => 'Sign Language(signing)' ),
			array( 'fa fa-low-vision' => 'Low Vision' ),
		),
		'Gender Icons' => array(
			array( 'fa fa-venus' => 'Venus(female)' ),
			array( 'fa fa-mars' => 'Mars(male)' ),
			array( 'fa fa-mercury' => 'Mercury(transgender)' ),
			array( 'fa fa-transgender' => 'Transgender(intersex)' ),
			array( 'fa fa-transgender-alt' => 'Transgender Alt' ),
			array( 'fa fa-venus-double' => 'Venus Double' ),
			array( 'fa fa-mars-double' => 'Mars Double' ),
			array( 'fa fa-venus-mars' => 'Venus Mars' ),
			array( 'fa fa-mars-stroke' => 'Mars Stroke' ),
			array( 'fa fa-mars-stroke-v' => 'Mars Stroke Vertical' ),
			array( 'fa fa-mars-stroke-h' => 'Mars Stroke Horizontal' ),
			array( 'fa fa-neuter' => 'Neuter' ),
			array( 'fa fa-genderless' => 'Genderless' ),
		),
	);

	return array_merge( $icons, $fontawesome_icons );
}

add_filter( 'vc_iconpicker-type-openiconic', 'vc_iconpicker_type_openiconic' );

/**
 * Openicons icons from fontello.com
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @since 4.4
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
function vc_iconpicker_type_openiconic( $icons ) {
	$openiconic_icons = array(
		array( 'vc-oi vc-oi-dial' => 'Dial' ),
		array( 'vc-oi vc-oi-pilcrow' => 'Pilcrow' ),
		array( 'vc-oi vc-oi-at' => 'At' ),
		array( 'vc-oi vc-oi-hash' => 'Hash' ),
		array( 'vc-oi vc-oi-key-inv' => 'Key-inv' ),
		array( 'vc-oi vc-oi-key' => 'Key' ),
		array( 'vc-oi vc-oi-chart-pie-alt' => 'Chart-pie-alt' ),
		array( 'vc-oi vc-oi-chart-pie' => 'Chart-pie' ),
		array( 'vc-oi vc-oi-chart-bar' => 'Chart-bar' ),
		array( 'vc-oi vc-oi-umbrella' => 'Umbrella' ),
		array( 'vc-oi vc-oi-moon-inv' => 'Moon-inv' ),
		array( 'vc-oi vc-oi-mobile' => 'Mobile' ),
		array( 'vc-oi vc-oi-cd' => 'Cd' ),
		array( 'vc-oi vc-oi-split' => 'Split' ),
		array( 'vc-oi vc-oi-exchange' => 'Exchange' ),
		array( 'vc-oi vc-oi-block' => 'Block' ),
		array( 'vc-oi vc-oi-resize-full' => 'Resize-full' ),
		array( 'vc-oi vc-oi-article-alt' => 'Article-alt' ),
		array( 'vc-oi vc-oi-article' => 'Article' ),
		array( 'vc-oi vc-oi-pencil-alt' => 'Pencil-alt' ),
		array( 'vc-oi vc-oi-undo' => 'Undo' ),
		array( 'vc-oi vc-oi-attach' => 'Attach' ),
		array( 'vc-oi vc-oi-link' => 'Link' ),
		array( 'vc-oi vc-oi-search' => 'Search' ),
		array( 'vc-oi vc-oi-mail' => 'Mail' ),
		array( 'vc-oi vc-oi-heart' => 'Heart' ),
		array( 'vc-oi vc-oi-comment' => 'Comment' ),
		array( 'vc-oi vc-oi-resize-full-alt' => 'Resize-full-alt' ),
		array( 'vc-oi vc-oi-lock' => 'Lock' ),
		array( 'vc-oi vc-oi-book-open' => 'Book-open' ),
		array( 'vc-oi vc-oi-arrow-curved' => 'Arrow-curved' ),
		array( 'vc-oi vc-oi-equalizer' => 'Equalizer' ),
		array( 'vc-oi vc-oi-heart-empty' => 'Heart-empty' ),
		array( 'vc-oi vc-oi-lock-empty' => 'Lock-empty' ),
		array( 'vc-oi vc-oi-comment-inv' => 'Comment-inv' ),
		array( 'vc-oi vc-oi-folder' => 'Folder' ),
		array( 'vc-oi vc-oi-resize-small' => 'Resize-small' ),
		array( 'vc-oi vc-oi-play' => 'Play' ),
		array( 'vc-oi vc-oi-cursor' => 'Cursor' ),
		array( 'vc-oi vc-oi-aperture' => 'Aperture' ),
		array( 'vc-oi vc-oi-play-circle2' => 'Play-circle2' ),
		array( 'vc-oi vc-oi-resize-small-alt' => 'Resize-small-alt' ),
		array( 'vc-oi vc-oi-folder-empty' => 'Folder-empty' ),
		array( 'vc-oi vc-oi-comment-alt' => 'Comment-alt' ),
		array( 'vc-oi vc-oi-lock-open' => 'Lock-open' ),
		array( 'vc-oi vc-oi-star' => 'Star' ),
		array( 'vc-oi vc-oi-user' => 'User' ),
		array( 'vc-oi vc-oi-lock-open-empty' => 'Lock-open-empty' ),
		array( 'vc-oi vc-oi-box' => 'Box' ),
		array( 'vc-oi vc-oi-resize-vertical' => 'Resize-vertical' ),
		array( 'vc-oi vc-oi-stop' => 'Stop' ),
		array( 'vc-oi vc-oi-aperture-alt' => 'Aperture-alt' ),
		array( 'vc-oi vc-oi-book' => 'Book' ),
		array( 'vc-oi vc-oi-steering-wheel' => 'Steering-wheel' ),
		array( 'vc-oi vc-oi-pause' => 'Pause' ),
		array( 'vc-oi vc-oi-to-start' => 'To-start' ),
		array( 'vc-oi vc-oi-move' => 'Move' ),
		array( 'vc-oi vc-oi-resize-horizontal' => 'Resize-horizontal' ),
		array( 'vc-oi vc-oi-rss-alt' => 'Rss-alt' ),
		array( 'vc-oi vc-oi-comment-alt2' => 'Comment-alt2' ),
		array( 'vc-oi vc-oi-rss' => 'Rss' ),
		array( 'vc-oi vc-oi-comment-inv-alt' => 'Comment-inv-alt' ),
		array( 'vc-oi vc-oi-comment-inv-alt2' => 'Comment-inv-alt2' ),
		array( 'vc-oi vc-oi-eye' => 'Eye' ),
		array( 'vc-oi vc-oi-pin' => 'Pin' ),
		array( 'vc-oi vc-oi-video' => 'Video' ),
		array( 'vc-oi vc-oi-picture' => 'Picture' ),
		array( 'vc-oi vc-oi-camera' => 'Camera' ),
		array( 'vc-oi vc-oi-tag' => 'Tag' ),
		array( 'vc-oi vc-oi-chat' => 'Chat' ),
		array( 'vc-oi vc-oi-cog' => 'Cog' ),
		array( 'vc-oi vc-oi-popup' => 'Popup' ),
		array( 'vc-oi vc-oi-to-end' => 'To-end' ),
		array( 'vc-oi vc-oi-book-alt' => 'Book-alt' ),
		array( 'vc-oi vc-oi-brush' => 'Brush' ),
		array( 'vc-oi vc-oi-eject' => 'Eject' ),
		array( 'vc-oi vc-oi-down' => 'Down' ),
		array( 'vc-oi vc-oi-wrench' => 'Wrench' ),
		array( 'vc-oi vc-oi-chat-inv' => 'Chat-inv' ),
		array( 'vc-oi vc-oi-tag-empty' => 'Tag-empty' ),
		array( 'vc-oi vc-oi-ok' => 'Ok' ),
		array( 'vc-oi vc-oi-ok-circle' => 'Ok-circle' ),
		array( 'vc-oi vc-oi-download' => 'Download' ),
		array( 'vc-oi vc-oi-location' => 'Location' ),
		array( 'vc-oi vc-oi-share' => 'Share' ),
		array( 'vc-oi vc-oi-left' => 'Left' ),
		array( 'vc-oi vc-oi-target' => 'Target' ),
		array( 'vc-oi vc-oi-brush-alt' => 'Brush-alt' ),
		array( 'vc-oi vc-oi-cancel' => 'Cancel' ),
		array( 'vc-oi vc-oi-upload' => 'Upload' ),
		array( 'vc-oi vc-oi-location-inv' => 'Location-inv' ),
		array( 'vc-oi vc-oi-calendar' => 'Calendar' ),
		array( 'vc-oi vc-oi-right' => 'Right' ),
		array( 'vc-oi vc-oi-signal' => 'Signal' ),
		array( 'vc-oi vc-oi-eyedropper' => 'Eyedropper' ),
		array( 'vc-oi vc-oi-layers' => 'Layers' ),
		array( 'vc-oi vc-oi-award' => 'Award' ),
		array( 'vc-oi vc-oi-up' => 'Up' ),
		array( 'vc-oi vc-oi-calendar-inv' => 'Calendar-inv' ),
		array( 'vc-oi vc-oi-location-alt' => 'Location-alt' ),
		array( 'vc-oi vc-oi-download-cloud' => 'Download-cloud' ),
		array( 'vc-oi vc-oi-cancel-circle' => 'Cancel-circle' ),
		array( 'vc-oi vc-oi-plus' => 'Plus' ),
		array( 'vc-oi vc-oi-upload-cloud' => 'Upload-cloud' ),
		array( 'vc-oi vc-oi-compass' => 'Compass' ),
		array( 'vc-oi vc-oi-calendar-alt' => 'Calendar-alt' ),
		array( 'vc-oi vc-oi-down-circle' => 'Down-circle' ),
		array( 'vc-oi vc-oi-award-empty' => 'Award-empty' ),
		array( 'vc-oi vc-oi-layers-alt' => 'Layers-alt' ),
		array( 'vc-oi vc-oi-sun' => 'Sun' ),
		array( 'vc-oi vc-oi-list' => 'List' ),
		array( 'vc-oi vc-oi-left-circle' => 'Left-circle' ),
		array( 'vc-oi vc-oi-mic' => 'Mic' ),
		array( 'vc-oi vc-oi-trash' => 'Trash' ),
		array( 'vc-oi vc-oi-quote-left' => 'Quote-left' ),
		array( 'vc-oi vc-oi-plus-circle' => 'Plus-circle' ),
		array( 'vc-oi vc-oi-minus' => 'Minus' ),
		array( 'vc-oi vc-oi-quote-right' => 'Quote-right' ),
		array( 'vc-oi vc-oi-trash-empty' => 'Trash-empty' ),
		array( 'vc-oi vc-oi-volume-off' => 'Volume-off' ),
		array( 'vc-oi vc-oi-right-circle' => 'Right-circle' ),
		array( 'vc-oi vc-oi-list-nested' => 'List-nested' ),
		array( 'vc-oi vc-oi-sun-inv' => 'Sun-inv' ),
		array( 'vc-oi vc-oi-bat-empty' => 'Bat-empty' ),
		array( 'vc-oi vc-oi-up-circle' => 'Up-circle' ),
		array( 'vc-oi vc-oi-volume-up' => 'Volume-up' ),
		array( 'vc-oi vc-oi-doc' => 'Doc' ),
		array( 'vc-oi vc-oi-quote-left-alt' => 'Quote-left-alt' ),
		array( 'vc-oi vc-oi-minus-circle' => 'Minus-circle' ),
		array( 'vc-oi vc-oi-cloud' => 'Cloud' ),
		array( 'vc-oi vc-oi-rain' => 'Rain' ),
		array( 'vc-oi vc-oi-bat-half' => 'Bat-half' ),
		array( 'vc-oi vc-oi-cw' => 'Cw' ),
		array( 'vc-oi vc-oi-headphones' => 'Headphones' ),
		array( 'vc-oi vc-oi-doc-inv' => 'Doc-inv' ),
		array( 'vc-oi vc-oi-quote-right-alt' => 'Quote-right-alt' ),
		array( 'vc-oi vc-oi-help' => 'Help' ),
		array( 'vc-oi vc-oi-info' => 'Info' ),
		array( 'vc-oi vc-oi-pencil' => 'Pencil' ),
		array( 'vc-oi vc-oi-doc-alt' => 'Doc-alt' ),
		array( 'vc-oi vc-oi-clock' => 'Clock' ),
		array( 'vc-oi vc-oi-loop' => 'Loop' ),
		array( 'vc-oi vc-oi-bat-full' => 'Bat-full' ),
		array( 'vc-oi vc-oi-flash' => 'Flash' ),
		array( 'vc-oi vc-oi-moon' => 'Moon' ),
		array( 'vc-oi vc-oi-bat-charge' => 'Bat-charge' ),
		array( 'vc-oi vc-oi-loop-alt' => 'Loop-alt' ),
		array( 'vc-oi vc-oi-lamp' => 'Lamp' ),
		array( 'vc-oi vc-oi-doc-inv-alt' => 'Doc-inv-alt' ),
		array( 'vc-oi vc-oi-pencil-neg' => 'Pencil-neg' ),
		array( 'vc-oi vc-oi-home' => 'Home' ),
	);

	return array_merge( $icons, $openiconic_icons );
}

add_filter( 'vc_iconpicker-type-typicons', 'vc_iconpicker_type_typicons' );

/**
 * Typicons icons from github.com/stephenhutchings/typicons.font
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @since 4.4
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
function vc_iconpicker_type_typicons( $icons ) {
	$typicons_icons = array(
		array( 'typcn typcn-adjust-brightness' => 'Adjust Brightness' ),
		array( 'typcn typcn-adjust-contrast' => 'Adjust Contrast' ),
		array( 'typcn typcn-anchor-outline' => 'Anchor Outline' ),
		array( 'typcn typcn-anchor' => 'Anchor' ),
		array( 'typcn typcn-archive' => 'Archive' ),
		array( 'typcn typcn-arrow-back-outline' => 'Arrow Back Outline' ),
		array( 'typcn typcn-arrow-back' => 'Arrow Back' ),
		array( 'typcn typcn-arrow-down-outline' => 'Arrow Down Outline' ),
		array( 'typcn typcn-arrow-down-thick' => 'Arrow Down Thick' ),
		array( 'typcn typcn-arrow-down' => 'Arrow Down' ),
		array( 'typcn typcn-arrow-forward-outline' => 'Arrow Forward Outline' ),
		array( 'typcn typcn-arrow-forward' => 'Arrow Forward' ),
		array( 'typcn typcn-arrow-left-outline' => 'Arrow Left Outline' ),
		array( 'typcn typcn-arrow-left-thick' => 'Arrow Left Thick' ),
		array( 'typcn typcn-arrow-left' => 'Arrow Left' ),
		array( 'typcn typcn-arrow-loop-outline' => 'Arrow Loop Outline' ),
		array( 'typcn typcn-arrow-loop' => 'Arrow Loop' ),
		array( 'typcn typcn-arrow-maximise-outline' => 'Arrow Maximise Outline' ),
		array( 'typcn typcn-arrow-maximise' => 'Arrow Maximise' ),
		array( 'typcn typcn-arrow-minimise-outline' => 'Arrow Minimise Outline' ),
		array( 'typcn typcn-arrow-minimise' => 'Arrow Minimise' ),
		array( 'typcn typcn-arrow-move-outline' => 'Arrow Move Outline' ),
		array( 'typcn typcn-arrow-move' => 'Arrow Move' ),
		array( 'typcn typcn-arrow-repeat-outline' => 'Arrow Repeat Outline' ),
		array( 'typcn typcn-arrow-repeat' => 'Arrow Repeat' ),
		array( 'typcn typcn-arrow-right-outline' => 'Arrow Right Outline' ),
		array( 'typcn typcn-arrow-right-thick' => 'Arrow Right Thick' ),
		array( 'typcn typcn-arrow-right' => 'Arrow Right' ),
		array( 'typcn typcn-arrow-shuffle' => 'Arrow Shuffle' ),
		array( 'typcn typcn-arrow-sorted-down' => 'Arrow Sorted Down' ),
		array( 'typcn typcn-arrow-sorted-up' => 'Arrow Sorted Up' ),
		array( 'typcn typcn-arrow-sync-outline' => 'Arrow Sync Outline' ),
		array( 'typcn typcn-arrow-sync' => 'Arrow Sync' ),
		array( 'typcn typcn-arrow-unsorted' => 'Arrow Unsorted' ),
		array( 'typcn typcn-arrow-up-outline' => 'Arrow Up Outline' ),
		array( 'typcn typcn-arrow-up-thick' => 'Arrow Up Thick' ),
		array( 'typcn typcn-arrow-up' => 'Arrow Up' ),
		array( 'typcn typcn-at' => 'At' ),
		array( 'typcn typcn-attachment-outline' => 'Attachment Outline' ),
		array( 'typcn typcn-attachment' => 'Attachment' ),
		array( 'typcn typcn-backspace-outline' => 'Backspace Outline' ),
		array( 'typcn typcn-backspace' => 'Backspace' ),
		array( 'typcn typcn-battery-charge' => 'Battery Charge' ),
		array( 'typcn typcn-battery-full' => 'Battery Full' ),
		array( 'typcn typcn-battery-high' => 'Battery High' ),
		array( 'typcn typcn-battery-low' => 'Battery Low' ),
		array( 'typcn typcn-battery-mid' => 'Battery Mid' ),
		array( 'typcn typcn-beaker' => 'Beaker' ),
		array( 'typcn typcn-beer' => 'Beer' ),
		array( 'typcn typcn-bell' => 'Bell' ),
		array( 'typcn typcn-book' => 'Book' ),
		array( 'typcn typcn-bookmark' => 'Bookmark' ),
		array( 'typcn typcn-briefcase' => 'Briefcase' ),
		array( 'typcn typcn-brush' => 'Brush' ),
		array( 'typcn typcn-business-card' => 'Business Card' ),
		array( 'typcn typcn-calculator' => 'Calculator' ),
		array( 'typcn typcn-calendar-outline' => 'Calendar Outline' ),
		array( 'typcn typcn-calendar' => 'Calendar' ),
		array( 'typcn typcn-camera-outline' => 'Camera Outline' ),
		array( 'typcn typcn-camera' => 'Camera' ),
		array( 'typcn typcn-cancel-outline' => 'Cancel Outline' ),
		array( 'typcn typcn-cancel' => 'Cancel' ),
		array( 'typcn typcn-chart-area-outline' => 'Chart Area Outline' ),
		array( 'typcn typcn-chart-area' => 'Chart Area' ),
		array( 'typcn typcn-chart-bar-outline' => 'Chart Bar Outline' ),
		array( 'typcn typcn-chart-bar' => 'Chart Bar' ),
		array( 'typcn typcn-chart-line-outline' => 'Chart Line Outline' ),
		array( 'typcn typcn-chart-line' => 'Chart Line' ),
		array( 'typcn typcn-chart-pie-outline' => 'Chart Pie Outline' ),
		array( 'typcn typcn-chart-pie' => 'Chart Pie' ),
		array( 'typcn typcn-chevron-left-outline' => 'Chevron Left Outline' ),
		array( 'typcn typcn-chevron-left' => 'Chevron Left' ),
		array( 'typcn typcn-chevron-right-outline' => 'Chevron Right Outline' ),
		array( 'typcn typcn-chevron-right' => 'Chevron Right' ),
		array( 'typcn typcn-clipboard' => 'Clipboard' ),
		array( 'typcn typcn-cloud-storage' => 'Cloud Storage' ),
		array( 'typcn typcn-cloud-storage-outline' => 'Cloud Storage Outline' ),
		array( 'typcn typcn-code-outline' => 'Code Outline' ),
		array( 'typcn typcn-code' => 'Code' ),
		array( 'typcn typcn-coffee' => 'Coffee' ),
		array( 'typcn typcn-cog-outline' => 'Cog Outline' ),
		array( 'typcn typcn-cog' => 'Cog' ),
		array( 'typcn typcn-compass' => 'Compass' ),
		array( 'typcn typcn-contacts' => 'Contacts' ),
		array( 'typcn typcn-credit-card' => 'Credit Card' ),
		array( 'typcn typcn-css3' => 'Css3' ),
		array( 'typcn typcn-database' => 'Database' ),
		array( 'typcn typcn-delete-outline' => 'Delete Outline' ),
		array( 'typcn typcn-delete' => 'Delete' ),
		array( 'typcn typcn-device-desktop' => 'Device Desktop' ),
		array( 'typcn typcn-device-laptop' => 'Device Laptop' ),
		array( 'typcn typcn-device-phone' => 'Device Phone' ),
		array( 'typcn typcn-device-tablet' => 'Device Tablet' ),
		array( 'typcn typcn-directions' => 'Directions' ),
		array( 'typcn typcn-divide-outline' => 'Divide Outline' ),
		array( 'typcn typcn-divide' => 'Divide' ),
		array( 'typcn typcn-document-add' => 'Document Add' ),
		array( 'typcn typcn-document-delete' => 'Document Delete' ),
		array( 'typcn typcn-document-text' => 'Document Text' ),
		array( 'typcn typcn-document' => 'Document' ),
		array( 'typcn typcn-download-outline' => 'Download Outline' ),
		array( 'typcn typcn-download' => 'Download' ),
		array( 'typcn typcn-dropbox' => 'Dropbox' ),
		array( 'typcn typcn-edit' => 'Edit' ),
		array( 'typcn typcn-eject-outline' => 'Eject Outline' ),
		array( 'typcn typcn-eject' => 'Eject' ),
		array( 'typcn typcn-equals-outline' => 'Equals Outline' ),
		array( 'typcn typcn-equals' => 'Equals' ),
		array( 'typcn typcn-export-outline' => 'Export Outline' ),
		array( 'typcn typcn-export' => 'Export' ),
		array( 'typcn typcn-eye-outline' => 'Eye Outline' ),
		array( 'typcn typcn-eye' => 'Eye' ),
		array( 'typcn typcn-feather' => 'Feather' ),
		array( 'typcn typcn-film' => 'Film' ),
		array( 'typcn typcn-filter' => 'Filter' ),
		array( 'typcn typcn-flag-outline' => 'Flag Outline' ),
		array( 'typcn typcn-flag' => 'Flag' ),
		array( 'typcn typcn-flash-outline' => 'Flash Outline' ),
		array( 'typcn typcn-flash' => 'Flash' ),
		array( 'typcn typcn-flow-children' => 'Flow Children' ),
		array( 'typcn typcn-flow-merge' => 'Flow Merge' ),
		array( 'typcn typcn-flow-parallel' => 'Flow Parallel' ),
		array( 'typcn typcn-flow-switch' => 'Flow Switch' ),
		array( 'typcn typcn-folder-add' => 'Folder Add' ),
		array( 'typcn typcn-folder-delete' => 'Folder Delete' ),
		array( 'typcn typcn-folder-open' => 'Folder Open' ),
		array( 'typcn typcn-folder' => 'Folder' ),
		array( 'typcn typcn-gift' => 'Gift' ),
		array( 'typcn typcn-globe-outline' => 'Globe Outline' ),
		array( 'typcn typcn-globe' => 'Globe' ),
		array( 'typcn typcn-group-outline' => 'Group Outline' ),
		array( 'typcn typcn-group' => 'Group' ),
		array( 'typcn typcn-headphones' => 'Headphones' ),
		array( 'typcn typcn-heart-full-outline' => 'Heart Full Outline' ),
		array( 'typcn typcn-heart-half-outline' => 'Heart Half Outline' ),
		array( 'typcn typcn-heart-outline' => 'Heart Outline' ),
		array( 'typcn typcn-heart' => 'Heart' ),
		array( 'typcn typcn-home-outline' => 'Home Outline' ),
		array( 'typcn typcn-home' => 'Home' ),
		array( 'typcn typcn-html5' => 'Html5' ),
		array( 'typcn typcn-image-outline' => 'Image Outline' ),
		array( 'typcn typcn-image' => 'Image' ),
		array( 'typcn typcn-infinity-outline' => 'Infinity Outline' ),
		array( 'typcn typcn-infinity' => 'Infinity' ),
		array( 'typcn typcn-info-large-outline' => 'Info Large Outline' ),
		array( 'typcn typcn-info-large' => 'Info Large' ),
		array( 'typcn typcn-info-outline' => 'Info Outline' ),
		array( 'typcn typcn-info' => 'Info' ),
		array( 'typcn typcn-input-checked-outline' => 'Input Checked Outline' ),
		array( 'typcn typcn-input-checked' => 'Input Checked' ),
		array( 'typcn typcn-key-outline' => 'Key Outline' ),
		array( 'typcn typcn-key' => 'Key' ),
		array( 'typcn typcn-keyboard' => 'Keyboard' ),
		array( 'typcn typcn-leaf' => 'Leaf' ),
		array( 'typcn typcn-lightbulb' => 'Lightbulb' ),
		array( 'typcn typcn-link-outline' => 'Link Outline' ),
		array( 'typcn typcn-link' => 'Link' ),
		array( 'typcn typcn-location-arrow-outline' => 'Location Arrow Outline' ),
		array( 'typcn typcn-location-arrow' => 'Location Arrow' ),
		array( 'typcn typcn-location-outline' => 'Location Outline' ),
		array( 'typcn typcn-location' => 'Location' ),
		array( 'typcn typcn-lock-closed-outline' => 'Lock Closed Outline' ),
		array( 'typcn typcn-lock-closed' => 'Lock Closed' ),
		array( 'typcn typcn-lock-open-outline' => 'Lock Open Outline' ),
		array( 'typcn typcn-lock-open' => 'Lock Open' ),
		array( 'typcn typcn-mail' => 'Mail' ),
		array( 'typcn typcn-map' => 'Map' ),
		array( 'typcn typcn-media-eject-outline' => 'Media Eject Outline' ),
		array( 'typcn typcn-media-eject' => 'Media Eject' ),
		array( 'typcn typcn-media-fast-forward-outline' => 'Media Fast Forward Outline' ),
		array( 'typcn typcn-media-fast-forward' => 'Media Fast Forward' ),
		array( 'typcn typcn-media-pause-outline' => 'Media Pause Outline' ),
		array( 'typcn typcn-media-pause' => 'Media Pause' ),
		array( 'typcn typcn-media-play-outline' => 'Media Play Outline' ),
		array( 'typcn typcn-media-play-reverse-outline' => 'Media Play Reverse Outline' ),
		array( 'typcn typcn-media-play-reverse' => 'Media Play Reverse' ),
		array( 'typcn typcn-media-play' => 'Media Play' ),
		array( 'typcn typcn-media-record-outline' => 'Media Record Outline' ),
		array( 'typcn typcn-media-record' => 'Media Record' ),
		array( 'typcn typcn-media-rewind-outline' => 'Media Rewind Outline' ),
		array( 'typcn typcn-media-rewind' => 'Media Rewind' ),
		array( 'typcn typcn-media-stop-outline' => 'Media Stop Outline' ),
		array( 'typcn typcn-media-stop' => 'Media Stop' ),
		array( 'typcn typcn-message-typing' => 'Message Typing' ),
		array( 'typcn typcn-message' => 'Message' ),
		array( 'typcn typcn-messages' => 'Messages' ),
		array( 'typcn typcn-microphone-outline' => 'Microphone Outline' ),
		array( 'typcn typcn-microphone' => 'Microphone' ),
		array( 'typcn typcn-minus-outline' => 'Minus Outline' ),
		array( 'typcn typcn-minus' => 'Minus' ),
		array( 'typcn typcn-mortar-board' => 'Mortar Board' ),
		array( 'typcn typcn-news' => 'News' ),
		array( 'typcn typcn-notes-outline' => 'Notes Outline' ),
		array( 'typcn typcn-notes' => 'Notes' ),
		array( 'typcn typcn-pen' => 'Pen' ),
		array( 'typcn typcn-pencil' => 'Pencil' ),
		array( 'typcn typcn-phone-outline' => 'Phone Outline' ),
		array( 'typcn typcn-phone' => 'Phone' ),
		array( 'typcn typcn-pi-outline' => 'Pi Outline' ),
		array( 'typcn typcn-pi' => 'Pi' ),
		array( 'typcn typcn-pin-outline' => 'Pin Outline' ),
		array( 'typcn typcn-pin' => 'Pin' ),
		array( 'typcn typcn-pipette' => 'Pipette' ),
		array( 'typcn typcn-plane-outline' => 'Plane Outline' ),
		array( 'typcn typcn-plane' => 'Plane' ),
		array( 'typcn typcn-plug' => 'Plug' ),
		array( 'typcn typcn-plus-outline' => 'Plus Outline' ),
		array( 'typcn typcn-plus' => 'Plus' ),
		array( 'typcn typcn-point-of-interest-outline' => 'Point Of Interest Outline' ),
		array( 'typcn typcn-point-of-interest' => 'Point Of Interest' ),
		array( 'typcn typcn-power-outline' => 'Power Outline' ),
		array( 'typcn typcn-power' => 'Power' ),
		array( 'typcn typcn-printer' => 'Printer' ),
		array( 'typcn typcn-puzzle-outline' => 'Puzzle Outline' ),
		array( 'typcn typcn-puzzle' => 'Puzzle' ),
		array( 'typcn typcn-radar-outline' => 'Radar Outline' ),
		array( 'typcn typcn-radar' => 'Radar' ),
		array( 'typcn typcn-refresh-outline' => 'Refresh Outline' ),
		array( 'typcn typcn-refresh' => 'Refresh' ),
		array( 'typcn typcn-rss-outline' => 'Rss Outline' ),
		array( 'typcn typcn-rss' => 'Rss' ),
		array( 'typcn typcn-scissors-outline' => 'Scissors Outline' ),
		array( 'typcn typcn-scissors' => 'Scissors' ),
		array( 'typcn typcn-shopping-bag' => 'Shopping Bag' ),
		array( 'typcn typcn-shopping-cart' => 'Shopping Cart' ),
		array( 'typcn typcn-social-at-circular' => 'Social At Circular' ),
		array( 'typcn typcn-social-dribbble-circular' => 'Social Dribbble Circular' ),
		array( 'typcn typcn-social-dribbble' => 'Social Dribbble' ),
		array( 'typcn typcn-social-facebook-circular' => 'Social Facebook Circular' ),
		array( 'typcn typcn-social-facebook' => 'Social Facebook' ),
		array( 'typcn typcn-social-flickr-circular' => 'Social Flickr Circular' ),
		array( 'typcn typcn-social-flickr' => 'Social Flickr' ),
		array( 'typcn typcn-social-github-circular' => 'Social Github Circular' ),
		array( 'typcn typcn-social-github' => 'Social Github' ),
		array( 'typcn typcn-social-google-plus-circular' => 'Social Google Plus Circular' ),
		array( 'typcn typcn-social-google-plus' => 'Social Google Plus' ),
		array( 'typcn typcn-social-instagram-circular' => 'Social Instagram Circular' ),
		array( 'typcn typcn-social-instagram' => 'Social Instagram' ),
		array( 'typcn typcn-social-last-fm-circular' => 'Social Last Fm Circular' ),
		array( 'typcn typcn-social-last-fm' => 'Social Last Fm' ),
		array( 'typcn typcn-social-linkedin-circular' => 'Social Linkedin Circular' ),
		array( 'typcn typcn-social-linkedin' => 'Social Linkedin' ),
		array( 'typcn typcn-social-pinterest-circular' => 'Social Pinterest Circular' ),
		array( 'typcn typcn-social-pinterest' => 'Social Pinterest' ),
		array( 'typcn typcn-social-skype-outline' => 'Social Skype Outline' ),
		array( 'typcn typcn-social-skype' => 'Social Skype' ),
		array( 'typcn typcn-social-tumbler-circular' => 'Social Tumbler Circular' ),
		array( 'typcn typcn-social-tumbler' => 'Social Tumbler' ),
		array( 'typcn typcn-social-twitter-circular' => 'Social Twitter Circular' ),
		array( 'typcn typcn-social-twitter' => 'Social Twitter' ),
		array( 'typcn typcn-social-vimeo-circular' => 'Social Vimeo Circular' ),
		array( 'typcn typcn-social-vimeo' => 'Social Vimeo' ),
		array( 'typcn typcn-social-youtube-circular' => 'Social Youtube Circular' ),
		array( 'typcn typcn-social-youtube' => 'Social Youtube' ),
		array( 'typcn typcn-sort-alphabetically-outline' => 'Sort Alphabetically Outline' ),
		array( 'typcn typcn-sort-alphabetically' => 'Sort Alphabetically' ),
		array( 'typcn typcn-sort-numerically-outline' => 'Sort Numerically Outline' ),
		array( 'typcn typcn-sort-numerically' => 'Sort Numerically' ),
		array( 'typcn typcn-spanner-outline' => 'Spanner Outline' ),
		array( 'typcn typcn-spanner' => 'Spanner' ),
		array( 'typcn typcn-spiral' => 'Spiral' ),
		array( 'typcn typcn-star-full-outline' => 'Star Full Outline' ),
		array( 'typcn typcn-star-half-outline' => 'Star Half Outline' ),
		array( 'typcn typcn-star-half' => 'Star Half' ),
		array( 'typcn typcn-star-outline' => 'Star Outline' ),
		array( 'typcn typcn-star' => 'Star' ),
		array( 'typcn typcn-starburst-outline' => 'Starburst Outline' ),
		array( 'typcn typcn-starburst' => 'Starburst' ),
		array( 'typcn typcn-stopwatch' => 'Stopwatch' ),
		array( 'typcn typcn-support' => 'Support' ),
		array( 'typcn typcn-tabs-outline' => 'Tabs Outline' ),
		array( 'typcn typcn-tag' => 'Tag' ),
		array( 'typcn typcn-tags' => 'Tags' ),
		array( 'typcn typcn-th-large-outline' => 'Th Large Outline' ),
		array( 'typcn typcn-th-large' => 'Th Large' ),
		array( 'typcn typcn-th-list-outline' => 'Th List Outline' ),
		array( 'typcn typcn-th-list' => 'Th List' ),
		array( 'typcn typcn-th-menu-outline' => 'Th Menu Outline' ),
		array( 'typcn typcn-th-menu' => 'Th Menu' ),
		array( 'typcn typcn-th-small-outline' => 'Th Small Outline' ),
		array( 'typcn typcn-th-small' => 'Th Small' ),
		array( 'typcn typcn-thermometer' => 'Thermometer' ),
		array( 'typcn typcn-thumbs-down' => 'Thumbs Down' ),
		array( 'typcn typcn-thumbs-ok' => 'Thumbs Ok' ),
		array( 'typcn typcn-thumbs-up' => 'Thumbs Up' ),
		array( 'typcn typcn-tick-outline' => 'Tick Outline' ),
		array( 'typcn typcn-tick' => 'Tick' ),
		array( 'typcn typcn-ticket' => 'Ticket' ),
		array( 'typcn typcn-time' => 'Time' ),
		array( 'typcn typcn-times-outline' => 'Times Outline' ),
		array( 'typcn typcn-times' => 'Times' ),
		array( 'typcn typcn-trash' => 'Trash' ),
		array( 'typcn typcn-tree' => 'Tree' ),
		array( 'typcn typcn-upload-outline' => 'Upload Outline' ),
		array( 'typcn typcn-upload' => 'Upload' ),
		array( 'typcn typcn-user-add-outline' => 'User Add Outline' ),
		array( 'typcn typcn-user-add' => 'User Add' ),
		array( 'typcn typcn-user-delete-outline' => 'User Delete Outline' ),
		array( 'typcn typcn-user-delete' => 'User Delete' ),
		array( 'typcn typcn-user-outline' => 'User Outline' ),
		array( 'typcn typcn-user' => 'User' ),
		array( 'typcn typcn-vendor-android' => 'Vendor Android' ),
		array( 'typcn typcn-vendor-apple' => 'Vendor Apple' ),
		array( 'typcn typcn-vendor-microsoft' => 'Vendor Microsoft' ),
		array( 'typcn typcn-video-outline' => 'Video Outline' ),
		array( 'typcn typcn-video' => 'Video' ),
		array( 'typcn typcn-volume-down' => 'Volume Down' ),
		array( 'typcn typcn-volume-mute' => 'Volume Mute' ),
		array( 'typcn typcn-volume-up' => 'Volume Up' ),
		array( 'typcn typcn-volume' => 'Volume' ),
		array( 'typcn typcn-warning-outline' => 'Warning Outline' ),
		array( 'typcn typcn-warning' => 'Warning' ),
		array( 'typcn typcn-watch' => 'Watch' ),
		array( 'typcn typcn-waves-outline' => 'Waves Outline' ),
		array( 'typcn typcn-waves' => 'Waves' ),
		array( 'typcn typcn-weather-cloudy' => 'Weather Cloudy' ),
		array( 'typcn typcn-weather-downpour' => 'Weather Downpour' ),
		array( 'typcn typcn-weather-night' => 'Weather Night' ),
		array( 'typcn typcn-weather-partly-sunny' => 'Weather Partly Sunny' ),
		array( 'typcn typcn-weather-shower' => 'Weather Shower' ),
		array( 'typcn typcn-weather-snow' => 'Weather Snow' ),
		array( 'typcn typcn-weather-stormy' => 'Weather Stormy' ),
		array( 'typcn typcn-weather-sunny' => 'Weather Sunny' ),
		array( 'typcn typcn-weather-windy-cloudy' => 'Weather Windy Cloudy' ),
		array( 'typcn typcn-weather-windy' => 'Weather Windy' ),
		array( 'typcn typcn-wi-fi-outline' => 'Wi Fi Outline' ),
		array( 'typcn typcn-wi-fi' => 'Wi Fi' ),
		array( 'typcn typcn-wine' => 'Wine' ),
		array( 'typcn typcn-world-outline' => 'World Outline' ),
		array( 'typcn typcn-world' => 'World' ),
		array( 'typcn typcn-zoom-in-outline' => 'Zoom In Outline' ),
		array( 'typcn typcn-zoom-in' => 'Zoom In' ),
		array( 'typcn typcn-zoom-out-outline' => 'Zoom Out Outline' ),
		array( 'typcn typcn-zoom-out' => 'Zoom Out' ),
		array( 'typcn typcn-zoom-outline' => 'Zoom Outline' ),
		array( 'typcn typcn-zoom' => 'Zoom' ),
	);

	return array_merge( $icons, $typicons_icons );
}

add_filter( 'vc_iconpicker-type-entypo', 'vc_iconpicker_type_entypo' );
/**
 * Entypo icons from github.com/danielbruce/entypo
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @since 4.4
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
function vc_iconpicker_type_entypo( $icons ) {
	$entypo_icons = array(
		array( 'entypo-icon entypo-icon-note' => 'Note' ),
		array( 'entypo-icon entypo-icon-note-beamed' => 'Note Beamed' ),
		array( 'entypo-icon entypo-icon-music' => 'Music' ),
		array( 'entypo-icon entypo-icon-search' => 'Search' ),
		array( 'entypo-icon entypo-icon-flashlight' => 'Flashlight' ),
		array( 'entypo-icon entypo-icon-mail' => 'Mail' ),
		array( 'entypo-icon entypo-icon-heart' => 'Heart' ),
		array( 'entypo-icon entypo-icon-heart-empty' => 'Heart Empty' ),
		array( 'entypo-icon entypo-icon-star' => 'Star' ),
		array( 'entypo-icon entypo-icon-star-empty' => 'Star Empty' ),
		array( 'entypo-icon entypo-icon-user' => 'User' ),
		array( 'entypo-icon entypo-icon-users' => 'Users' ),
		array( 'entypo-icon entypo-icon-user-add' => 'User Add' ),
		array( 'entypo-icon entypo-icon-video' => 'Video' ),
		array( 'entypo-icon entypo-icon-picture' => 'Picture' ),
		array( 'entypo-icon entypo-icon-camera' => 'Camera' ),
		array( 'entypo-icon entypo-icon-layout' => 'Layout' ),
		array( 'entypo-icon entypo-icon-menu' => 'Menu' ),
		array( 'entypo-icon entypo-icon-check' => 'Check' ),
		array( 'entypo-icon entypo-icon-cancel' => 'Cancel' ),
		array( 'entypo-icon entypo-icon-cancel-circled' => 'Cancel Circled' ),
		array( 'entypo-icon entypo-icon-cancel-squared' => 'Cancel Squared' ),
		array( 'entypo-icon entypo-icon-plus' => 'Plus' ),
		array( 'entypo-icon entypo-icon-plus-circled' => 'Plus Circled' ),
		array( 'entypo-icon entypo-icon-plus-squared' => 'Plus Squared' ),
		array( 'entypo-icon entypo-icon-minus' => 'Minus' ),
		array( 'entypo-icon entypo-icon-minus-circled' => 'Minus Circled' ),
		array( 'entypo-icon entypo-icon-minus-squared' => 'Minus Squared' ),
		array( 'entypo-icon entypo-icon-help' => 'Help' ),
		array( 'entypo-icon entypo-icon-help-circled' => 'Help Circled' ),
		array( 'entypo-icon entypo-icon-info' => 'Info' ),
		array( 'entypo-icon entypo-icon-info-circled' => 'Info Circled' ),
		array( 'entypo-icon entypo-icon-back' => 'Back' ),
		array( 'entypo-icon entypo-icon-home' => 'Home' ),
		array( 'entypo-icon entypo-icon-link' => 'Link' ),
		array( 'entypo-icon entypo-icon-attach' => 'Attach' ),
		array( 'entypo-icon entypo-icon-lock' => 'Lock' ),
		array( 'entypo-icon entypo-icon-lock-open' => 'Lock Open' ),
		array( 'entypo-icon entypo-icon-eye' => 'Eye' ),
		array( 'entypo-icon entypo-icon-tag' => 'Tag' ),
		array( 'entypo-icon entypo-icon-bookmark' => 'Bookmark' ),
		array( 'entypo-icon entypo-icon-bookmarks' => 'Bookmarks' ),
		array( 'entypo-icon entypo-icon-flag' => 'Flag' ),
		array( 'entypo-icon entypo-icon-thumbs-up' => 'Thumbs Up' ),
		array( 'entypo-icon entypo-icon-thumbs-down' => 'Thumbs Down' ),
		array( 'entypo-icon entypo-icon-download' => 'Download' ),
		array( 'entypo-icon entypo-icon-upload' => 'Upload' ),
		array( 'entypo-icon entypo-icon-upload-cloud' => 'Upload Cloud' ),
		array( 'entypo-icon entypo-icon-reply' => 'Reply' ),
		array( 'entypo-icon entypo-icon-reply-all' => 'Reply All' ),
		array( 'entypo-icon entypo-icon-forward' => 'Forward' ),
		array( 'entypo-icon entypo-icon-quote' => 'Quote' ),
		array( 'entypo-icon entypo-icon-code' => 'Code' ),
		array( 'entypo-icon entypo-icon-export' => 'Export' ),
		array( 'entypo-icon entypo-icon-pencil' => 'Pencil' ),
		array( 'entypo-icon entypo-icon-feather' => 'Feather' ),
		array( 'entypo-icon entypo-icon-print' => 'Print' ),
		array( 'entypo-icon entypo-icon-retweet' => 'Retweet' ),
		array( 'entypo-icon entypo-icon-keyboard' => 'Keyboard' ),
		array( 'entypo-icon entypo-icon-comment' => 'Comment' ),
		array( 'entypo-icon entypo-icon-chat' => 'Chat' ),
		array( 'entypo-icon entypo-icon-bell' => 'Bell' ),
		array( 'entypo-icon entypo-icon-attention' => 'Attention' ),
		array( 'entypo-icon entypo-icon-alert' => 'Alert' ),
		array( 'entypo-icon entypo-icon-vcard' => 'Vcard' ),
		array( 'entypo-icon entypo-icon-address' => 'Address' ),
		array( 'entypo-icon entypo-icon-location' => 'Location' ),
		array( 'entypo-icon entypo-icon-map' => 'Map' ),
		array( 'entypo-icon entypo-icon-direction' => 'Direction' ),
		array( 'entypo-icon entypo-icon-compass' => 'Compass' ),
		array( 'entypo-icon entypo-icon-cup' => 'Cup' ),
		array( 'entypo-icon entypo-icon-trash' => 'Trash' ),
		array( 'entypo-icon entypo-icon-doc' => 'Doc' ),
		array( 'entypo-icon entypo-icon-docs' => 'Docs' ),
		array( 'entypo-icon entypo-icon-doc-landscape' => 'Doc Landscape' ),
		array( 'entypo-icon entypo-icon-doc-text' => 'Doc Text' ),
		array( 'entypo-icon entypo-icon-doc-text-inv' => 'Doc Text Inv' ),
		array( 'entypo-icon entypo-icon-newspaper' => 'Newspaper' ),
		array( 'entypo-icon entypo-icon-book-open' => 'Book Open' ),
		array( 'entypo-icon entypo-icon-book' => 'Book' ),
		array( 'entypo-icon entypo-icon-folder' => 'Folder' ),
		array( 'entypo-icon entypo-icon-archive' => 'Archive' ),
		array( 'entypo-icon entypo-icon-box' => 'Box' ),
		array( 'entypo-icon entypo-icon-rss' => 'Rss' ),
		array( 'entypo-icon entypo-icon-phone' => 'Phone' ),
		array( 'entypo-icon entypo-icon-cog' => 'Cog' ),
		array( 'entypo-icon entypo-icon-tools' => 'Tools' ),
		array( 'entypo-icon entypo-icon-share' => 'Share' ),
		array( 'entypo-icon entypo-icon-shareable' => 'Shareable' ),
		array( 'entypo-icon entypo-icon-basket' => 'Basket' ),
		array( 'entypo-icon entypo-icon-bag' => 'Bag' ),
		array( 'entypo-icon entypo-icon-calendar' => 'Calendar' ),
		array( 'entypo-icon entypo-icon-login' => 'Login' ),
		array( 'entypo-icon entypo-icon-logout' => 'Logout' ),
		array( 'entypo-icon entypo-icon-mic' => 'Mic' ),
		array( 'entypo-icon entypo-icon-mute' => 'Mute' ),
		array( 'entypo-icon entypo-icon-sound' => 'Sound' ),
		array( 'entypo-icon entypo-icon-volume' => 'Volume' ),
		array( 'entypo-icon entypo-icon-clock' => 'Clock' ),
		array( 'entypo-icon entypo-icon-hourglass' => 'Hourglass' ),
		array( 'entypo-icon entypo-icon-lamp' => 'Lamp' ),
		array( 'entypo-icon entypo-icon-light-down' => 'Light Down' ),
		array( 'entypo-icon entypo-icon-light-up' => 'Light Up' ),
		array( 'entypo-icon entypo-icon-adjust' => 'Adjust' ),
		array( 'entypo-icon entypo-icon-block' => 'Block' ),
		array( 'entypo-icon entypo-icon-resize-full' => 'Resize Full' ),
		array( 'entypo-icon entypo-icon-resize-small' => 'Resize Small' ),
		array( 'entypo-icon entypo-icon-popup' => 'Popup' ),
		array( 'entypo-icon entypo-icon-publish' => 'Publish' ),
		array( 'entypo-icon entypo-icon-window' => 'Window' ),
		array( 'entypo-icon entypo-icon-arrow-combo' => 'Arrow Combo' ),
		array( 'entypo-icon entypo-icon-down-circled' => 'Down Circled' ),
		array( 'entypo-icon entypo-icon-left-circled' => 'Left Circled' ),
		array( 'entypo-icon entypo-icon-right-circled' => 'Right Circled' ),
		array( 'entypo-icon entypo-icon-up-circled' => 'Up Circled' ),
		array( 'entypo-icon entypo-icon-down-open' => 'Down Open' ),
		array( 'entypo-icon entypo-icon-left-open' => 'Left Open' ),
		array( 'entypo-icon entypo-icon-right-open' => 'Right Open' ),
		array( 'entypo-icon entypo-icon-up-open' => 'Up Open' ),
		array( 'entypo-icon entypo-icon-down-open-mini' => 'Down Open Mini' ),
		array( 'entypo-icon entypo-icon-left-open-mini' => 'Left Open Mini' ),
		array( 'entypo-icon entypo-icon-right-open-mini' => 'Right Open Mini' ),
		array( 'entypo-icon entypo-icon-up-open-mini' => 'Up Open Mini' ),
		array( 'entypo-icon entypo-icon-down-open-big' => 'Down Open Big' ),
		array( 'entypo-icon entypo-icon-left-open-big' => 'Left Open Big' ),
		array( 'entypo-icon entypo-icon-right-open-big' => 'Right Open Big' ),
		array( 'entypo-icon entypo-icon-up-open-big' => 'Up Open Big' ),
		array( 'entypo-icon entypo-icon-down' => 'Down' ),
		array( 'entypo-icon entypo-icon-left' => 'Left' ),
		array( 'entypo-icon entypo-icon-right' => 'Right' ),
		array( 'entypo-icon entypo-icon-up' => 'Up' ),
		array( 'entypo-icon entypo-icon-down-dir' => 'Down Dir' ),
		array( 'entypo-icon entypo-icon-left-dir' => 'Left Dir' ),
		array( 'entypo-icon entypo-icon-right-dir' => 'Right Dir' ),
		array( 'entypo-icon entypo-icon-up-dir' => 'Up Dir' ),
		array( 'entypo-icon entypo-icon-down-bold' => 'Down Bold' ),
		array( 'entypo-icon entypo-icon-left-bold' => 'Left Bold' ),
		array( 'entypo-icon entypo-icon-right-bold' => 'Right Bold' ),
		array( 'entypo-icon entypo-icon-up-bold' => 'Up Bold' ),
		array( 'entypo-icon entypo-icon-down-thin' => 'Down Thin' ),
		array( 'entypo-icon entypo-icon-left-thin' => 'Left Thin' ),
		array( 'entypo-icon entypo-icon-right-thin' => 'Right Thin' ),
		array( 'entypo-icon entypo-icon-up-thin' => 'Up Thin' ),
		array( 'entypo-icon entypo-icon-ccw' => 'Ccw' ),
		array( 'entypo-icon entypo-icon-cw' => 'Cw' ),
		array( 'entypo-icon entypo-icon-arrows-ccw' => 'Arrows Ccw' ),
		array( 'entypo-icon entypo-icon-level-down' => 'Level Down' ),
		array( 'entypo-icon entypo-icon-level-up' => 'Level Up' ),
		array( 'entypo-icon entypo-icon-shuffle' => 'Shuffle' ),
		array( 'entypo-icon entypo-icon-loop' => 'Loop' ),
		array( 'entypo-icon entypo-icon-switch' => 'Switch' ),
		array( 'entypo-icon entypo-icon-play' => 'Play' ),
		array( 'entypo-icon entypo-icon-stop' => 'Stop' ),
		array( 'entypo-icon entypo-icon-pause' => 'Pause' ),
		array( 'entypo-icon entypo-icon-record' => 'Record' ),
		array( 'entypo-icon entypo-icon-to-end' => 'To End' ),
		array( 'entypo-icon entypo-icon-to-start' => 'To Start' ),
		array( 'entypo-icon entypo-icon-fast-forward' => 'Fast Forward' ),
		array( 'entypo-icon entypo-icon-fast-backward' => 'Fast Backward' ),
		array( 'entypo-icon entypo-icon-progress-0' => 'Progress 0' ),
		array( 'entypo-icon entypo-icon-progress-1' => 'Progress 1' ),
		array( 'entypo-icon entypo-icon-progress-2' => 'Progress 2' ),
		array( 'entypo-icon entypo-icon-progress-3' => 'Progress 3' ),
		array( 'entypo-icon entypo-icon-target' => 'Target' ),
		array( 'entypo-icon entypo-icon-palette' => 'Palette' ),
		array( 'entypo-icon entypo-icon-list' => 'List' ),
		array( 'entypo-icon entypo-icon-list-add' => 'List Add' ),
		array( 'entypo-icon entypo-icon-signal' => 'Signal' ),
		array( 'entypo-icon entypo-icon-trophy' => 'Trophy' ),
		array( 'entypo-icon entypo-icon-battery' => 'Battery' ),
		array( 'entypo-icon entypo-icon-back-in-time' => 'Back In Time' ),
		array( 'entypo-icon entypo-icon-monitor' => 'Monitor' ),
		array( 'entypo-icon entypo-icon-mobile' => 'Mobile' ),
		array( 'entypo-icon entypo-icon-network' => 'Network' ),
		array( 'entypo-icon entypo-icon-cd' => 'Cd' ),
		array( 'entypo-icon entypo-icon-inbox' => 'Inbox' ),
		array( 'entypo-icon entypo-icon-install' => 'Install' ),
		array( 'entypo-icon entypo-icon-globe' => 'Globe' ),
		array( 'entypo-icon entypo-icon-cloud' => 'Cloud' ),
		array( 'entypo-icon entypo-icon-cloud-thunder' => 'Cloud Thunder' ),
		array( 'entypo-icon entypo-icon-flash' => 'Flash' ),
		array( 'entypo-icon entypo-icon-moon' => 'Moon' ),
		array( 'entypo-icon entypo-icon-flight' => 'Flight' ),
		array( 'entypo-icon entypo-icon-paper-plane' => 'Paper Plane' ),
		array( 'entypo-icon entypo-icon-leaf' => 'Leaf' ),
		array( 'entypo-icon entypo-icon-lifebuoy' => 'Lifebuoy' ),
		array( 'entypo-icon entypo-icon-mouse' => 'Mouse' ),
		array( 'entypo-icon entypo-icon-briefcase' => 'Briefcase' ),
		array( 'entypo-icon entypo-icon-suitcase' => 'Suitcase' ),
		array( 'entypo-icon entypo-icon-dot' => 'Dot' ),
		array( 'entypo-icon entypo-icon-dot-2' => 'Dot 2' ),
		array( 'entypo-icon entypo-icon-dot-3' => 'Dot 3' ),
		array( 'entypo-icon entypo-icon-brush' => 'Brush' ),
		array( 'entypo-icon entypo-icon-magnet' => 'Magnet' ),
		array( 'entypo-icon entypo-icon-infinity' => 'Infinity' ),
		array( 'entypo-icon entypo-icon-erase' => 'Erase' ),
		array( 'entypo-icon entypo-icon-chart-pie' => 'Chart Pie' ),
		array( 'entypo-icon entypo-icon-chart-line' => 'Chart Line' ),
		array( 'entypo-icon entypo-icon-chart-bar' => 'Chart Bar' ),
		array( 'entypo-icon entypo-icon-chart-area' => 'Chart Area' ),
		array( 'entypo-icon entypo-icon-tape' => 'Tape' ),
		array( 'entypo-icon entypo-icon-graduation-cap' => 'Graduation Cap' ),
		array( 'entypo-icon entypo-icon-language' => 'Language' ),
		array( 'entypo-icon entypo-icon-ticket' => 'Ticket' ),
		array( 'entypo-icon entypo-icon-water' => 'Water' ),
		array( 'entypo-icon entypo-icon-droplet' => 'Droplet' ),
		array( 'entypo-icon entypo-icon-air' => 'Air' ),
		array( 'entypo-icon entypo-icon-credit-card' => 'Credit Card' ),
		array( 'entypo-icon entypo-icon-floppy' => 'Floppy' ),
		array( 'entypo-icon entypo-icon-clipboard' => 'Clipboard' ),
		array( 'entypo-icon entypo-icon-megaphone' => 'Megaphone' ),
		array( 'entypo-icon entypo-icon-database' => 'Database' ),
		array( 'entypo-icon entypo-icon-drive' => 'Drive' ),
		array( 'entypo-icon entypo-icon-bucket' => 'Bucket' ),
		array( 'entypo-icon entypo-icon-thermometer' => 'Thermometer' ),
		array( 'entypo-icon entypo-icon-key' => 'Key' ),
		array( 'entypo-icon entypo-icon-flow-cascade' => 'Flow Cascade' ),
		array( 'entypo-icon entypo-icon-flow-branch' => 'Flow Branch' ),
		array( 'entypo-icon entypo-icon-flow-tree' => 'Flow Tree' ),
		array( 'entypo-icon entypo-icon-flow-line' => 'Flow Line' ),
		array( 'entypo-icon entypo-icon-flow-parallel' => 'Flow Parallel' ),
		array( 'entypo-icon entypo-icon-rocket' => 'Rocket' ),
		array( 'entypo-icon entypo-icon-gauge' => 'Gauge' ),
		array( 'entypo-icon entypo-icon-traffic-cone' => 'Traffic Cone' ),
		array( 'entypo-icon entypo-icon-cc' => 'Cc' ),
		array( 'entypo-icon entypo-icon-cc-by' => 'Cc By' ),
		array( 'entypo-icon entypo-icon-cc-nc' => 'Cc Nc' ),
		array( 'entypo-icon entypo-icon-cc-nc-eu' => 'Cc Nc Eu' ),
		array( 'entypo-icon entypo-icon-cc-nc-jp' => 'Cc Nc Jp' ),
		array( 'entypo-icon entypo-icon-cc-sa' => 'Cc Sa' ),
		array( 'entypo-icon entypo-icon-cc-nd' => 'Cc Nd' ),
		array( 'entypo-icon entypo-icon-cc-pd' => 'Cc Pd' ),
		array( 'entypo-icon entypo-icon-cc-zero' => 'Cc Zero' ),
		array( 'entypo-icon entypo-icon-cc-share' => 'Cc Share' ),
		array( 'entypo-icon entypo-icon-cc-remix' => 'Cc Remix' ),
		array( 'entypo-icon entypo-icon-github' => 'Github' ),
		array( 'entypo-icon entypo-icon-github-circled' => 'Github Circled' ),
		array( 'entypo-icon entypo-icon-flickr' => 'Flickr' ),
		array( 'entypo-icon entypo-icon-flickr-circled' => 'Flickr Circled' ),
		array( 'entypo-icon entypo-icon-vimeo' => 'Vimeo' ),
		array( 'entypo-icon entypo-icon-vimeo-circled' => 'Vimeo Circled' ),
		array( 'entypo-icon entypo-icon-twitter' => 'Twitter' ),
		array( 'entypo-icon entypo-icon-twitter-circled' => 'Twitter Circled' ),
		array( 'entypo-icon entypo-icon-facebook' => 'Facebook' ),
		array( 'entypo-icon entypo-icon-facebook-circled' => 'Facebook Circled' ),
		array( 'entypo-icon entypo-icon-facebook-squared' => 'Facebook Squared' ),
		array( 'entypo-icon entypo-icon-gplus' => 'Gplus' ),
		array( 'entypo-icon entypo-icon-gplus-circled' => 'Gplus Circled' ),
		array( 'entypo-icon entypo-icon-pinterest' => 'Pinterest' ),
		array( 'entypo-icon entypo-icon-pinterest-circled' => 'Pinterest Circled' ),
		array( 'entypo-icon entypo-icon-tumblr' => 'Tumblr' ),
		array( 'entypo-icon entypo-icon-tumblr-circled' => 'Tumblr Circled' ),
		array( 'entypo-icon entypo-icon-linkedin' => 'Linkedin' ),
		array( 'entypo-icon entypo-icon-linkedin-circled' => 'Linkedin Circled' ),
		array( 'entypo-icon entypo-icon-dribbble' => 'Dribbble' ),
		array( 'entypo-icon entypo-icon-dribbble-circled' => 'Dribbble Circled' ),
		array( 'entypo-icon entypo-icon-stumbleupon' => 'Stumbleupon' ),
		array( 'entypo-icon entypo-icon-stumbleupon-circled' => 'Stumbleupon Circled' ),
		array( 'entypo-icon entypo-icon-lastfm' => 'Lastfm' ),
		array( 'entypo-icon entypo-icon-lastfm-circled' => 'Lastfm Circled' ),
		array( 'entypo-icon entypo-icon-rdio' => 'Rdio' ),
		array( 'entypo-icon entypo-icon-rdio-circled' => 'Rdio Circled' ),
		array( 'entypo-icon entypo-icon-spotify' => 'Spotify' ),
		array( 'entypo-icon entypo-icon-spotify-circled' => 'Spotify Circled' ),
		array( 'entypo-icon entypo-icon-qq' => 'Qq' ),
		array( 'entypo-icon entypo-icon-instagrem' => 'Instagrem' ),
		array( 'entypo-icon entypo-icon-dropbox' => 'Dropbox' ),
		array( 'entypo-icon entypo-icon-evernote' => 'Evernote' ),
		array( 'entypo-icon entypo-icon-flattr' => 'Flattr' ),
		array( 'entypo-icon entypo-icon-skype' => 'Skype' ),
		array( 'entypo-icon entypo-icon-skype-circled' => 'Skype Circled' ),
		array( 'entypo-icon entypo-icon-renren' => 'Renren' ),
		array( 'entypo-icon entypo-icon-sina-weibo' => 'Sina Weibo' ),
		array( 'entypo-icon entypo-icon-paypal' => 'Paypal' ),
		array( 'entypo-icon entypo-icon-picasa' => 'Picasa' ),
		array( 'entypo-icon entypo-icon-soundcloud' => 'Soundcloud' ),
		array( 'entypo-icon entypo-icon-mixi' => 'Mixi' ),
		array( 'entypo-icon entypo-icon-behance' => 'Behance' ),
		array( 'entypo-icon entypo-icon-google-circles' => 'Google Circles' ),
		array( 'entypo-icon entypo-icon-vkontakte' => 'Vkontakte' ),
		array( 'entypo-icon entypo-icon-smashing' => 'Smashing' ),
		array( 'entypo-icon entypo-icon-sweden' => 'Sweden' ),
		array( 'entypo-icon entypo-icon-db-shape' => 'Db Shape' ),
		array( 'entypo-icon entypo-icon-logo-db' => 'Logo Db' ),
	);

	return array_merge( $icons, $entypo_icons );
}

add_filter( 'vc_iconpicker-type-linecons', 'vc_iconpicker_type_linecons' );

/**
 * Linecons icons from fontello.com
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @since 4.4
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
function vc_iconpicker_type_linecons( $icons ) {
	$linecons_icons = array(
		array( 'vc_li vc_li-heart' => 'Heart' ),
		array( 'vc_li vc_li-cloud' => 'Cloud' ),
		array( 'vc_li vc_li-star' => 'Star' ),
		array( 'vc_li vc_li-tv' => 'Tv' ),
		array( 'vc_li vc_li-sound' => 'Sound' ),
		array( 'vc_li vc_li-video' => 'Video' ),
		array( 'vc_li vc_li-trash' => 'Trash' ),
		array( 'vc_li vc_li-user' => 'User' ),
		array( 'vc_li vc_li-key' => 'Key' ),
		array( 'vc_li vc_li-search' => 'Search' ),
		array( 'vc_li vc_li-settings' => 'Settings' ),
		array( 'vc_li vc_li-camera' => 'Camera' ),
		array( 'vc_li vc_li-tag' => 'Tag' ),
		array( 'vc_li vc_li-lock' => 'Lock' ),
		array( 'vc_li vc_li-bulb' => 'Bulb' ),
		array( 'vc_li vc_li-pen' => 'Pen' ),
		array( 'vc_li vc_li-diamond' => 'Diamond' ),
		array( 'vc_li vc_li-display' => 'Display' ),
		array( 'vc_li vc_li-location' => 'Location' ),
		array( 'vc_li vc_li-eye' => 'Eye' ),
		array( 'vc_li vc_li-bubble' => 'Bubble' ),
		array( 'vc_li vc_li-stack' => 'Stack' ),
		array( 'vc_li vc_li-cup' => 'Cup' ),
		array( 'vc_li vc_li-phone' => 'Phone' ),
		array( 'vc_li vc_li-news' => 'News' ),
		array( 'vc_li vc_li-mail' => 'Mail' ),
		array( 'vc_li vc_li-like' => 'Like' ),
		array( 'vc_li vc_li-photo' => 'Photo' ),
		array( 'vc_li vc_li-note' => 'Note' ),
		array( 'vc_li vc_li-clock' => 'Clock' ),
		array( 'vc_li vc_li-paperplane' => 'Paperplane' ),
		array( 'vc_li vc_li-params' => 'Params' ),
		array( 'vc_li vc_li-banknote' => 'Banknote' ),
		array( 'vc_li vc_li-data' => 'Data' ),
		array( 'vc_li vc_li-music' => 'Music' ),
		array( 'vc_li vc_li-megaphone' => 'Megaphone' ),
		array( 'vc_li vc_li-study' => 'Study' ),
		array( 'vc_li vc_li-lab' => 'Lab' ),
		array( 'vc_li vc_li-food' => 'Food' ),
		array( 'vc_li vc_li-t-shirt' => 'T Shirt' ),
		array( 'vc_li vc_li-fire' => 'Fire' ),
		array( 'vc_li vc_li-clip' => 'Clip' ),
		array( 'vc_li vc_li-shop' => 'Shop' ),
		array( 'vc_li vc_li-calendar' => 'Calendar' ),
		array( 'vc_li vc_li-vallet' => 'Vallet' ),
		array( 'vc_li vc_li-vynil' => 'Vynil' ),
		array( 'vc_li vc_li-truck' => 'Truck' ),
		array( 'vc_li vc_li-world' => 'World' ),
	);

	return array_merge( $icons, $linecons_icons );
}

add_filter( 'vc_iconpicker-type-monosocial', 'vc_iconpicker_type_monosocial' );

/**
 * monosocial icons from drinchev.github.io/monosocialiconsfont
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @since 4.4
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
function vc_iconpicker_type_monosocial( $icons ) {
	$monosocial = array(
		array( 'vc-mono vc-mono-fivehundredpx' => 'Five Hundred px' ),
		array( 'vc-mono vc-mono-aboutme' => 'About me' ),
		array( 'vc-mono vc-mono-addme' => 'Add me' ),
		array( 'vc-mono vc-mono-amazon' => 'Amazon' ),
		array( 'vc-mono vc-mono-aol' => 'Aol' ),
		array( 'vc-mono vc-mono-appstorealt' => 'App-store-alt' ),
		array( 'vc-mono vc-mono-appstore' => 'Appstore' ),
		array( 'vc-mono vc-mono-apple' => 'Apple' ),
		array( 'vc-mono vc-mono-bebo' => 'Bebo' ),
		array( 'vc-mono vc-mono-behance' => 'Behance' ),
		array( 'vc-mono vc-mono-bing' => 'Bing' ),
		array( 'vc-mono vc-mono-blip' => 'Blip' ),
		array( 'vc-mono vc-mono-blogger' => 'Blogger' ),
		array( 'vc-mono vc-mono-coroflot' => 'Coroflot' ),
		array( 'vc-mono vc-mono-daytum' => 'Daytum' ),
		array( 'vc-mono vc-mono-delicious' => 'Delicious' ),
		array( 'vc-mono vc-mono-designbump' => 'Design bump' ),
		array( 'vc-mono vc-mono-designfloat' => 'Design float' ),
		array( 'vc-mono vc-mono-deviantart' => 'Deviant-art' ),
		array( 'vc-mono vc-mono-diggalt' => 'Digg-alt' ),
		array( 'vc-mono vc-mono-digg' => 'Digg' ),
		array( 'vc-mono vc-mono-dribble' => 'Dribble' ),
		array( 'vc-mono vc-mono-drupal' => 'Drupal' ),
		array( 'vc-mono vc-mono-ebay' => 'Ebay' ),
		array( 'vc-mono vc-mono-email' => 'Email' ),
		array( 'vc-mono vc-mono-emberapp' => 'Ember app' ),
		array( 'vc-mono vc-mono-etsy' => 'Etsy' ),
		array( 'vc-mono vc-mono-facebook' => 'Facebook' ),
		array( 'vc-mono vc-mono-feedburner' => 'Feed burner' ),
		array( 'vc-mono vc-mono-flickr' => 'Flickr' ),
		array( 'vc-mono vc-mono-foodspotting' => 'Food spotting' ),
		array( 'vc-mono vc-mono-forrst' => 'Forrst' ),
		array( 'vc-mono vc-mono-foursquare' => 'Fours quare' ),
		array( 'vc-mono vc-mono-friendsfeed' => 'Friends feed' ),
		array( 'vc-mono vc-mono-friendstar' => 'Friend star' ),
		array( 'vc-mono vc-mono-gdgt' => 'Gdgt' ),
		array( 'vc-mono vc-mono-github' => 'Github' ),
		array( 'vc-mono vc-mono-githubalt' => 'Github-alt' ),
		array( 'vc-mono vc-mono-googlebuzz' => 'Google buzz' ),
		array( 'vc-mono vc-mono-googleplus' => 'Google plus' ),
		array( 'vc-mono vc-mono-googletalk' => 'Google talk' ),
		array( 'vc-mono vc-mono-gowallapin' => 'Gowallapin' ),
		array( 'vc-mono vc-mono-gowalla' => 'Gowalla' ),
		array( 'vc-mono vc-mono-grooveshark' => 'Groove shark' ),
		array( 'vc-mono vc-mono-heart' => 'Heart' ),
		array( 'vc-mono vc-mono-hyves' => 'Hyves' ),
		array( 'vc-mono vc-mono-icondock' => 'Icondock' ),
		array( 'vc-mono vc-mono-icq' => 'Icq' ),
		array( 'vc-mono vc-mono-identica' => 'Identica' ),
		array( 'vc-mono vc-mono-imessage' => 'I message' ),
		array( 'vc-mono vc-mono-itunes' => 'I-tunes' ),
		array( 'vc-mono vc-mono-lastfm' => 'Lastfm' ),
		array( 'vc-mono vc-mono-linkedin' => 'Linkedin' ),
		array( 'vc-mono vc-mono-meetup' => 'Meetup' ),
		array( 'vc-mono vc-mono-metacafe' => 'Metacafe' ),
		array( 'vc-mono vc-mono-mixx' => 'Mixx' ),
		array( 'vc-mono vc-mono-mobileme' => 'Mobile me' ),
		array( 'vc-mono vc-mono-mrwong' => 'Mrwong' ),
		array( 'vc-mono vc-mono-msn' => 'Msn' ),
		array( 'vc-mono vc-mono-myspace' => 'Myspace' ),
		array( 'vc-mono vc-mono-newsvine' => 'Newsvine' ),
		array( 'vc-mono vc-mono-paypal' => 'Paypal' ),
		array( 'vc-mono vc-mono-photobucket' => 'Photo bucket' ),
		array( 'vc-mono vc-mono-picasa' => 'Picasa' ),
		array( 'vc-mono vc-mono-pinterest' => 'Pinterest' ),
		array( 'vc-mono vc-mono-podcast' => 'Podcast' ),
		array( 'vc-mono vc-mono-posterous' => 'Posterous' ),
		array( 'vc-mono vc-mono-qik' => 'Qik' ),
		array( 'vc-mono vc-mono-quora' => 'Quora' ),
		array( 'vc-mono vc-mono-reddit' => 'Reddit' ),
		array( 'vc-mono vc-mono-retweet' => 'Retweet' ),
		array( 'vc-mono vc-mono-rss' => 'Rss' ),
		array( 'vc-mono vc-mono-scribd' => 'Scribd' ),
		array( 'vc-mono vc-mono-sharethis' => 'Sharethis' ),
		array( 'vc-mono vc-mono-skype' => 'Skype' ),
		array( 'vc-mono vc-mono-slashdot' => 'Slashdot' ),
		array( 'vc-mono vc-mono-slideshare' => 'Slideshare' ),
		array( 'vc-mono vc-mono-smugmug' => 'Smugmug' ),
		array( 'vc-mono vc-mono-soundcloud' => 'Soundcloud' ),
		array( 'vc-mono vc-mono-spotify' => 'Spotify' ),
		array( 'vc-mono vc-mono-squidoo' => 'Squidoo' ),
		array( 'vc-mono vc-mono-stackoverflow' => 'Stackoverflow' ),
		array( 'vc-mono vc-mono-star' => 'Star' ),
		array( 'vc-mono vc-mono-stumbleupon' => 'Stumble upon' ),
		array( 'vc-mono vc-mono-technorati' => 'Technorati' ),
		array( 'vc-mono vc-mono-tumblr' => 'Tumblr' ),
		array( 'vc-mono vc-mono-twitterbird' => 'Twitterbird' ),
		array( 'vc-mono vc-mono-twitter' => 'Twitter' ),
		array( 'vc-mono vc-mono-viddler' => 'Viddler' ),
		array( 'vc-mono vc-mono-vimeo' => 'Vimeo' ),
		array( 'vc-mono vc-mono-virb' => 'Virb' ),
		array( 'vc-mono vc-mono-www' => 'Www' ),
		array( 'vc-mono vc-mono-wikipedia' => 'Wikipedia' ),
		array( 'vc-mono vc-mono-windows' => 'Windows' ),
		array( 'vc-mono vc-mono-wordpress' => 'WordPress' ),
		array( 'vc-mono vc-mono-xing' => 'Xing' ),
		array( 'vc-mono vc-mono-yahoobuzz' => 'Yahoo buzz' ),
		array( 'vc-mono vc-mono-yahoo' => 'Yahoo' ),
		array( 'vc-mono vc-mono-yelp' => 'Yelp' ),
		array( 'vc-mono vc-mono-youtube' => 'Youtube' ),
		array( 'vc-mono vc-mono-instagram' => 'Instagram' ),
	);

	return array_merge( $icons, $monosocial );
}

add_filter( 'vc_iconpicker-type-material', 'vc_iconpicker_type_material' );
/**
 * Material icon set from Google
 * @since 5.0
 *
 * @param $icons
 *
 * @return array
 */
function vc_iconpicker_type_material( $icons ) {
	$material = array(
		array( 'vc-material vc-material-3d_rotation' => '3d rotation' ),
		array( 'vc-material vc-material-ac_unit' => 'ac unit' ),
		array( 'vc-material vc-material-alarm' => 'alarm' ),
		array( 'vc-material vc-material-access_alarms' => 'access alarms' ),
		array( 'vc-material vc-material-schedule' => 'schedule' ),
		array( 'vc-material vc-material-accessibility' => 'accessibility' ),
		array( 'vc-material vc-material-accessible' => 'accessible' ),
		array( 'vc-material vc-material-account_balance' => 'account balance' ),
		array( 'vc-material vc-material-account_balance_wallet' => 'account balance wallet' ),
		array( 'vc-material vc-material-account_box' => 'account box' ),
		array( 'vc-material vc-material-account_circle' => 'account circle' ),
		array( 'vc-material vc-material-adb' => 'adb' ),
		array( 'vc-material vc-material-add' => 'add' ),
		array( 'vc-material vc-material-add_a_photo' => 'add a photo' ),
		array( 'vc-material vc-material-alarm_add' => 'alarm add' ),
		array( 'vc-material vc-material-add_alert' => 'add alert' ),
		array( 'vc-material vc-material-add_box' => 'add box' ),
		array( 'vc-material vc-material-add_circle' => 'add circle' ),
		array( 'vc-material vc-material-control_point' => 'control point' ),
		array( 'vc-material vc-material-add_location' => 'add location' ),
		array( 'vc-material vc-material-add_shopping_cart' => 'add shopping cart' ),
		array( 'vc-material vc-material-queue' => 'queue' ),
		array( 'vc-material vc-material-add_to_queue' => 'add to queue' ),
		array( 'vc-material vc-material-adjust' => 'adjust' ),
		array( 'vc-material vc-material-airline_seat_flat' => 'airline seat flat' ),
		array( 'vc-material vc-material-airline_seat_flat_angled' => 'airline seat flat angled' ),
		array( 'vc-material vc-material-airline_seat_individual_suite' => 'airline seat individual suite' ),
		array( 'vc-material vc-material-airline_seat_legroom_extra' => 'airline seat legroom extra' ),
		array( 'vc-material vc-material-airline_seat_legroom_normal' => 'airline seat legroom normal' ),
		array( 'vc-material vc-material-airline_seat_legroom_reduced' => 'airline seat legroom reduced' ),
		array( 'vc-material vc-material-airline_seat_recline_extra' => 'airline seat recline extra' ),
		array( 'vc-material vc-material-airline_seat_recline_normal' => 'airline seat recline normal' ),
		array( 'vc-material vc-material-flight' => 'flight' ),
		array( 'vc-material vc-material-airplanemode_inactive' => 'airplanemode inactive' ),
		array( 'vc-material vc-material-airplay' => 'airplay' ),
		array( 'vc-material vc-material-airport_shuttle' => 'airport shuttle' ),
		array( 'vc-material vc-material-alarm_off' => 'alarm off' ),
		array( 'vc-material vc-material-alarm_on' => 'alarm on' ),
		array( 'vc-material vc-material-album' => 'album' ),
		array( 'vc-material vc-material-all_inclusive' => 'all inclusive' ),
		array( 'vc-material vc-material-all_out' => 'all out' ),
		array( 'vc-material vc-material-android' => 'android' ),
		array( 'vc-material vc-material-announcement' => 'announcement' ),
		array( 'vc-material vc-material-apps' => 'apps' ),
		array( 'vc-material vc-material-archive' => 'archive' ),
		array( 'vc-material vc-material-arrow_back' => 'arrow back' ),
		array( 'vc-material vc-material-arrow_downward' => 'arrow downward' ),
		array( 'vc-material vc-material-arrow_drop_down' => 'arrow drop down' ),
		array( 'vc-material vc-material-arrow_drop_down_circle' => 'arrow drop down circle' ),
		array( 'vc-material vc-material-arrow_drop_up' => 'arrow drop up' ),
		array( 'vc-material vc-material-arrow_forward' => 'arrow forward' ),
		array( 'vc-material vc-material-arrow_upward' => 'arrow upward' ),
		array( 'vc-material vc-material-art_track' => 'art track' ),
		array( 'vc-material vc-material-aspect_ratio' => 'aspect ratio' ),
		array( 'vc-material vc-material-poll' => 'poll' ),
		array( 'vc-material vc-material-assignment' => 'assignment' ),
		array( 'vc-material vc-material-assignment_ind' => 'assignment ind' ),
		array( 'vc-material vc-material-assignment_late' => 'assignment late' ),
		array( 'vc-material vc-material-assignment_return' => 'assignment return' ),
		array( 'vc-material vc-material-assignment_returned' => 'assignment returned' ),
		array( 'vc-material vc-material-assignment_turned_in' => 'assignment turned in' ),
		array( 'vc-material vc-material-assistant' => 'assistant' ),
		array( 'vc-material vc-material-flag' => 'flag' ),
		array( 'vc-material vc-material-attach_file' => 'attach file' ),
		array( 'vc-material vc-material-attach_money' => 'attach money' ),
		array( 'vc-material vc-material-attachment' => 'attachment' ),
		array( 'vc-material vc-material-audiotrack' => 'audiotrack' ),
		array( 'vc-material vc-material-autorenew' => 'autorenew' ),
		array( 'vc-material vc-material-av_timer' => 'av timer' ),
		array( 'vc-material vc-material-backspace' => 'backspace' ),
		array( 'vc-material vc-material-cloud_upload' => 'cloud upload' ),
		array( 'vc-material vc-material-battery_alert' => 'battery alert' ),
		array( 'vc-material vc-material-battery_charging_full' => 'battery charging full' ),
		array( 'vc-material vc-material-battery_std' => 'battery std' ),
		array( 'vc-material vc-material-battery_unknown' => 'battery unknown' ),
		array( 'vc-material vc-material-beach_access' => 'beach access' ),
		array( 'vc-material vc-material-beenhere' => 'beenhere' ),
		array( 'vc-material vc-material-block' => 'block' ),
		array( 'vc-material vc-material-bluetooth' => 'bluetooth' ),
		array( 'vc-material vc-material-bluetooth_searching' => 'bluetooth searching' ),
		array( 'vc-material vc-material-bluetooth_connected' => 'bluetooth connected' ),
		array( 'vc-material vc-material-bluetooth_disabled' => 'bluetooth disabled' ),
		array( 'vc-material vc-material-blur_circular' => 'blur circular' ),
		array( 'vc-material vc-material-blur_linear' => 'blur linear' ),
		array( 'vc-material vc-material-blur_off' => 'blur off' ),
		array( 'vc-material vc-material-blur_on' => 'blur on' ),
		array( 'vc-material vc-material-class' => 'class' ),
		array( 'vc-material vc-material-turned_in' => 'turned in' ),
		array( 'vc-material vc-material-turned_in_not' => 'turned in not' ),
		array( 'vc-material vc-material-border_all' => 'border all' ),
		array( 'vc-material vc-material-border_bottom' => 'border bottom' ),
		array( 'vc-material vc-material-border_clear' => 'border clear' ),
		array( 'vc-material vc-material-border_color' => 'border color' ),
		array( 'vc-material vc-material-border_horizontal' => 'border horizontal' ),
		array( 'vc-material vc-material-border_inner' => 'border inner' ),
		array( 'vc-material vc-material-border_left' => 'border left' ),
		array( 'vc-material vc-material-border_outer' => 'border outer' ),
		array( 'vc-material vc-material-border_right' => 'border right' ),
		array( 'vc-material vc-material-border_style' => 'border style' ),
		array( 'vc-material vc-material-border_top' => 'border top' ),
		array( 'vc-material vc-material-border_vertical' => 'border vertical' ),
		array( 'vc-material vc-material-branding_watermark' => 'branding watermark' ),
		array( 'vc-material vc-material-brightness_1' => 'brightness 1' ),
		array( 'vc-material vc-material-brightness_2' => 'brightness 2' ),
		array( 'vc-material vc-material-brightness_3' => 'brightness 3' ),
		array( 'vc-material vc-material-brightness_4' => 'brightness 4' ),
		array( 'vc-material vc-material-brightness_low' => 'brightness low' ),
		array( 'vc-material vc-material-brightness_medium' => 'brightness medium' ),
		array( 'vc-material vc-material-brightness_high' => 'brightness high' ),
		array( 'vc-material vc-material-brightness_auto' => 'brightness auto' ),
		array( 'vc-material vc-material-broken_image' => 'broken image' ),
		array( 'vc-material vc-material-brush' => 'brush' ),
		array( 'vc-material vc-material-bubble_chart' => 'bubble chart' ),
		array( 'vc-material vc-material-bug_report' => 'bug report' ),
		array( 'vc-material vc-material-build' => 'build' ),
		array( 'vc-material vc-material-burst_mode' => 'burst mode' ),
		array( 'vc-material vc-material-domain' => 'domain' ),
		array( 'vc-material vc-material-business_center' => 'business center' ),
		array( 'vc-material vc-material-cached' => 'cached' ),
		array( 'vc-material vc-material-cake' => 'cake' ),
		array( 'vc-material vc-material-phone' => 'phone' ),
		array( 'vc-material vc-material-call_end' => 'call end' ),
		array( 'vc-material vc-material-call_made' => 'call made' ),
		array( 'vc-material vc-material-merge_type' => 'merge type' ),
		array( 'vc-material vc-material-call_missed' => 'call missed' ),
		array( 'vc-material vc-material-call_missed_outgoing' => 'call missed outgoing' ),
		array( 'vc-material vc-material-call_received' => 'call received' ),
		array( 'vc-material vc-material-call_split' => 'call split' ),
		array( 'vc-material vc-material-call_to_action' => 'call to action' ),
		array( 'vc-material vc-material-camera' => 'camera' ),
		array( 'vc-material vc-material-photo_camera' => 'photo camera' ),
		array( 'vc-material vc-material-camera_enhance' => 'camera enhance' ),
		array( 'vc-material vc-material-camera_front' => 'camera front' ),
		array( 'vc-material vc-material-camera_rear' => 'camera rear' ),
		array( 'vc-material vc-material-camera_roll' => 'camera roll' ),
		array( 'vc-material vc-material-cancel' => 'cancel' ),
		array( 'vc-material vc-material-redeem' => 'redeem' ),
		array( 'vc-material vc-material-card_membership' => 'card membership' ),
		array( 'vc-material vc-material-card_travel' => 'card travel' ),
		array( 'vc-material vc-material-casino' => 'casino' ),
		array( 'vc-material vc-material-cast' => 'cast' ),
		array( 'vc-material vc-material-cast_connected' => 'cast connected' ),
		array( 'vc-material vc-material-center_focus_strong' => 'center focus strong' ),
		array( 'vc-material vc-material-center_focus_weak' => 'center focus weak' ),
		array( 'vc-material vc-material-change_history' => 'change history' ),
		array( 'vc-material vc-material-chat' => 'chat' ),
		array( 'vc-material vc-material-chat_bubble' => 'chat bubble' ),
		array( 'vc-material vc-material-chat_bubble_outline' => 'chat bubble outline' ),
		array( 'vc-material vc-material-check' => 'check' ),
		array( 'vc-material vc-material-check_box' => 'check box' ),
		array( 'vc-material vc-material-check_box_outline_blank' => 'check box outline blank' ),
		array( 'vc-material vc-material-check_circle' => 'check circle' ),
		array( 'vc-material vc-material-navigate_before' => 'navigate before' ),
		array( 'vc-material vc-material-navigate_next' => 'navigate next' ),
		array( 'vc-material vc-material-child_care' => 'child care' ),
		array( 'vc-material vc-material-child_friendly' => 'child friendly' ),
		array( 'vc-material vc-material-chrome_reader_mode' => 'chrome reader mode' ),
		array( 'vc-material vc-material-close' => 'close' ),
		array( 'vc-material vc-material-clear_all' => 'clear all' ),
		array( 'vc-material vc-material-closed_caption' => 'closed caption' ),
		array( 'vc-material vc-material-wb_cloudy' => 'wb cloudy' ),
		array( 'vc-material vc-material-cloud_circle' => 'cloud circle' ),
		array( 'vc-material vc-material-cloud_done' => 'cloud done' ),
		array( 'vc-material vc-material-cloud_download' => 'cloud download' ),
		array( 'vc-material vc-material-cloud_off' => 'cloud off' ),
		array( 'vc-material vc-material-cloud_queue' => 'cloud queue' ),
		array( 'vc-material vc-material-code' => 'code' ),
		array( 'vc-material vc-material-photo_library' => 'photo library' ),
		array( 'vc-material vc-material-collections_bookmark' => 'collections bookmark' ),
		array( 'vc-material vc-material-palette' => 'palette' ),
		array( 'vc-material vc-material-colorize' => 'colorize' ),
		array( 'vc-material vc-material-comment' => 'comment' ),
		array( 'vc-material vc-material-compare' => 'compare' ),
		array( 'vc-material vc-material-compare_arrows' => 'compare arrows' ),
		array( 'vc-material vc-material-laptop' => 'laptop' ),
		array( 'vc-material vc-material-confirmation_number' => 'confirmation number' ),
		array( 'vc-material vc-material-contact_mail' => 'contact mail' ),
		array( 'vc-material vc-material-contact_phone' => 'contact phone' ),
		array( 'vc-material vc-material-contacts' => 'contacts' ),
		array( 'vc-material vc-material-content_copy' => 'content copy' ),
		array( 'vc-material vc-material-content_cut' => 'content cut' ),
		array( 'vc-material vc-material-content_paste' => 'content paste' ),
		array( 'vc-material vc-material-control_point_duplicate' => 'control point duplicate' ),
		array( 'vc-material vc-material-copyright' => 'copyright' ),
		array( 'vc-material vc-material-mode_edit' => 'mode edit' ),
		array( 'vc-material vc-material-create_new_folder' => 'create new folder' ),
		array( 'vc-material vc-material-payment' => 'payment' ),
		array( 'vc-material vc-material-crop' => 'crop' ),
		array( 'vc-material vc-material-crop_16_9' => 'crop 16 9' ),
		array( 'vc-material vc-material-crop_3_2' => 'crop 3 2' ),
		array( 'vc-material vc-material-crop_landscape' => 'crop landscape' ),
		array( 'vc-material vc-material-crop_7_5' => 'crop 7 5' ),
		array( 'vc-material vc-material-crop_din' => 'crop din' ),
		array( 'vc-material vc-material-crop_free' => 'crop free' ),
		array( 'vc-material vc-material-crop_original' => 'crop original' ),
		array( 'vc-material vc-material-crop_portrait' => 'crop portrait' ),
		array( 'vc-material vc-material-crop_rotate' => 'crop rotate' ),
		array( 'vc-material vc-material-crop_square' => 'crop square' ),
		array( 'vc-material vc-material-dashboard' => 'dashboard' ),
		array( 'vc-material vc-material-data_usage' => 'data usage' ),
		array( 'vc-material vc-material-date_range' => 'date range' ),
		array( 'vc-material vc-material-dehaze' => 'dehaze' ),
		array( 'vc-material vc-material-delete' => 'delete' ),
		array( 'vc-material vc-material-delete_forever' => 'delete forever' ),
		array( 'vc-material vc-material-delete_sweep' => 'delete sweep' ),
		array( 'vc-material vc-material-description' => 'description' ),
		array( 'vc-material vc-material-desktop_mac' => 'desktop mac' ),
		array( 'vc-material vc-material-desktop_windows' => 'desktop windows' ),
		array( 'vc-material vc-material-details' => 'details' ),
		array( 'vc-material vc-material-developer_board' => 'developer board' ),
		array( 'vc-material vc-material-developer_mode' => 'developer mode' ),
		array( 'vc-material vc-material-device_hub' => 'device hub' ),
		array( 'vc-material vc-material-phonelink' => 'phonelink' ),
		array( 'vc-material vc-material-devices_other' => 'devices other' ),
		array( 'vc-material vc-material-dialer_sip' => 'dialer sip' ),
		array( 'vc-material vc-material-dialpad' => 'dialpad' ),
		array( 'vc-material vc-material-directions' => 'directions' ),
		array( 'vc-material vc-material-directions_bike' => 'directions bike' ),
		array( 'vc-material vc-material-directions_boat' => 'directions boat' ),
		array( 'vc-material vc-material-directions_bus' => 'directions bus' ),
		array( 'vc-material vc-material-directions_car' => 'directions car' ),
		array( 'vc-material vc-material-directions_railway' => 'directions railway' ),
		array( 'vc-material vc-material-directions_run' => 'directions run' ),
		array( 'vc-material vc-material-directions_transit' => 'directions transit' ),
		array( 'vc-material vc-material-directions_walk' => 'directions walk' ),
		array( 'vc-material vc-material-disc_full' => 'disc full' ),
		array( 'vc-material vc-material-dns' => 'dns' ),
		array( 'vc-material vc-material-not_interested' => 'not interested' ),
		array( 'vc-material vc-material-do_not_disturb_alt' => 'do not disturb alt' ),
		array( 'vc-material vc-material-do_not_disturb_off' => 'do not disturb off' ),
		array( 'vc-material vc-material-remove_circle' => 'remove circle' ),
		array( 'vc-material vc-material-dock' => 'dock' ),
		array( 'vc-material vc-material-done' => 'done' ),
		array( 'vc-material vc-material-done_all' => 'done all' ),
		array( 'vc-material vc-material-donut_large' => 'donut large' ),
		array( 'vc-material vc-material-donut_small' => 'donut small' ),
		array( 'vc-material vc-material-drafts' => 'drafts' ),
		array( 'vc-material vc-material-drag_handle' => 'drag handle' ),
		array( 'vc-material vc-material-time_to_leave' => 'time to leave' ),
		array( 'vc-material vc-material-dvr' => 'dvr' ),
		array( 'vc-material vc-material-edit_location' => 'edit location' ),
		array( 'vc-material vc-material-eject' => 'eject' ),
		array( 'vc-material vc-material-markunread' => 'markunread' ),
		array( 'vc-material vc-material-enhanced_encryption' => 'enhanced encryption' ),
		array( 'vc-material vc-material-equalizer' => 'equalizer' ),
		array( 'vc-material vc-material-error' => 'error' ),
		array( 'vc-material vc-material-error_outline' => 'error outline' ),
		array( 'vc-material vc-material-euro_symbol' => 'euro symbol' ),
		array( 'vc-material vc-material-ev_station' => 'ev station' ),
		array( 'vc-material vc-material-insert_invitation' => 'insert invitation' ),
		array( 'vc-material vc-material-event_available' => 'event available' ),
		array( 'vc-material vc-material-event_busy' => 'event busy' ),
		array( 'vc-material vc-material-event_note' => 'event note' ),
		array( 'vc-material vc-material-event_seat' => 'event seat' ),
		array( 'vc-material vc-material-exit_to_app' => 'exit to app' ),
		array( 'vc-material vc-material-expand_less' => 'expand less' ),
		array( 'vc-material vc-material-expand_more' => 'expand more' ),
		array( 'vc-material vc-material-explicit' => 'explicit' ),
		array( 'vc-material vc-material-explore' => 'explore' ),
		array( 'vc-material vc-material-exposure' => 'exposure' ),
		array( 'vc-material vc-material-exposure_neg_1' => 'exposure neg 1' ),
		array( 'vc-material vc-material-exposure_neg_2' => 'exposure neg 2' ),
		array( 'vc-material vc-material-exposure_plus_1' => 'exposure plus 1' ),
		array( 'vc-material vc-material-exposure_plus_2' => 'exposure plus 2' ),
		array( 'vc-material vc-material-exposure_zero' => 'exposure zero' ),
		array( 'vc-material vc-material-extension' => 'extension' ),
		array( 'vc-material vc-material-face' => 'face' ),
		array( 'vc-material vc-material-fast_forward' => 'fast forward' ),
		array( 'vc-material vc-material-fast_rewind' => 'fast rewind' ),
		array( 'vc-material vc-material-favorite' => 'favorite' ),
		array( 'vc-material vc-material-favorite_border' => 'favorite border' ),
		array( 'vc-material vc-material-featured_play_list' => 'featured play list' ),
		array( 'vc-material vc-material-featured_video' => 'featured video' ),
		array( 'vc-material vc-material-sms_failed' => 'sms failed' ),
		array( 'vc-material vc-material-fiber_dvr' => 'fiber dvr' ),
		array( 'vc-material vc-material-fiber_manual_record' => 'fiber manual record' ),
		array( 'vc-material vc-material-fiber_new' => 'fiber new' ),
		array( 'vc-material vc-material-fiber_pin' => 'fiber pin' ),
		array( 'vc-material vc-material-fiber_smart_record' => 'fiber smart record' ),
		array( 'vc-material vc-material-get_app' => 'get app' ),
		array( 'vc-material vc-material-file_upload' => 'file upload' ),
		array( 'vc-material vc-material-filter' => 'filter' ),
		array( 'vc-material vc-material-filter_1' => 'filter 1' ),
		array( 'vc-material vc-material-filter_2' => 'filter 2' ),
		array( 'vc-material vc-material-filter_3' => 'filter 3' ),
		array( 'vc-material vc-material-filter_4' => 'filter 4' ),
		array( 'vc-material vc-material-filter_5' => 'filter 5' ),
		array( 'vc-material vc-material-filter_6' => 'filter 6' ),
		array( 'vc-material vc-material-filter_7' => 'filter 7' ),
		array( 'vc-material vc-material-filter_8' => 'filter 8' ),
		array( 'vc-material vc-material-filter_9' => 'filter 9' ),
		array( 'vc-material vc-material-filter_9_plus' => 'filter 9 plus' ),
		array( 'vc-material vc-material-filter_b_and_w' => 'filter b and w' ),
		array( 'vc-material vc-material-filter_center_focus' => 'filter center focus' ),
		array( 'vc-material vc-material-filter_drama' => 'filter drama' ),
		array( 'vc-material vc-material-filter_frames' => 'filter frames' ),
		array( 'vc-material vc-material-terrain' => 'terrain' ),
		array( 'vc-material vc-material-filter_list' => 'filter list' ),
		array( 'vc-material vc-material-filter_none' => 'filter none' ),
		array( 'vc-material vc-material-filter_tilt_shift' => 'filter tilt shift' ),
		array( 'vc-material vc-material-filter_vintage' => 'filter vintage' ),
		array( 'vc-material vc-material-find_in_page' => 'find in page' ),
		array( 'vc-material vc-material-find_replace' => 'find replace' ),
		array( 'vc-material vc-material-fingerprint' => 'fingerprint' ),
		array( 'vc-material vc-material-first_page' => 'first page' ),
		array( 'vc-material vc-material-fitness_center' => 'fitness center' ),
		array( 'vc-material vc-material-flare' => 'flare' ),
		array( 'vc-material vc-material-flash_auto' => 'flash auto' ),
		array( 'vc-material vc-material-flash_off' => 'flash off' ),
		array( 'vc-material vc-material-flash_on' => 'flash on' ),
		array( 'vc-material vc-material-flight_land' => 'flight land' ),
		array( 'vc-material vc-material-flight_takeoff' => 'flight takeoff' ),
		array( 'vc-material vc-material-flip' => 'flip' ),
		array( 'vc-material vc-material-flip_to_back' => 'flip to back' ),
		array( 'vc-material vc-material-flip_to_front' => 'flip to front' ),
		array( 'vc-material vc-material-folder' => 'folder' ),
		array( 'vc-material vc-material-folder_open' => 'folder open' ),
		array( 'vc-material vc-material-folder_shared' => 'folder shared' ),
		array( 'vc-material vc-material-folder_special' => 'folder special' ),
		array( 'vc-material vc-material-font_download' => 'font download' ),
		array( 'vc-material vc-material-format_align_center' => 'format align center' ),
		array( 'vc-material vc-material-format_align_justify' => 'format align justify' ),
		array( 'vc-material vc-material-format_align_left' => 'format align left' ),
		array( 'vc-material vc-material-format_align_right' => 'format align right' ),
		array( 'vc-material vc-material-format_bold' => 'format bold' ),
		array( 'vc-material vc-material-format_clear' => 'format clear' ),
		array( 'vc-material vc-material-format_color_fill' => 'format color fill' ),
		array( 'vc-material vc-material-format_color_reset' => 'format color reset' ),
		array( 'vc-material vc-material-format_color_text' => 'format color text' ),
		array( 'vc-material vc-material-format_indent_decrease' => 'format indent decrease' ),
		array( 'vc-material vc-material-format_indent_increase' => 'format indent increase' ),
		array( 'vc-material vc-material-format_italic' => 'format italic' ),
		array( 'vc-material vc-material-format_line_spacing' => 'format line spacing' ),
		array( 'vc-material vc-material-format_list_bulleted' => 'format list bulleted' ),
		array( 'vc-material vc-material-format_list_numbered' => 'format list numbered' ),
		array( 'vc-material vc-material-format_paint' => 'format paint' ),
		array( 'vc-material vc-material-format_quote' => 'format quote' ),
		array( 'vc-material vc-material-format_shapes' => 'format shapes' ),
		array( 'vc-material vc-material-format_size' => 'format size' ),
		array( 'vc-material vc-material-format_strikethrough' => 'format strikethrough' ),
		array( 'vc-material vc-material-format_textdirection_l_to_r' => 'format textdirection l to r' ),
		array( 'vc-material vc-material-format_textdirection_r_to_l' => 'format textdirection r to l' ),
		array( 'vc-material vc-material-format_underlined' => 'format underlined' ),
		array( 'vc-material vc-material-question_answer' => 'question answer' ),
		array( 'vc-material vc-material-forward' => 'forward' ),
		array( 'vc-material vc-material-forward_10' => 'forward 10' ),
		array( 'vc-material vc-material-forward_30' => 'forward 30' ),
		array( 'vc-material vc-material-forward_5' => 'forward 5' ),
		array( 'vc-material vc-material-free_breakfast' => 'free breakfast' ),
		array( 'vc-material vc-material-fullscreen' => 'fullscreen' ),
		array( 'vc-material vc-material-fullscreen_exit' => 'fullscreen exit' ),
		array( 'vc-material vc-material-functions' => 'functions' ),
		array( 'vc-material vc-material-g_translate' => 'g translate' ),
		array( 'vc-material vc-material-games' => 'games' ),
		array( 'vc-material vc-material-gavel' => 'gavel' ),
		array( 'vc-material vc-material-gesture' => 'gesture' ),
		array( 'vc-material vc-material-gif' => 'gif' ),
		array( 'vc-material vc-material-goat' => 'goat' ),
		array( 'vc-material vc-material-golf_course' => 'golf course' ),
		array( 'vc-material vc-material-my_location' => 'my location' ),
		array( 'vc-material vc-material-location_searching' => 'location searching' ),
		array( 'vc-material vc-material-location_disabled' => 'location disabled' ),
		array( 'vc-material vc-material-star' => 'star' ),
		array( 'vc-material vc-material-gradient' => 'gradient' ),
		array( 'vc-material vc-material-grain' => 'grain' ),
		array( 'vc-material vc-material-graphic_eq' => 'graphic eq' ),
		array( 'vc-material vc-material-grid_off' => 'grid off' ),
		array( 'vc-material vc-material-grid_on' => 'grid on' ),
		array( 'vc-material vc-material-people' => 'people' ),
		array( 'vc-material vc-material-group_add' => 'group add' ),
		array( 'vc-material vc-material-group_work' => 'group work' ),
		array( 'vc-material vc-material-hd' => 'hd' ),
		array( 'vc-material vc-material-hdr_off' => 'hdr off' ),
		array( 'vc-material vc-material-hdr_on' => 'hdr on' ),
		array( 'vc-material vc-material-hdr_strong' => 'hdr strong' ),
		array( 'vc-material vc-material-hdr_weak' => 'hdr weak' ),
		array( 'vc-material vc-material-headset' => 'headset' ),
		array( 'vc-material vc-material-headset_mic' => 'headset mic' ),
		array( 'vc-material vc-material-healing' => 'healing' ),
		array( 'vc-material vc-material-hearing' => 'hearing' ),
		array( 'vc-material vc-material-help' => 'help' ),
		array( 'vc-material vc-material-help_outline' => 'help outline' ),
		array( 'vc-material vc-material-high_quality' => 'high quality' ),
		array( 'vc-material vc-material-highlight' => 'highlight' ),
		array( 'vc-material vc-material-highlight_off' => 'highlight off' ),
		array( 'vc-material vc-material-restore' => 'restore' ),
		array( 'vc-material vc-material-home' => 'home' ),
		array( 'vc-material vc-material-hot_tub' => 'hot tub' ),
		array( 'vc-material vc-material-local_hotel' => 'local hotel' ),
		array( 'vc-material vc-material-hourglass_empty' => 'hourglass empty' ),
		array( 'vc-material vc-material-hourglass_full' => 'hourglass full' ),
		array( 'vc-material vc-material-http' => 'http' ),
		array( 'vc-material vc-material-lock' => 'lock' ),
		array( 'vc-material vc-material-photo' => 'photo' ),
		array( 'vc-material vc-material-image_aspect_ratio' => 'image aspect ratio' ),
		array( 'vc-material vc-material-import_contacts' => 'import contacts' ),
		array( 'vc-material vc-material-import_export' => 'import export' ),
		array( 'vc-material vc-material-important_devices' => 'important devices' ),
		array( 'vc-material vc-material-inbox' => 'inbox' ),
		array( 'vc-material vc-material-indeterminate_check_box' => 'indeterminate check box' ),
		array( 'vc-material vc-material-info' => 'info' ),
		array( 'vc-material vc-material-info_outline' => 'info outline' ),
		array( 'vc-material vc-material-input' => 'input' ),
		array( 'vc-material vc-material-insert_comment' => 'insert comment' ),
		array( 'vc-material vc-material-insert_drive_file' => 'insert drive file' ),
		array( 'vc-material vc-material-tag_faces' => 'tag faces' ),
		array( 'vc-material vc-material-link' => 'link' ),
		array( 'vc-material vc-material-invert_colors' => 'invert colors' ),
		array( 'vc-material vc-material-invert_colors_off' => 'invert colors off' ),
		array( 'vc-material vc-material-iso' => 'iso' ),
		array( 'vc-material vc-material-keyboard' => 'keyboard' ),
		array( 'vc-material vc-material-keyboard_arrow_down' => 'keyboard arrow down' ),
		array( 'vc-material vc-material-keyboard_arrow_left' => 'keyboard arrow left' ),
		array( 'vc-material vc-material-keyboard_arrow_right' => 'keyboard arrow right' ),
		array( 'vc-material vc-material-keyboard_arrow_up' => 'keyboard arrow up' ),
		array( 'vc-material vc-material-keyboard_backspace' => 'keyboard backspace' ),
		array( 'vc-material vc-material-keyboard_capslock' => 'keyboard capslock' ),
		array( 'vc-material vc-material-keyboard_hide' => 'keyboard hide' ),
		array( 'vc-material vc-material-keyboard_return' => 'keyboard return' ),
		array( 'vc-material vc-material-keyboard_tab' => 'keyboard tab' ),
		array( 'vc-material vc-material-keyboard_voice' => 'keyboard voice' ),
		array( 'vc-material vc-material-kitchen' => 'kitchen' ),
		array( 'vc-material vc-material-label' => 'label' ),
		array( 'vc-material vc-material-label_outline' => 'label outline' ),
		array( 'vc-material vc-material-language' => 'language' ),
		array( 'vc-material vc-material-laptop_chromebook' => 'laptop chromebook' ),
		array( 'vc-material vc-material-laptop_mac' => 'laptop mac' ),
		array( 'vc-material vc-material-laptop_windows' => 'laptop windows' ),
		array( 'vc-material vc-material-last_page' => 'last page' ),
		array( 'vc-material vc-material-open_in_new' => 'open in new' ),
		array( 'vc-material vc-material-layers' => 'layers' ),
		array( 'vc-material vc-material-layers_clear' => 'layers clear' ),
		array( 'vc-material vc-material-leak_add' => 'leak add' ),
		array( 'vc-material vc-material-leak_remove' => 'leak remove' ),
		array( 'vc-material vc-material-lens' => 'lens' ),
		array( 'vc-material vc-material-library_books' => 'library books' ),
		array( 'vc-material vc-material-library_music' => 'library music' ),
		array( 'vc-material vc-material-lightbulb_outline' => 'lightbulb outline' ),
		array( 'vc-material vc-material-line_style' => 'line style' ),
		array( 'vc-material vc-material-line_weight' => 'line weight' ),
		array( 'vc-material vc-material-linear_scale' => 'linear scale' ),
		array( 'vc-material vc-material-linked_camera' => 'linked camera' ),
		array( 'vc-material vc-material-list' => 'list' ),
		array( 'vc-material vc-material-live_help' => 'live help' ),
		array( 'vc-material vc-material-live_tv' => 'live tv' ),
		array( 'vc-material vc-material-local_play' => 'local play' ),
		array( 'vc-material vc-material-local_airport' => 'local airport' ),
		array( 'vc-material vc-material-local_atm' => 'local atm' ),
		array( 'vc-material vc-material-local_bar' => 'local bar' ),
		array( 'vc-material vc-material-local_cafe' => 'local cafe' ),
		array( 'vc-material vc-material-local_car_wash' => 'local car wash' ),
		array( 'vc-material vc-material-local_convenience_store' => 'local convenience store' ),
		array( 'vc-material vc-material-restaurant_menu' => 'restaurant menu' ),
		array( 'vc-material vc-material-local_drink' => 'local drink' ),
		array( 'vc-material vc-material-local_florist' => 'local florist' ),
		array( 'vc-material vc-material-local_gas_station' => 'local gas station' ),
		array( 'vc-material vc-material-shopping_cart' => 'shopping cart' ),
		array( 'vc-material vc-material-local_hospital' => 'local hospital' ),
		array( 'vc-material vc-material-local_laundry_service' => 'local laundry service' ),
		array( 'vc-material vc-material-local_library' => 'local library' ),
		array( 'vc-material vc-material-local_mall' => 'local mall' ),
		array( 'vc-material vc-material-theaters' => 'theaters' ),
		array( 'vc-material vc-material-local_offer' => 'local offer' ),
		array( 'vc-material vc-material-local_parking' => 'local parking' ),
		array( 'vc-material vc-material-local_pharmacy' => 'local pharmacy' ),
		array( 'vc-material vc-material-local_pizza' => 'local pizza' ),
		array( 'vc-material vc-material-print' => 'print' ),
		array( 'vc-material vc-material-local_shipping' => 'local shipping' ),
		array( 'vc-material vc-material-local_taxi' => 'local taxi' ),
		array( 'vc-material vc-material-location_city' => 'location city' ),
		array( 'vc-material vc-material-location_off' => 'location off' ),
		array( 'vc-material vc-material-room' => 'room' ),
		array( 'vc-material vc-material-lock_open' => 'lock open' ),
		array( 'vc-material vc-material-lock_outline' => 'lock outline' ),
		array( 'vc-material vc-material-looks' => 'looks' ),
		array( 'vc-material vc-material-looks_3' => 'looks 3' ),
		array( 'vc-material vc-material-looks_4' => 'looks 4' ),
		array( 'vc-material vc-material-looks_5' => 'looks 5' ),
		array( 'vc-material vc-material-looks_6' => 'looks 6' ),
		array( 'vc-material vc-material-looks_one' => 'looks one' ),
		array( 'vc-material vc-material-looks_two' => 'looks two' ),
		array( 'vc-material vc-material-sync' => 'sync' ),
		array( 'vc-material vc-material-loupe' => 'loupe' ),
		array( 'vc-material vc-material-low_priority' => 'low priority' ),
		array( 'vc-material vc-material-loyalty' => 'loyalty' ),
		array( 'vc-material vc-material-mail_outline' => 'mail outline' ),
		array( 'vc-material vc-material-map' => 'map' ),
		array( 'vc-material vc-material-markunread_mailbox' => 'markunread mailbox' ),
		array( 'vc-material vc-material-memory' => 'memory' ),
		array( 'vc-material vc-material-menu' => 'menu' ),
		array( 'vc-material vc-material-message' => 'message' ),
		array( 'vc-material vc-material-mic' => 'mic' ),
		array( 'vc-material vc-material-mic_none' => 'mic none' ),
		array( 'vc-material vc-material-mic_off' => 'mic off' ),
		array( 'vc-material vc-material-mms' => 'mms' ),
		array( 'vc-material vc-material-mode_comment' => 'mode comment' ),
		array( 'vc-material vc-material-monetization_on' => 'monetization on' ),
		array( 'vc-material vc-material-money_off' => 'money off' ),
		array( 'vc-material vc-material-monochrome_photos' => 'monochrome photos' ),
		array( 'vc-material vc-material-mood_bad' => 'mood bad' ),
		array( 'vc-material vc-material-more' => 'more' ),
		array( 'vc-material vc-material-more_horiz' => 'more horiz' ),
		array( 'vc-material vc-material-more_vert' => 'more vert' ),
		array( 'vc-material vc-material-motorcycle' => 'motorcycle' ),
		array( 'vc-material vc-material-mouse' => 'mouse' ),
		array( 'vc-material vc-material-move_to_inbox' => 'move to inbox' ),
		array( 'vc-material vc-material-movie_creation' => 'movie creation' ),
		array( 'vc-material vc-material-movie_filter' => 'movie filter' ),
		array( 'vc-material vc-material-multiline_chart' => 'multiline chart' ),
		array( 'vc-material vc-material-music_note' => 'music note' ),
		array( 'vc-material vc-material-music_video' => 'music video' ),
		array( 'vc-material vc-material-nature' => 'nature' ),
		array( 'vc-material vc-material-nature_people' => 'nature people' ),
		array( 'vc-material vc-material-navigation' => 'navigation' ),
		array( 'vc-material vc-material-near_me' => 'near me' ),
		array( 'vc-material vc-material-network_cell' => 'network cell' ),
		array( 'vc-material vc-material-network_check' => 'network check' ),
		array( 'vc-material vc-material-network_locked' => 'network locked' ),
		array( 'vc-material vc-material-network_wifi' => 'network wifi' ),
		array( 'vc-material vc-material-new_releases' => 'new releases' ),
		array( 'vc-material vc-material-next_week' => 'next week' ),
		array( 'vc-material vc-material-nfc' => 'nfc' ),
		array( 'vc-material vc-material-no_encryption' => 'no encryption' ),
		array( 'vc-material vc-material-signal_cellular_no_sim' => 'signal cellular no sim' ),
		array( 'vc-material vc-material-note' => 'note' ),
		array( 'vc-material vc-material-note_add' => 'note add' ),
		array( 'vc-material vc-material-notifications' => 'notifications' ),
		array( 'vc-material vc-material-notifications_active' => 'notifications active' ),
		array( 'vc-material vc-material-notifications_none' => 'notifications none' ),
		array( 'vc-material vc-material-notifications_off' => 'notifications off' ),
		array( 'vc-material vc-material-notifications_paused' => 'notifications paused' ),
		array( 'vc-material vc-material-offline_pin' => 'offline pin' ),
		array( 'vc-material vc-material-ondemand_video' => 'ondemand video' ),
		array( 'vc-material vc-material-opacity' => 'opacity' ),
		array( 'vc-material vc-material-open_in_browser' => 'open in browser' ),
		array( 'vc-material vc-material-open_with' => 'open with' ),
		array( 'vc-material vc-material-pages' => 'pages' ),
		array( 'vc-material vc-material-pageview' => 'pageview' ),
		array( 'vc-material vc-material-pan_tool' => 'pan tool' ),
		array( 'vc-material vc-material-panorama' => 'panorama' ),
		array( 'vc-material vc-material-radio_button_unchecked' => 'radio button unchecked' ),
		array( 'vc-material vc-material-panorama_horizontal' => 'panorama horizontal' ),
		array( 'vc-material vc-material-panorama_vertical' => 'panorama vertical' ),
		array( 'vc-material vc-material-panorama_wide_angle' => 'panorama wide angle' ),
		array( 'vc-material vc-material-party_mode' => 'party mode' ),
		array( 'vc-material vc-material-pause' => 'pause' ),
		array( 'vc-material vc-material-pause_circle_filled' => 'pause circle filled' ),
		array( 'vc-material vc-material-pause_circle_outline' => 'pause circle outline' ),
		array( 'vc-material vc-material-people_outline' => 'people outline' ),
		array( 'vc-material vc-material-perm_camera_mic' => 'perm camera mic' ),
		array( 'vc-material vc-material-perm_contact_calendar' => 'perm contact calendar' ),
		array( 'vc-material vc-material-perm_data_setting' => 'perm data setting' ),
		array( 'vc-material vc-material-perm_device_information' => 'perm device information' ),
		array( 'vc-material vc-material-person_outline' => 'person outline' ),
		array( 'vc-material vc-material-perm_media' => 'perm media' ),
		array( 'vc-material vc-material-perm_phone_msg' => 'perm phone msg' ),
		array( 'vc-material vc-material-perm_scan_wifi' => 'perm scan wifi' ),
		array( 'vc-material vc-material-person' => 'person' ),
		array( 'vc-material vc-material-person_add' => 'person add' ),
		array( 'vc-material vc-material-person_pin' => 'person pin' ),
		array( 'vc-material vc-material-person_pin_circle' => 'person pin circle' ),
		array( 'vc-material vc-material-personal_video' => 'personal video' ),
		array( 'vc-material vc-material-pets' => 'pets' ),
		array( 'vc-material vc-material-phone_android' => 'phone android' ),
		array( 'vc-material vc-material-phone_bluetooth_speaker' => 'phone bluetooth speaker' ),
		array( 'vc-material vc-material-phone_forwarded' => 'phone forwarded' ),
		array( 'vc-material vc-material-phone_in_talk' => 'phone in talk' ),
		array( 'vc-material vc-material-phone_iphone' => 'phone iphone' ),
		array( 'vc-material vc-material-phone_locked' => 'phone locked' ),
		array( 'vc-material vc-material-phone_missed' => 'phone missed' ),
		array( 'vc-material vc-material-phone_paused' => 'phone paused' ),
		array( 'vc-material vc-material-phonelink_erase' => 'phonelink erase' ),
		array( 'vc-material vc-material-phonelink_lock' => 'phonelink lock' ),
		array( 'vc-material vc-material-phonelink_off' => 'phonelink off' ),
		array( 'vc-material vc-material-phonelink_ring' => 'phonelink ring' ),
		array( 'vc-material vc-material-phonelink_setup' => 'phonelink setup' ),
		array( 'vc-material vc-material-photo_album' => 'photo album' ),
		array( 'vc-material vc-material-photo_filter' => 'photo filter' ),
		array( 'vc-material vc-material-photo_size_select_actual' => 'photo size select actual' ),
		array( 'vc-material vc-material-photo_size_select_large' => 'photo size select large' ),
		array( 'vc-material vc-material-photo_size_select_small' => 'photo size select small' ),
		array( 'vc-material vc-material-picture_as_pdf' => 'picture as pdf' ),
		array( 'vc-material vc-material-picture_in_picture' => 'picture in picture' ),
		array( 'vc-material vc-material-picture_in_picture_alt' => 'picture in picture alt' ),
		array( 'vc-material vc-material-pie_chart' => 'pie chart' ),
		array( 'vc-material vc-material-pie_chart_outlined' => 'pie chart outlined' ),
		array( 'vc-material vc-material-pin_drop' => 'pin drop' ),
		array( 'vc-material vc-material-play_arrow' => 'play arrow' ),
		array( 'vc-material vc-material-play_circle_filled' => 'play circle filled' ),
		array( 'vc-material vc-material-play_circle_outline' => 'play circle outline' ),
		array( 'vc-material vc-material-play_for_work' => 'play for work' ),
		array( 'vc-material vc-material-playlist_add' => 'playlist add' ),
		array( 'vc-material vc-material-playlist_add_check' => 'playlist add check' ),
		array( 'vc-material vc-material-playlist_play' => 'playlist play' ),
		array( 'vc-material vc-material-plus_one' => 'plus one' ),
		array( 'vc-material vc-material-polymer' => 'polymer' ),
		array( 'vc-material vc-material-pool' => 'pool' ),
		array( 'vc-material vc-material-portable_wifi_off' => 'portable wifi off' ),
		array( 'vc-material vc-material-portrait' => 'portrait' ),
		array( 'vc-material vc-material-power' => 'power' ),
		array( 'vc-material vc-material-power_input' => 'power input' ),
		array( 'vc-material vc-material-power_settings_new' => 'power settings new' ),
		array( 'vc-material vc-material-pregnant_woman' => 'pregnant woman' ),
		array( 'vc-material vc-material-present_to_all' => 'present to all' ),
		array( 'vc-material vc-material-priority_high' => 'priority high' ),
		array( 'vc-material vc-material-public' => 'public' ),
		array( 'vc-material vc-material-publish' => 'publish' ),
		array( 'vc-material vc-material-queue_music' => 'queue music' ),
		array( 'vc-material vc-material-queue_play_next' => 'queue play next' ),
		array( 'vc-material vc-material-radio' => 'radio' ),
		array( 'vc-material vc-material-radio_button_checked' => 'radio button checked' ),
		array( 'vc-material vc-material-rate_review' => 'rate review' ),
		array( 'vc-material vc-material-receipt' => 'receipt' ),
		array( 'vc-material vc-material-recent_actors' => 'recent actors' ),
		array( 'vc-material vc-material-record_voice_over' => 'record voice over' ),
		array( 'vc-material vc-material-redo' => 'redo' ),
		array( 'vc-material vc-material-refresh' => 'refresh' ),
		array( 'vc-material vc-material-remove' => 'remove' ),
		array( 'vc-material vc-material-remove_circle_outline' => 'remove circle outline' ),
		array( 'vc-material vc-material-remove_from_queue' => 'remove from queue' ),
		array( 'vc-material vc-material-visibility' => 'visibility' ),
		array( 'vc-material vc-material-remove_shopping_cart' => 'remove shopping cart' ),
		array( 'vc-material vc-material-reorder' => 'reorder' ),
		array( 'vc-material vc-material-repeat' => 'repeat' ),
		array( 'vc-material vc-material-repeat_one' => 'repeat one' ),
		array( 'vc-material vc-material-replay' => 'replay' ),
		array( 'vc-material vc-material-replay_10' => 'replay 10' ),
		array( 'vc-material vc-material-replay_30' => 'replay 30' ),
		array( 'vc-material vc-material-replay_5' => 'replay 5' ),
		array( 'vc-material vc-material-reply' => 'reply' ),
		array( 'vc-material vc-material-reply_all' => 'reply all' ),
		array( 'vc-material vc-material-report' => 'report' ),
		array( 'vc-material vc-material-warning' => 'warning' ),
		array( 'vc-material vc-material-restaurant' => 'restaurant' ),
		array( 'vc-material vc-material-restore_page' => 'restore page' ),
		array( 'vc-material vc-material-ring_volume' => 'ring volume' ),
		array( 'vc-material vc-material-room_service' => 'room service' ),
		array( 'vc-material vc-material-rotate_90_degrees_ccw' => 'rotate 90 degrees ccw' ),
		array( 'vc-material vc-material-rotate_left' => 'rotate left' ),
		array( 'vc-material vc-material-rotate_right' => 'rotate right' ),
		array( 'vc-material vc-material-rounded_corner' => 'rounded corner' ),
		array( 'vc-material vc-material-router' => 'router' ),
		array( 'vc-material vc-material-rowing' => 'rowing' ),
		array( 'vc-material vc-material-rss_feed' => 'rss feed' ),
		array( 'vc-material vc-material-rv_hookup' => 'rv hookup' ),
		array( 'vc-material vc-material-satellite' => 'satellite' ),
		array( 'vc-material vc-material-save' => 'save' ),
		array( 'vc-material vc-material-scanner' => 'scanner' ),
		array( 'vc-material vc-material-school' => 'school' ),
		array( 'vc-material vc-material-screen_lock_landscape' => 'screen lock landscape' ),
		array( 'vc-material vc-material-screen_lock_portrait' => 'screen lock portrait' ),
		array( 'vc-material vc-material-screen_lock_rotation' => 'screen lock rotation' ),
		array( 'vc-material vc-material-screen_rotation' => 'screen rotation' ),
		array( 'vc-material vc-material-screen_share' => 'screen share' ),
		array( 'vc-material vc-material-sd_storage' => 'sd storage' ),
		array( 'vc-material vc-material-search' => 'search' ),
		array( 'vc-material vc-material-security' => 'security' ),
		array( 'vc-material vc-material-select_all' => 'select all' ),
		array( 'vc-material vc-material-send' => 'send' ),
		array( 'vc-material vc-material-sentiment_dissatisfied' => 'sentiment dissatisfied' ),
		array( 'vc-material vc-material-sentiment_neutral' => 'sentiment neutral' ),
		array( 'vc-material vc-material-sentiment_satisfied' => 'sentiment satisfied' ),
		array( 'vc-material vc-material-sentiment_very_dissatisfied' => 'sentiment very dissatisfied' ),
		array( 'vc-material vc-material-sentiment_very_satisfied' => 'sentiment very satisfied' ),
		array( 'vc-material vc-material-settings' => 'settings' ),
		array( 'vc-material vc-material-settings_applications' => 'settings applications' ),
		array( 'vc-material vc-material-settings_backup_restore' => 'settings backup restore' ),
		array( 'vc-material vc-material-settings_bluetooth' => 'settings bluetooth' ),
		array( 'vc-material vc-material-settings_brightness' => 'settings brightness' ),
		array( 'vc-material vc-material-settings_cell' => 'settings cell' ),
		array( 'vc-material vc-material-settings_ethernet' => 'settings ethernet' ),
		array( 'vc-material vc-material-settings_input_antenna' => 'settings input antenna' ),
		array( 'vc-material vc-material-settings_input_composite' => 'settings input composite' ),
		array( 'vc-material vc-material-settings_input_hdmi' => 'settings input hdmi' ),
		array( 'vc-material vc-material-settings_input_svideo' => 'settings input svideo' ),
		array( 'vc-material vc-material-settings_overscan' => 'settings overscan' ),
		array( 'vc-material vc-material-settings_phone' => 'settings phone' ),
		array( 'vc-material vc-material-settings_power' => 'settings power' ),
		array( 'vc-material vc-material-settings_remote' => 'settings remote' ),
		array( 'vc-material vc-material-settings_system_daydream' => 'settings system daydream' ),
		array( 'vc-material vc-material-settings_voice' => 'settings voice' ),
		array( 'vc-material vc-material-share' => 'share' ),
		array( 'vc-material vc-material-shop' => 'shop' ),
		array( 'vc-material vc-material-shop_two' => 'shop two' ),
		array( 'vc-material vc-material-shopping_basket' => 'shopping basket' ),
		array( 'vc-material vc-material-short_text' => 'short text' ),
		array( 'vc-material vc-material-show_chart' => 'show chart' ),
		array( 'vc-material vc-material-shuffle' => 'shuffle' ),
		array( 'vc-material vc-material-signal_cellular_4_bar' => 'signal cellular 4 bar' ),
		array( 'vc-material vc-material-signal_cellular_connected_no_internet_4_bar' => 'signal_cellular_connected_no internet 4 bar' ),
		array( 'vc-material vc-material-signal_cellular_null' => 'signal cellular null' ),
		array( 'vc-material vc-material-signal_cellular_off' => 'signal cellular off' ),
		array( 'vc-material vc-material-signal_wifi_4_bar' => 'signal wifi 4 bar' ),
		array( 'vc-material vc-material-signal_wifi_4_bar_lock' => 'signal wifi 4 bar lock' ),
		array( 'vc-material vc-material-signal_wifi_off' => 'signal wifi off' ),
		array( 'vc-material vc-material-sim_card' => 'sim card' ),
		array( 'vc-material vc-material-sim_card_alert' => 'sim card alert' ),
		array( 'vc-material vc-material-skip_next' => 'skip next' ),
		array( 'vc-material vc-material-skip_previous' => 'skip previous' ),
		array( 'vc-material vc-material-slideshow' => 'slideshow' ),
		array( 'vc-material vc-material-slow_motion_video' => 'slow motion video' ),
		array( 'vc-material vc-material-stay_primary_portrait' => 'stay primary portrait' ),
		array( 'vc-material vc-material-smoke_free' => 'smoke free' ),
		array( 'vc-material vc-material-smoking_rooms' => 'smoking rooms' ),
		array( 'vc-material vc-material-textsms' => 'textsms' ),
		array( 'vc-material vc-material-snooze' => 'snooze' ),
		array( 'vc-material vc-material-sort' => 'sort' ),
		array( 'vc-material vc-material-sort_by_alpha' => 'sort by alpha' ),
		array( 'vc-material vc-material-spa' => 'spa' ),
		array( 'vc-material vc-material-space_bar' => 'space bar' ),
		array( 'vc-material vc-material-speaker' => 'speaker' ),
		array( 'vc-material vc-material-speaker_group' => 'speaker group' ),
		array( 'vc-material vc-material-speaker_notes' => 'speaker notes' ),
		array( 'vc-material vc-material-speaker_notes_off' => 'speaker notes off' ),
		array( 'vc-material vc-material-speaker_phone' => 'speaker phone' ),
		array( 'vc-material vc-material-spellcheck' => 'spellcheck' ),
		array( 'vc-material vc-material-star_border' => 'star border' ),
		array( 'vc-material vc-material-star_half' => 'star half' ),
		array( 'vc-material vc-material-stars' => 'stars' ),
		array( 'vc-material vc-material-stay_primary_landscape' => 'stay primary landscape' ),
		array( 'vc-material vc-material-stop' => 'stop' ),
		array( 'vc-material vc-material-stop_screen_share' => 'stop screen share' ),
		array( 'vc-material vc-material-storage' => 'storage' ),
		array( 'vc-material vc-material-store_mall_directory' => 'store mall directory' ),
		array( 'vc-material vc-material-straighten' => 'straighten' ),
		array( 'vc-material vc-material-streetview' => 'streetview' ),
		array( 'vc-material vc-material-strikethrough_s' => 'strikethrough s' ),
		array( 'vc-material vc-material-style' => 'style' ),
		array( 'vc-material vc-material-subdirectory_arrow_left' => 'subdirectory arrow left' ),
		array( 'vc-material vc-material-subdirectory_arrow_right' => 'subdirectory arrow right' ),
		array( 'vc-material vc-material-subject' => 'subject' ),
		array( 'vc-material vc-material-subscriptions' => 'subscriptions' ),
		array( 'vc-material vc-material-subtitles' => 'subtitles' ),
		array( 'vc-material vc-material-subway' => 'subway' ),
		array( 'vc-material vc-material-supervisor_account' => 'supervisor account' ),
		array( 'vc-material vc-material-surround_sound' => 'surround sound' ),
		array( 'vc-material vc-material-swap_calls' => 'swap calls' ),
		array( 'vc-material vc-material-swap_horiz' => 'swap horiz' ),
		array( 'vc-material vc-material-swap_vert' => 'swap vert' ),
		array( 'vc-material vc-material-swap_vertical_circle' => 'swap vertical circle' ),
		array( 'vc-material vc-material-switch_camera' => 'switch camera' ),
		array( 'vc-material vc-material-switch_video' => 'switch video' ),
		array( 'vc-material vc-material-sync_disabled' => 'sync disabled' ),
		array( 'vc-material vc-material-sync_problem' => 'sync problem' ),
		array( 'vc-material vc-material-system_update' => 'system update' ),
		array( 'vc-material vc-material-system_update_alt' => 'system update alt' ),
		array( 'vc-material vc-material-tab' => 'tab' ),
		array( 'vc-material vc-material-tab_unselected' => 'tab unselected' ),
		array( 'vc-material vc-material-tablet' => 'tablet' ),
		array( 'vc-material vc-material-tablet_android' => 'tablet android' ),
		array( 'vc-material vc-material-tablet_mac' => 'tablet mac' ),
		array( 'vc-material vc-material-tap_and_play' => 'tap and play' ),
		array( 'vc-material vc-material-text_fields' => 'text fields' ),
		array( 'vc-material vc-material-text_format' => 'text format' ),
		array( 'vc-material vc-material-texture' => 'texture' ),
		array( 'vc-material vc-material-thumb_down' => 'thumb down' ),
		array( 'vc-material vc-material-thumb_up' => 'thumb up' ),
		array( 'vc-material vc-material-thumbs_up_down' => 'thumbs up down' ),
		array( 'vc-material vc-material-timelapse' => 'timelapse' ),
		array( 'vc-material vc-material-timeline' => 'timeline' ),
		array( 'vc-material vc-material-timer' => 'timer' ),
		array( 'vc-material vc-material-timer_10' => 'timer 10' ),
		array( 'vc-material vc-material-timer_3' => 'timer 3' ),
		array( 'vc-material vc-material-timer_off' => 'timer off' ),
		array( 'vc-material vc-material-title' => 'title' ),
		array( 'vc-material vc-material-toc' => 'toc' ),
		array( 'vc-material vc-material-today' => 'today' ),
		array( 'vc-material vc-material-toll' => 'toll' ),
		array( 'vc-material vc-material-tonality' => 'tonality' ),
		array( 'vc-material vc-material-touch_app' => 'touch app' ),
		array( 'vc-material vc-material-toys' => 'toys' ),
		array( 'vc-material vc-material-track_changes' => 'track changes' ),
		array( 'vc-material vc-material-traffic' => 'traffic' ),
		array( 'vc-material vc-material-train' => 'train' ),
		array( 'vc-material vc-material-tram' => 'tram' ),
		array( 'vc-material vc-material-transfer_within_a_station' => 'transfer within a station' ),
		array( 'vc-material vc-material-transform' => 'transform' ),
		array( 'vc-material vc-material-translate' => 'translate' ),
		array( 'vc-material vc-material-trending_down' => 'trending down' ),
		array( 'vc-material vc-material-trending_flat' => 'trending flat' ),
		array( 'vc-material vc-material-trending_up' => 'trending up' ),
		array( 'vc-material vc-material-tune' => 'tune' ),
		array( 'vc-material vc-material-tv' => 'tv' ),
		array( 'vc-material vc-material-unarchive' => 'unarchive' ),
		array( 'vc-material vc-material-undo' => 'undo' ),
		array( 'vc-material vc-material-unfold_less' => 'unfold less' ),
		array( 'vc-material vc-material-unfold_more' => 'unfold more' ),
		array( 'vc-material vc-material-update' => 'update' ),
		array( 'vc-material vc-material-usb' => 'usb' ),
		array( 'vc-material vc-material-verified_user' => 'verified user' ),
		array( 'vc-material vc-material-vertical_align_bottom' => 'vertical align bottom' ),
		array( 'vc-material vc-material-vertical_align_center' => 'vertical align center' ),
		array( 'vc-material vc-material-vertical_align_top' => 'vertical align top' ),
		array( 'vc-material vc-material-vibration' => 'vibration' ),
		array( 'vc-material vc-material-video_call' => 'video call' ),
		array( 'vc-material vc-material-video_label' => 'video label' ),
		array( 'vc-material vc-material-video_library' => 'video library' ),
		array( 'vc-material vc-material-videocam' => 'videocam' ),
		array( 'vc-material vc-material-videocam_off' => 'videocam off' ),
		array( 'vc-material vc-material-videogame_asset' => 'videogame asset' ),
		array( 'vc-material vc-material-view_agenda' => 'view agenda' ),
		array( 'vc-material vc-material-view_array' => 'view array' ),
		array( 'vc-material vc-material-view_carousel' => 'view carousel' ),
		array( 'vc-material vc-material-view_column' => 'view column' ),
		array( 'vc-material vc-material-view_comfy' => 'view comfy' ),
		array( 'vc-material vc-material-view_compact' => 'view compact' ),
		array( 'vc-material vc-material-view_day' => 'view day' ),
		array( 'vc-material vc-material-view_headline' => 'view headline' ),
		array( 'vc-material vc-material-view_list' => 'view list' ),
		array( 'vc-material vc-material-view_module' => 'view module' ),
		array( 'vc-material vc-material-view_quilt' => 'view quilt' ),
		array( 'vc-material vc-material-view_stream' => 'view stream' ),
		array( 'vc-material vc-material-view_week' => 'view week' ),
		array( 'vc-material vc-material-vignette' => 'vignette' ),
		array( 'vc-material vc-material-visibility_off' => 'visibility off' ),
		array( 'vc-material vc-material-voice_chat' => 'voice chat' ),
		array( 'vc-material vc-material-voicemail' => 'voicemail' ),
		array( 'vc-material vc-material-volume_down' => 'volume down' ),
		array( 'vc-material vc-material-volume_mute' => 'volume mute' ),
		array( 'vc-material vc-material-volume_off' => 'volume off' ),
		array( 'vc-material vc-material-volume_up' => 'volume up' ),
		array( 'vc-material vc-material-vpn_key' => 'vpn key' ),
		array( 'vc-material vc-material-vpn_lock' => 'vpn lock' ),
		array( 'vc-material vc-material-wallpaper' => 'wallpaper' ),
		array( 'vc-material vc-material-watch' => 'watch' ),
		array( 'vc-material vc-material-watch_later' => 'watch later' ),
		array( 'vc-material vc-material-wb_auto' => 'wb auto' ),
		array( 'vc-material vc-material-wb_incandescent' => 'wb incandescent' ),
		array( 'vc-material vc-material-wb_iridescent' => 'wb iridescent' ),
		array( 'vc-material vc-material-wb_sunny' => 'wb sunny' ),
		array( 'vc-material vc-material-wc' => 'wc' ),
		array( 'vc-material vc-material-web' => 'web' ),
		array( 'vc-material vc-material-web_asset' => 'web asset' ),
		array( 'vc-material vc-material-weekend' => 'weekend' ),
		array( 'vc-material vc-material-whatshot' => 'whatshot' ),
		array( 'vc-material vc-material-widgets' => 'widgets' ),
		array( 'vc-material vc-material-wifi' => 'wifi' ),
		array( 'vc-material vc-material-wifi_lock' => 'wifi lock' ),
		array( 'vc-material vc-material-wifi_tethering' => 'wifi tethering' ),
		array( 'vc-material vc-material-work' => 'work' ),
		array( 'vc-material vc-material-wrap_text' => 'wrap text' ),
		array( 'vc-material vc-material-youtube_searched_for' => 'youtube searched for' ),
		array( 'vc-material vc-material-zoom_in' => 'zoom in' ),
		array( 'vc-material vc-material-zoom_out' => 'zoom out' ),
		array( 'vc-material vc-material-zoom_out_map' => 'zoom out map' ),
	);

	return array_merge( $icons, $material );
}
