/*global window,jQuery*/
function addCustomSection() {
	'use strict';
	var section_id = jQuery('#custom_section_id').val(),
		section_template = jQuery('#custom_section_template').val();

	if (section_id === '') {
		// Show message to user that section must be selected...
		return;
	}

	if (section_template === '') {
		window.send_to_editor("[section id=\"" + section_id + "\"]");
	} else {
		window.send_to_editor("[section id=\"" + section_id + "\" template=\"" + section_template + "\"]");
	}

}