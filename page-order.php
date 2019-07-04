<?php
/**
 * Template Name: Order & Delivery
 */

get_header(); ?>

<div id="primary" class="full-content-area clear page-with-banner">
	<main id="main" class="site-main clear" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="wrapper clear content-center text-center">
				<header class="entry-header" style="display:none;">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endwhile;  ?>
		<?php
		$bg = get_field('location_image_background');
		$imgBg = ($bg) ? ' style="background-image:url('.$bg['url'].')"':'';
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'location',
			'post_status'      => 'publish'
		);
		$locations = new WP_Query($args);
		if ( $locations->have_posts() ) {  ?>
			<section class="locations-info clear"<?php echo $imgBg ?>>
				<div class="wrapper">
					<div class="flexrow clear">
					<?php while ( $locations->have_posts() ) : $locations->the_post(); ?>
						<?php
						$location_name = get_field('location_name');  
						$order_link = get_field('order_link');  
						$address = get_field('address');  
						$phone = get_field('phone');  
						if ($address) { ?>
						<div class="location fbox text-center">
							<div class="inside clear">
								<h3 class="name"><?php echo $location_name ?></h3>
								<?php if ($order_link) { ?>
								<div class="buttondiv"><a class="order-button" href="<?php echo $order_link ?>" target="_blank"><span class="icon"><i class="fas fa-utensils"></i></span><span class="txt">Order Now</span></a></div>	
								<?php } ?>
								<?php if ($phone) { ?>
								<address><?php echo $address ?></address>	
								<?php } ?>
								<?php if ($phone) { ?>
								<div class="phone"><a href="tel:<?php echo format_phone_number($phone); ?>"><?php echo $phone ?></a></div>	
								<?php } ?>
							</div>
						</div>
						<?php } ?>
					<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</section>
		<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
