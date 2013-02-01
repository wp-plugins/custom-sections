<div class="wrap">
	<div id="icon-edit" class="icon32 icon32-posts-sections"><br></div>
	<h2>Custom Sections Settings</h2>

	<form action="options.php" method="post">

		<?php settings_fields('sections_options'); ?>
		<?php do_settings_sections('sections'); ?>

		<p class="submit">
			<input type="submit" class="button-primary" value="Save Changes">
		</p>

	</form>

</div>
