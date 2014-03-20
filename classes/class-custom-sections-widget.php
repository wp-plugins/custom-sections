<?php

/**
 * CustomSectionsWidget class
 *
 * @package CustomSections
 * @since 0.3
 * @version 0.4.3
 * */
class CustomSectionsWidget extends WP_Widget {

	/**
	 * CustomSectionsWidget constructor
	 *
	 * @since 0.3
	 * @version 0.3
	 * */
	public function __construct( ) {
		$widget_ops = array();
		$control_ops = array();
		$this->WP_Widget( 'customsections-widget', __( 'Custom Sections Widget', 'custom-sections' ), $widget_ops, $control_ops );
	}

	/**
	 * widget function
	 *
	 * @since 0.3
	 * @version 0.4
	 * */
	public function widget( $args, $instance ) {
		global $post, $section;
		$sections_options = get_option( 'sections_options' );

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$content = '';

		if ( isset( $instance['customsectionpost'] ) ) {
			$section = new WP_Query( array(
					'post_type' => $sections_options['post_type'],
					'p' => $instance['customsectionpost']
				) );

			if ( isset($instance['customsectiontemplate']) && !empty($instance['customsectiontemplate']) ) {
				while ( $section->have_posts() ) {
					$section->the_post();
					ob_start();
					self::load_template( 'section', $instance['customsectiontemplate'] );
					$content = ob_get_contents();
					ob_end_clean();
				}
			} else {
				while ( $section->have_posts() ) {
					$section->the_post();
					$content = get_the_content();
					$content = apply_filters( 'the_content', $content );
				}
			}
		}

		echo $content;
		echo $args['after_widget'];

	}

	/**
	 * update function
	 *
	 * @since 0.3
	 * @version 0.4
	 * */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['customsectionpost'] = $new_instance['customsectionpost'];
		$instance['customsectiontemplate'] = $new_instance['customsectiontemplate'];

		return $instance;
	}

	/**
	 * form function
	 *
	 * @since 0.3
	 * @version 0.4
	 * */
	public function form( $instance ) {
		$defaults = array( 'title' => '', 'customsectionpost' => '', 'customsectiontemplate' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		include CUSTOMSECTIONS_PATH . '/admin/widget-options.php';
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
	 * @since 0.3
	 * @version 0.3
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
} // END class CustomSectionsWidget
