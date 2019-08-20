<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */


function wpb_adding_scripts() {
	wp_enqueue_style('font-awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style( 'custom-css', get_stylesheet_uri());
	wp_enqueue_style( 'aos', get_template_directory_uri() . '/aos.css');
	wp_enqueue_style('swiper-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css');
	wp_register_script('swiper-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js','','', true);
	wp_enqueue_script('swiper-js');
	wp_register_script( 'gsap-tween-max', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js','','', true);
	wp_enqueue_script('gsap-tween-max');
	wp_register_script('custom-js', get_template_directory_uri() . '/js/main.js','','1.1', true);
	wp_enqueue_script('custom-js');
	wp_register_script('aos', get_template_directory_uri() . '/js/aos.js','','2.3.1', true);
	wp_enqueue_script('aos');
	wp_register_script('lazyload', get_template_directory_uri() . '/js/lazyload.min.js','','1.9.6', true);
	wp_enqueue_script('lazyload');
	wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js');
	wp_enqueue_script('fancyJS', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js');
  	wp_enqueue_style('fancyCSS','https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css');
	}
	  
	add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' );  


if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});

	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;



/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class NewSeasons extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action('init', array($this, 'register_primary_menu'));
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action('wp_print_styles', 'print_emoji_styles');
		parent::__construct();
	}

	/** This is where you can register custom post types. */
	public function register_post_types() {



		// SERVICES
		register_post_type( 'services',
			array(
				'labels' => array(
					'name' => __( 'service' ),
					'singular_name' => __( 'service' )
				),
				'public' => true,
				'has_archive' => true,
				'show_in_rest' => true,
				'rewrite' => array('slug' => 'services'),
				'supports' => array( 'title', 'thumbnail' )
				
			)
		);
		
		// OCCASSIONS
		register_post_type( 'occassions',
			array(
				'labels' => array(
					'name' => __( 'occassion' ),
					'singular_name' => __( 'occassion' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'ocassion'),
				'supports' => array( 'title', 'thumbnail' ),
			)
		);

		// TESTIMONIALS
		register_post_type( 'testimonials',
			array(
				'labels' => array(
					'name' => __( 'testimonial' ),
					'singular_name' => __( 'testimonial' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'testimonial'),
			)
		);
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	public function register_primary_menu()
    {
        register_nav_menus(array(
            'primary' => 'Primary Menu',
            'footer_one' => 'First Footer Menu',
            'footer_two' => 'Second Footer Menu',
            'footer_three' => 'Third Footer Menu',
            'footer_four' => 'Fourth Footer Menu',
            'secondary' => 'Secondary Menu',
        ));
    }

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu'] = new Timber\Menu('primary');
		$context['footer_one'] = new Timber\Menu('footer_one');
		$context['footer_two'] = new Timber\Menu('footer_two');
		$context['footer_three'] = new Timber\Menu('footer_three');
		/* add custom menus to timber context */
		$context['site'] = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );


		// custom sizes
		add_image_size( 'icon', 50, 50 );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( new Twig_SimpleFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}



new NewSeasons();
