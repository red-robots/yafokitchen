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
		<?php endwhile; ?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
