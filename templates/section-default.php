<?php
/**
 * Sample template for Custom Sections plugin
 *
 * section-default.php
 *
 *
 * Use in theme
 * <?php show_section('<slug>', array('template' => 'default')); ?>
 * <?php show_section(<id>, array('template' => 'default')); ?>
 *
 * Use with shortcode
 *
 *  [section name="<slug>" template="default"]
 *  [section id="<id>" template="default"]
 *
 * */
?>

<h2><?php the_title(); ?></h2>
<?php the_content(); ?>
