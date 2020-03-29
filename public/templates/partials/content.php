<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 *
 * @link       https://iskotaa.com
 * @since      1.0.0
 *
 * @package    Panel_Press
 * @subpackage Panel_Press/public/templates/partials
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <header>
        <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
        <?php do_action( 'pp_entry_meta' ); ?>
    </header>
    <?php if (has_post_thumbnail()) : ?>
        <figure class="entry-figure">
            <?php the_post_thumbnail('large'); ?>
        </figure>
    <?php endif; ?>
</article>
