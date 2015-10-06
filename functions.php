<?php

/**
 * show_section function
 *
 * @since 0.1
 * @version 0.4
 * */
function show_section( $id, $options = array() ) {
	echo CustomSections::show_section( $id, $options );
}

/**
 * show_section function
 *
 * @since 0.4.8
 * @version 0.4.8
 * */
function section_exists( $id ) {
	return CustomSections::section_exists( $id );
}
