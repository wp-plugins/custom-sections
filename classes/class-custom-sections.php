<?php

/**
 * CustomSections class
 *
 * @package CustomSections
 * @since 0.1
 * @version 0.4.4
 * */
class CustomSections {

	/**
	 * CustomSections constructor
	 *
	 * @since 0.1
	 * @version 0.4
	 * */
	public function __construct( ) {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 99 );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_shortcode( 'section', array( $this, 'sections_shortcode' ) );
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'media_buttons_context',  array( $this, 'media_buttons' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_add_script') );

		if(in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))){
			add_action('admin_footer',  array( $this, 'add_popup'));
		}
	}

	/**
	 * register_post_type function
	 *
	 * @since 0.4
	 * @version 0.4.4
	 **/
	public function register_post_type()
	{
		$options = get_option( 'sections_options' );

		if ( isset($options['internal_post_type']) && $options['internal_post_type'] === true && isset($options['post_type']) && $options['post_type'] == 'custom-sections' ) {
			$args = array(
				'exclude_from_search' => true,
				'show_ui' => true,
				'public' => false,
				'label' => 'Sections',
				'rewrite' => false,
				'query_var' => false,
				'show_in_nav_menus' => false
			);
			register_post_type( 'custom-sections', $args );
		}
	}

	/**
	 * admin_init function
	 *
	 * @since 0.1
	 * @version 0.4
	 * */
	public function admin_init() {
		// Register settings
		register_setting( 'sections_options', 'sections_options', array( $this, 'sections_options_validate' ) );
		add_settings_section( 'sections_main', __( 'Select the custom post type to use as Sections post type' ), array( $this, 'sections_description' ), 'sections' );
		add_settings_field( 'sections_internal_post_type_field', __( 'Use internal post type' ), array( $this, 'sections_internal_post_type_field' ), 'sections', 'sections_main' );
		add_settings_field( 'sections_post_type_field', __( 'Existing post type' ), array( $this, 'sections_post_type_field' ), 'sections', 'sections_main' );
	}

	/**
	 * register_widget function
	 *
	 * @since 0.3
	 * @version 0.3
	 * */
	public function register_widget() {
		require_once CUSTOMSECTIONS_PATH . '/classes/class-custom-sections-widget.php';
		register_widget( 'CustomSectionsWidget' );
	}

	/**
	 * admin_add_script function
	 *
	 * @since 0.4
	 * @version 0.4
	 **/
	public function admin_add_script()
	{
		wp_enqueue_script('custom-sections', plugins_url('../js/custom-sections.js', __FILE__), array('jquery'), false, true);
		wp_enqueue_style('custom-sections', plugins_url('../css/custom-sections.css', __FILE__));
	}

	/**
	 * media_buttons function
	 *
	 * @since 0.4
	 * @version 0.4
	 **/
	public function media_buttons($context)
	{
		$context .= '<a href="#TB_inline?width=400&inlineId=select_custom_section" class="thickbox button" id="add_custom_section" title="' . __("Add Custom Section") . '"><span class="custom_section_icon "></span> ' . __("Add Custom Section") . '</a>';
//		$context .= '<a href="#" id="insert-section-button" class="button insert-section add_section" data-editor="content" title="Add Section"><span class="wp-media-buttons-icon"></span> Add Section</a>';
		return $context;
	}

	public function add_popup() {
		include CUSTOMSECTIONS_PATH . '/admin/popup.php';
	}
	/**
	 * sections_options_validate function
	 *
	 * @since 0.1
	 * @version 0.4
	 * */
	public function sections_options_validate( $input ) {
		if (isset($input['internal_post_type']) && $input['internal_post_type'] == 'on') {
			$input['internal_post_type'] = true;
			$input['post_type'] = 'custom-sections';
		}
		return $input;
	}

	/**
	 * sections_description function
	 *
	 * @since 0.1
	 * @version 0.1
	 * */
	public function sections_description() {
		echo '<p>Choose to use internal custom post type ( "custom-sections" ) or select an existing custom post type.</p>';
	}

	/**
	 * sections_internal_post_type_field function
	 *
	 * @since 0.4
	 * @version 0.4
	 * */
	public function sections_internal_post_type_field() {
		$options = get_option( 'sections_options' );

		$html = '<input type="checkbox" ';
		$html .= 'name="sections_options[internal_post_type]" ';
		if (isset($options['internal_post_type']) && $options['internal_post_type'] === true) {
			$html .= 'checked="checked"';
		}
		$html .= '/> ( "custom-sections" )';

		echo $html;
	}

	/**
	 * sections_post_type_field function
	 *
	 * @since 0.1
	 * @version 0.1
	 * */
	public function sections_post_type_field() {
		$options = get_option( 'sections_options' );

		$args = array( 'public' => true, '_builtin' => false );
		$output = 'names';
		$operator = 'and';
		$post_types = get_post_types( $args, $output, $operator );

		$html  = '<select id="sections_post_type" name="sections_options[post_type]">';
		$html .= '<option value="">'.__( "Select post type" ).'</option>';

		foreach ( $post_types  as $post_type ) {
			$html .= '<option value="'.$post_type.'"';
			if ( $post_type == $options['post_type'] ) {
				$html .= 'selected="selected"';
			}
			$html .= '>'.$post_type.'</option>';
		}

		$html .= '</select>';

		echo $html;
	}

	/**
	 * admin_menu function
	 *
	 * @since 0.1
	 * @version 0.4
	 * */
	public function admin_head() {
		$options = get_option( 'sections_options' );
		if ( isset( $GLOBALS['post_type'] ) && $GLOBALS['post_type'] == $options['post_type'] ) {
			if ( $GLOBALS['pagenow'] == 'post.php' ) {
				add_meta_box( 'sections-shortcode', 'Custom Section Shortcode', array( $this, 'shortcode_meta_box' ), $options['post_type'], 'normal', 'high' );
			}
		}
	}

	/**
	 * admin_menu function
	 *
	 * @since 0.1
	 * @version 0.4
	 * */
	public function admin_menu() {
		add_options_page( 'Custom Sections', 'Custom Sections', 'manage_options', 'sections', array( $this, 'sections_menu' ) );
	}

	/**
	 * sections_menu function
	 *
	 * @since 0.1
	 * @version 0.2
	 * */
	public function sections_menu() {
		include CUSTOMSECTIONS_PATH . '/admin/settings.php';
	}

	/**
	 * shortcode_meta_box function
	 *
	 * @since 0.1
	 * @version 0.2
	 * */
	public function shortcode_meta_box() {
		include CUSTOMSECTIONS_PATH . '/admin/shortcode.php';
	}

	/**
	 * sections_shortcode function
	 *
	 * @since 0.1
	 * @version 0.1
	 * */
	public function sections_shortcode( $args ) {
		global $post;
		$options = get_option( 'sections_options' );
		$output = '';

		if ( $post->post_type !== $options['post_type'] ) {
			if ( isset( $args['id'] ) && is_numeric( $args['id'] ) ) {
				$id = $args['id'];
				unset( $args['id'] );
				$output = self::show_section( $id, $args );
			} elseif ( isset( $args['name'] ) && is_string( $args['name'] ) ) {
				$name = $args['name'];
				unset( $args['name'] );
				$output = self::show_section( $name, $args );
			}
		}

		return $output;
	}

	/**
	 * show_section function
	 *
	 * @since 0.1
	 * @version 0.4
	 * */
	public static function show_section( $id, $options = array() ) {
		global $post, $section;
		$sections_options = get_option( 'sections_options' );
		$args = false;
		$output = '';

		if ( is_numeric( $id ) ) {
			$args = array( 'p' => $id, 'post_type' => $sections_options['post_type'] );
		} elseif ( is_string( $id ) ) {
			$args = array( 'name' => $id, 'post_type' => $sections_options['post_type'] );
		}

		if ( $args ) {
			$section = new WP_Query( $args );

			// TODO: Add filters for security of filename etc..
			if ( isset( $options['template'] ) && !empty( $options['template'] ) ) {

				if ( $section->have_posts() ) {
					$section->the_post();
					
					ob_start();
					self::load_template( 'section', $options['template'] );
					$output = ob_get_contents();
					ob_end_clean();
				}

			} else {

				if ( $section->have_posts() ) {
					$section->the_post();

					$output .= '<h2 class="sections-title">' . get_the_title() . '</h2>';

					$content = get_the_content();
					$content = apply_filters( 'the_content', $content );
					$content = str_replace( ']]>', ']]&gt;', $content );
					$output .= $content;
				}
			}
		}
		wp_reset_postdata();

		return $output;
	}

	/**
	 * get_section_templates function
	 *
	 * @since 0.4
	 * @version 0.4.3
	 **/
	public static function get_section_templates() {
		$page_templates = array();
		$files = (array) wp_get_theme()->get_files( 'php' );

		// Also check in parent theme for section theme files.
		if ( wp_get_theme()->parent() ) {
			$files = array_merge( $files, wp_get_theme()->parent()->get_files( 'php' ) );
		}

		foreach ( $files as $file => $full_path ) {
			if ( ! preg_match( '|section-(.*).php$|mi', $full_path, $match ) )
				continue;

			if ( preg_match( '|Template Name:(.*)$|mi', file_get_contents( $full_path ), $header ) ) {
				$page_templates[ $match[1] ] = _cleanup_header_comment( $header[1] );
			} else {
				$page_templates[ $match[1] ] = ( $file );
			}

		}
		return $page_templates;
	}

	/**
	 * get_section_posts function
	 *
	 * @since 0.4
	 * @version 0.4
	 **/
	public static function get_section_posts()
	{
		global $post;
		$sections_posts = array();
		$sections_options = get_option( 'sections_options' );
		$query = new WP_Query(array(
			'post_type' => $sections_options['post_type'],
			'posts_per_page' => -1,
			'post_status' => 'publish'
		));

		if ($query->have_posts()) {
			while ( $query->have_posts() ) {
					$query->the_post();
					$sections_posts[] = array(
						'id' => $post->ID,
						'name' => $post->post_name,
						'title' => $post->post_title
					);
			}
		}
		wp_reset_query();

		return $sections_posts;
	}

	/**
	 * Load Template
	 *
	 * If exists, load template file from theme
	 * Fallback to plugin template file, if exists.
	 *
	 * @param string  $slug
	 * @param string  $name Optional. Default null
	 * @uses load_template()
	 * @uses get_template_part()
	 * @since 0.1
	 * @version 0.2
	 * */
	protected static function load_template( $slug, $name = null ) {
		$filename = $slug . ( ( $name != null ) ? '-' . $name : '' ) . '.php';

		if ( file_exists( STYLESHEETPATH . '/' . $filename ) )
			get_template_part( $slug, $name );

		elseif ( file_exists( CUSTOMSECTIONS_TEMPLATES_PATH . '/' . $filename ) )
			load_template( CUSTOMSECTIONS_TEMPLATES_PATH . '/' . $filename, false );

		else
			get_template_part( $slug, $name );
	}
} // END class CustomSections
