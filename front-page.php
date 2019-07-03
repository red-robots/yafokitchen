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
			$locations = get_field('locations');
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
							$a_img = $a['loc_image']; 
							$a_location = $a['location']; 
							$a_address1 = $a['address_line_1']; 
							$a_address2 = $a['address_line_2']; 
							$a_phone_number = $a['phone_number']; 
							?>
							<?php if ($a_location) { ?>
							<div class="fbox">
								<?php if ($a_img) { ?>
								<div class="locimg"><img src="<?php echo $a_img['url']; ?>" alt="<?php echo $a_img['title']; ?>" /></div>	
								<?php } ?>
								<h3 class="name"><?php echo $a_location ?></h3>
								<?php if ($a_address1) { ?>
								<div class="address add1"><?php echo $a_address1 ?></div>	
								<?php } ?>
								<?php if ($a_address2) { ?>
								<div class="address add2"><?php echo $a_address2 ?></div>	
								<?php } ?>
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
