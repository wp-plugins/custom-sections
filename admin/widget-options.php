<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'custom-sections'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>">
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'customsectionpost' ); ?>"><?php _e('Custon Section Post:', 'custom-sections'); ?></label>
	<select name="<?php echo $this->get_field_name( 'customsectionpost' ); ?>" id="<?php echo $this->get_field_id( 'customsectionpost' ); ?>" class="widefat">
		<option value=""><?php _e('Select Section', 'custom-sections' ); ?></option>
		<?php
		$options = get_option( 'sections_options' );
		$query = new WP_Query(array(
			'post_type' => $options['post_type'],
			'posts_per_page' => -1,
			'post_status' => 'publish'

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
<p>
	<label for="<?php echo $this->get_field_id( 'customsectiontemplate' ); ?>"><?php _e('Custom Section Template:', 'custom-sections'); ?></label>
	<select name="<?php echo $this->get_field_name( 'customsectiontemplate' ); ?>" id="<?php echo $this->get_field_id( 'customsectiontemplate' ); ?>" class="widefat">
		<option value=""><?php _e('Select Template', 'custom-sections' ); ?></option>
		<?php
		$templates = CustomSections::get_section_templates();
		foreach ($templates as $file => $template) {
			if ($instance['customsectiontemplate'] == $template) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option value="' . $template . '" ' . $selected . '>' . $file . '</option>';
		}
		?>
	</select>
</p>