<div id="select_custom_section" style="display:none;">
    <div class="wrap" id="custom_sections">
		<h2 class="title">Add Custom Section</h2>
		<div class="options">

			<fieldset>
				<label>Custom Section Post:</label>
				<select id="custom_section_id">
					<option value="" selected="selected"><?php _e("Select Custom Section"); ?></option>
					<?php
					$sections = CustomSections::get_section_posts();
					foreach ($sections as $section):
					?>
					<option value="<?php echo $section['id']; ?>"><?php echo $section['title']; ?></option>
					<?php
					endforeach;
	                ?>
	            </select>
			</fieldset>

			<fieldset>
				<label>Theme template file:</label>
				<select id="custom_section_template">
					<option value="" selected="selected"><?php _e("Select Template"); ?></option>
					<?php
					$templates = CustomSections::get_section_templates();
					foreach ($templates as $file => $template):
					?>
					<option value="<?php echo $template; ?>"><?php echo $file; ?></option>
					<?php
					endforeach;
	                ?>
	            </select>
			</fieldset>

        </div>
        <div class="actions">
			<input type="button" class="button button-primary button-large" value="<?php _e('Add Custom Section'); ?>" onclick="addCustomSection();"/>
			<input type="button" class="button button-large" value="<?php _e('Cancel'); ?>" onclick="tb_remove();" />
        </div>
    </div>
</div>
