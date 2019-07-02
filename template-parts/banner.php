<?php
if( $banner = get_field('banner') ) { ?>
<div class="banner clear">
	<img src="<?php echo $banner['url'] ?>" title="<?php echo $banner['title'] ?>" />
</div>
<?php } ?>