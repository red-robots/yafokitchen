	</div><!-- #content -->

<?php
$social[] = array('facebook','fab fa-facebook-square');
$social[] = array('instagram','fab fa-instagram');
$social[] = array('twitter','fab fa-twitter-square');
$social_links = array();
foreach($social as $s) {
	$field = $s[0];
	$val = get_field($field,'option');
	$icon = $s[1];
	if($val) {
		$social_links[$field] = array($val,$icon);
	}
}

$footer_text = get_field('partners_text','option');
$partners = get_field('partners_list','option');

$rewards_btn1_name = get_field('button_1_label','option');
$rewards_btn1_link = get_field('button_1_link','option');
$rewards_btn2_name = get_field('button_2_label','option');
$rewards_btn2_link = get_field('button_2_link','option');
?>

	<footer id="colophon" class="site-footer clear" role="contentinfo">
		<div class="wrapper">
			<?php if ($social_links) { ?>
			<div class="social-media clear">
				<div class="vertical-middle">
					<span class="sp span1">FOLLOW US</span>
					<span class="sp span2">
						<?php foreach ($social_links as $k=>$e) { ?>
							<a class="<?php echo $k ?>" href="<?php echo $e[0] ?>" target="_blank"><i class="<?php echo $e[1] ?>"></i><span class="sr-only"><?php echo $k ?></span></a>
						<?php } ?>
					</span>
				</div>
			</div>	
			<?php } ?>

			<?php if ( ($rewards_btn1_name && $rewards_btn1_link) || ($rewards_btn2_name && $rewards_btn2_link) ) { ?>
			<div class="rewards-buttons clear text-center">
				<span class="rwbuttons">
					<?php if ($rewards_btn1_name && $rewards_btn1_link) { ?>
					<a href="<?php echo $rewards_btn1_link ?>" target="_blank" class="btn1"><?php echo $rewards_btn1_name ?></a>	
					<?php } ?>
					<?php if ($rewards_btn2_name && $rewards_btn2_link) { ?>
					<a href="<?php echo $rewards_btn2_link ?>" target="_blank" class="btn2"><?php echo $rewards_btn2_name ?></a>	
					<?php } ?>
				</span>
			</div>
			<?php } ?>

			<?php if ($footer_text) { ?>
			<div class="footer-text text-center clear"><?php echo $footer_text ?></div>
			<?php } ?>

			<?php if ($partners) { ?>
			<div class="section-partners fullwrap">
				<div class="flexrow">
					<?php foreach ($partners as $p) { 
					$a_id = $p['ID'];
					$attachment_link = get_field("attachment_link",$a_id); 
					?>
					<div class="info">
						<?php if ($attachment_link) { ?>
							<a href="<?php echo $attachment_link ?>" target="_blank"><img src="<?php echo $p['url'] ?>" alt="<?php echo $p['title'] ?>" /></a>
						<?php } else { ?>
							<img src="<?php echo $p['url'] ?>" alt="<?php echo $p['title'] ?>" />
						<?php } ?>
					</div>	
					<?php } ?>
				</div>
			</div>
			<?php } ?>

		</div><!-- wrapper -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
