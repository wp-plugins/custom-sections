<?php

/**
 * CustomSections class
 *
 * @package CustomSections
 * */
class CustomSections {

	/**
	 * CustomSections constructor
	 *
	 * @since 0.1
	 * @version 0.3
	 * */
	public function __construct( ) {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 99 );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_shortcode( 'section', array( $this, 'sections_shortcode' ) );
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
	}

	/**
	 * admin_init function
	 *
	 * @since 0.1
	 * @version 0.1
	 * */
	public function admin_init() {
		// Register settings
		register_setting( 'sections_options', 'sections_options', array( $this, 'sections_options_validate' ) );
		add_settings_section( 'sections_main', __( 'Select the custom post type to use as Sections post type' ), array( $this, 'sections_description' ), 'sections' );
		add_settings_field( 'sections_post_type_field', __( 'Sections Post Type' ), array( $this, 'sections_post_type_field' ), 'sections', 'sections_main' );
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
	 * sections_options_validate function
	 *
	 * @since 0.1
	 * @version 0.1
	 * */
	public function sections_options_validate( $input ) {
		return $input;
	}

	/**
	 * sections_description function
	 *
	 * @since 0.1
	 * @version 0.1
	 * */
	public function sections_description() {
		echo '<p></p>';
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
	 * @version 0.1
	 * */
	public function admin_head() {
		$options = get_option( 'sections_options' );
		if ( isset( $GLOBALS['post_type'] ) && $GLOBALS['post_type'] == $options['post_type'] ) {
			if ( $GLOBALS['pagenow'] == 'post.php' ) {
				add_meta_box( 'sections-shortcode', 'Shortcode', array( $this, 'shortcode_meta_box' ), $options['post_type'], 'normal', 'high' );
			}
		}
	}

	/**
	 * admin_menu function
	 *
	 * @since 0.1
	 * @version 0.1
	 * */
	public function admin_menu() {
		add_options_page( 'Sections', 'Sections', 'manage_options', 'sections', array( $this, 'sections_menu' ) );
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
	 * @version 0.1
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

				ob_start();
				self::load_template( 'sections', $options['template'] );
				$output = ob_get_contents();
				ob_end_clean();

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
	protected function load_template( $slug, $name = null ) {
		$filename = $slug . ( ( $name != null ) ? '-' . $name : '' ) . '.php';

		if ( file_exists( STYLESHEETPATH . '/' . $filename ) )
			get_template_part( $slug, $name );

		elseif ( file_exists( CUSTOMSECTIONS_TEMPLATES_PATH . '/' . $filename ) )
			load_template( CUSTOMSECTIONS_TEMPLATES_PATH . '/' . $filename, false );

		else
			get_template_part( $slug, $name );
	}
} // END class CustomSections
