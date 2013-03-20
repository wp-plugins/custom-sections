<?php
/**
 * Sample template for Sections plugin
 *
 * sections-basic.php
 *
 *
 * Use in theme
 * <?php show_section('<slug>', array('template' => 'basic')); ?>
 * <?php show_section(<id>, array('template' => 'basic')); ?>
 *
 * Use with shortcode
 *
 *  [section name="<slug>" template="basic"]
 *  [section id="<id>" template="basic"]
 *
 * */
?>
<?php global $section; if ( $section->have_posts() ): $section->the_post(); ?>

<h2><?php the_title(); ?></h2>
<?php the_content(); ?>

<?php endif ;?>
