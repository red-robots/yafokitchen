<?php
get_header(); ?>

<div id="primary" class="home-content-area clear">
	<main id="main" class="site-main clear" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php  if( $middle_section = get_field('middle_section') ) { ?>
			<div class="mid-info-section clear">
				<div class="inner-wrap clear">
					<div class="flexrow clear">
						<?php foreach ($middle_section as $ms) { 
							$title = $ms['title'];
							$description = $ms['description']; ?>
							<?php if ($title && $description) { ?>
							<div class="fbox">
								<h2 class="title"><?php echo $title ?><span class="yafo-chickpea"></span></h2>
								<div class="description"><?php echo $description ?></div>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } ?>

			<?php
			/* LOCATIONS */
			$section_title = get_field('location_section_title');
			//$locations = get_field('locations');
			$locations = get_field('our_locations');
			?>
			<?php if ($locations) { ?>
			<div class="section-locations clear">
				<div class="wrapper">
					<?php if ($section_title) { ?>
						<h2 class="section-title text-center"><?php echo $section_title ?></h2>
					<?php } ?>
					<?php if ($locations) { ?>
					<div class="flexrow clear">
						<?php foreach ($locations as $a) { 
							$obj = $a['location_name'];
							$a_img = $a['feat_image'];
							$pid = $obj->ID;
							$a_location = $obj->post_title;
							$a_address = get_field('address',$pid);
							$a_phone_number = get_field('phone',$pid);
							$maplink = get_field('maplink',$pid);
							// $a_img = $a['loc_image']; 
							// $a_location = $a['location']; 
							// $a_address1 = $a['address_line_1']; 
							// $a_address2 = $a['address_line_2']; 
							// $a_phone_number = $a['phone_number']; 
							$link_before = '';
							$link_after = '';
							if($maplink){
								$link_before = '<a class="maplink clear" title="Click to view Map" href="'.$maplink.'" target="_blank">';
								$link_after = '</a>';
							}
							?>
							<?php if ($a_location) { ?>
							<div class="fbox">
								<?php if ($a_img) { ?>
								<div class="locimg"><img src="<?php echo $a_img['url']; ?>" alt="<?php echo $a_img['title']; ?>" /></div>	
								<?php } ?>

								<?php echo $link_before; ?>
								<h3 class="name"><?php echo $a_location ?></h3>
								<?php if ($a_address) { ?>
								<address><?php echo $a_address ?></address>	
								<?php } ?>
								<?php echo $link_after; ?>

								<?php if ($a_phone_number) { ?>
								<div class="phonenum"><a href="tel:<?php echo format_phone_number($a_phone_number); ?>"><?php echo $a_phone_number ?></a></div>	
								<?php } ?>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>

		<?php endwhile; ?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
