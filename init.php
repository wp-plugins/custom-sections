<?php
/*
Plugin Name: Custom Sections
Plugin URI: http://www.jeroenvanwissen.nl/weblog/wordpress/custom-sections
Description: Custom Sections is a WordPress plugin that gives you an alternative to the default Widgets. Custom Sections are pieces of content to be used as shortcode or directly in your theme.
Version: 0.2
Author: W!SSEN
Author URI: http://jeroenvanwissen.nl/

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$path = str_replace( '\\', '/', ( dirname( __FILE__ ) ) );

define( 'CUSTOMSECTIONS_PATH', $path );
define( 'CUSTOMSECTIONS_TEMPLATES_PATH', CUSTOMSECTIONS_PATH.'/templates' );

require_once CUSTOMSECTIONS_PATH . '/functions.php';
require_once CUSTOMSECTIONS_PATH . '/classes/class-custom-sections.php';

$customsections = new CustomSections();
