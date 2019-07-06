<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

$banner = get_field('banner');
get_header(); ?>

	<div id="primary" class="full-content-area clear <?php echo ($banner) ? 'has-banner':'no-banner default';?>">
		<main id="main" class="site-main clear default font2" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<header class="entry-header"><h1 class="entry-title"><span><?php the_title(); ?></span></h1></header>
				<?php if (has_post_thumbnail()) { ?>
					<div class="entry-content half"><?php the_content(); ?></div>
					<div class="featImagediv"><?php the_post_thumbnail('large'); ?></div>
				<?php } else { ?>
					<div class="entry-content clear"><?php the_content(); ?></div>
				<?php } ?>
			<?php endwhile; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
