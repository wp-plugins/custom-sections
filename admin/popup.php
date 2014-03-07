<div id="select_custom_section" style="display:none;">
    <div class="wrap" id="custom_sections">
		<h2 class="title"><?php _e('Add Custom Section', 'custom-sections'); ?></h2>
		<div class="options">

			<fieldset>
				<label><?php _e('Custom Section Post:', 'custom-sections'); ?></label>
				<select id="custom_section">
					<option value="" selected="selected"><?php _e('Select Custom Section', 'custom-sections'); ?></option>
					<?php
					$sections = CustomSections::get_section_posts();
					foreach ($sections as $section):
					?>
					<option value="<?php echo $section['id']; ?>|<?php echo $section['name']; ?>"><?php echo $section['title']; ?></option>
					<?php
					endforeach;
	                ?>
	            </select>
			</fieldset>

			<fieldset>
				<label><?php _e('Theme template file:', 'custom-sections'); ?></label>
				<select id="custom_section_template">
					<option value="" selected="selected"><?php _e('Select Template', 'custom-sections'); ?></option>
					<?php
					$templates = CustomSections::get_section_templates();
					foreach ($templates as $file => $template):
					?>
					<option value="<?php echo $file; ?>"><?php echo $template; ?></option>
					<?php
					endforeach;
	                ?>
	            </select>
			</fieldset>

			<fieldset>
				<label><?php _e('Use slug instead of ID:', 'custom-sections'); ?></label>
				<input type="checkbox" id="custom_section_useslug" checked="checked">
			</fieldset>

        </div>
        <div class="actions">
			<input type="button" class="button button-primary button-large" value="<?php _e('Add Custom Section', 'custom-sections'); ?>" onclick="addCustomSection();"/>
			<input type="button" class="button button-large" value="<?php _e('Cancel', 'custom-sections'); ?>" onclick="tb_remove();" />
        </div>
    </div>
</div>
