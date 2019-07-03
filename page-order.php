<?php
/**
 * Template Name: Order & Delivery
 */

get_header(); ?>

	<div id="primary" class="full-content-area clear">
		<main id="main" class="site-main clear default" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="content-center text-center">
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</div>
			<?php endwhile;  ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
