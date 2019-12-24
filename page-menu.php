<?php
/**
 * Template Name: Menu
 */

$banner = get_field('banner');
get_header(); ?>

	<div id="primary" class="full-content-area clear <?php echo ($banner) ? 'has-banner':'no-banner default';?>">
		<main id="main" class="site-main clear font2" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php if( $menus = get_field("menu_type") ) { ?>
				<section class="menu-type-section">
					<div class="menu-text-wrap clear">
						<div class="wrapper">
							<div class="flexwrap">
							<?php foreach ($menus as $m) { 
								$menu_name = $m['name'];
								$menu_image = $m['image'];
								$menu_pdf = $m['menu_pdf'];
								$placeholder = get_bloginfo("template_url") . "/images/square.png";
								$has_image = ($menu_image) ? 'has-image':'no-image';
								$imageBox = ($menu_image) ? ' style="background-image:url('.$menu_image['sizes']['medium_large'].')"' : '';
								$openLink = '';
								$closeLink = '';
								if($menu_pdf) {
									$openLink = '<a href="'.$menu_pdf['url'].'" target="_blank" class="mlink">';
									$closeLink = '</a>';
								}
								?>
								<div class="menu-type <?php echo $has_image ?>">
									<?php echo $openLink; ?>
									<span class="image"<?php echo $imageBox ?>>
										<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true">
									</span>
									<span class="name"><?php echo $menu_name ?></span>
									<?php echo $closeLink; ?>
								</div>
							<?php } ?>
							</div>
						</div>
					</div>
				</section>
				<?php } ?>
				

			<?php endwhile; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
