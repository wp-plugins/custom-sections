<?php
	$pid = $GLOBALS['post_ID'];
	$section = get_post($pid);
	$title = $section->post_title;
	$name  = $section->post_name;
?>
<div id="section-shortcode-display">
	<p>Use the shortcode to use this section in another post, or use the php function to use it directly in your theme. Change 'basic' to any other custom created section-&lt;template&gt;.php template file in your theme folder.</p>
	<div class="section-shortcode">
		<span id="ection-shortcode"><pre>[section name="<?php echo $name; ?>" template="basic"]</pre></span>
	</div>
	<div class="section-function">
		<span id="section-function"><pre>&lt;?php show_section('<?php echo $name; ?>', array('template' => 'basic')); ?&gt;</pre></span>
	</div>
</div>