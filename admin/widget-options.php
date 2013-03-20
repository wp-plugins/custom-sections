<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'customsections'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>">
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'customsectionpost' ); ?>"><?php _e('Custon Section Post:', 'customsections'); ?></label>
	<select name="<?php echo $this->get_field_name( 'customsectionpost' ); ?>" id="<?php echo $this->get_field_id( 'customsectionpost' ); ?>" class="widefat">
		<option value=""><?php _e('Select Section', 'customsections' ); ?></option>
		<?php
		$options = get_option( 'sections_options' );
		$query = new WP_Query(array(
			'post_type' => $options['post_type'],
			'posts_per_page' => -1
			));
		while ( $query->have_posts() ) :
			$query->the_post();

			if ($instance['customsectionpost'] == get_the_ID()) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option value="' . get_the_ID() . '" ' . $selected . '>' . get_the_title() . '</option>';
		endwhile;
		?>
	</select>
</p>