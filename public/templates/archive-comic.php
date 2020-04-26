<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://iskotaa.com
 * @since      1.0.0
 *
 * @package    Panel_Press
 * @subpackage Panel_Press/public/templates
 */

get_header();

$archive_class = apply_filters( 'pp_archive_classes', 'pp-archive' );
?>

<main id="site-content" role="main" class="<?= $archive_class; ?>">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php include( plugin_dir_path( __FILE__ ) . 'partials/content.php');?>
		<?php endwhile; ?>
	<?php endif; ?>
</main><!-- #site-content -->
<?php
get_footer();