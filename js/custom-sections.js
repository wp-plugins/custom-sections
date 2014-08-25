/*global window,jQuery*/
function addCustomSection() {
	'use strict';
	var section = jQuery('#custom_section').val().split('|'),
		section_template = jQuery('#custom_section_template').val(),
		section_id, section_slug;

	if (section === '') {
		// Show message to user that section must be selected...
		return;
	}

	section_id = section[0];
	section_slug = section[1];

	if (section_template === '') {
		if (jQuery('#custom_section_useslug').is(':checked')) {
			window.send_to_editor("[section name=\"" + section_slug + "\"]");
		} else {
			window.send_to_editor("[section id=\"" + section_id + "\"]");
		}
	} else {
		if (jQuery('#custom_section_useslug').is(':checked')) {
			window.send_to_editor("[section name=\"" + section_slug + "\" template=\"" + section_template + "\"]");
		} else {
			window.send_to_editor("[section id=\"" + section_id + "\" template=\"" + section_template + "\"]");
		}
	}

}