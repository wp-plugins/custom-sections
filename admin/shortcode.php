<?php
	$pid = $GLOBALS['post_ID'];
	$section = get_post($pid);
	$title = $section->post_title;
	$name  = $section->post_name;
?>
<div id="section-shortcode-display">
	<p>Use the shortcode to use this custom section in another post, or use the php function call to use it directly in your theme. Change 'default' to any other custom created section-&lt;template&gt;.php template file in your theme folder.</p>
	<div class="section-shortcode">
		<span id="ection-shortcode"><pre>[section id="<?php echo $pid; ?>" template="default"]</pre></span>
	</div>
	<div class="section-function">
		<span id="section-function"><pre>&lt;?php show_section('<?php echo $pid; ?>', array('template' => 'default')); ?&gt;</pre></span>
	</div>
</div>