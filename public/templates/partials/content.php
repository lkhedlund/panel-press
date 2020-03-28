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
        <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="entry-meta">
            <?php 
               /**
                * pp_entry_meta hook.
                *
                * @hooked display_collections (output the collection this belongs to) - 10
                */
                do_action( 'pp_entry_meta', ['limit' => 1] );
            ?>
        </div>
    </header>
    <?php if (has_post_thumbnail()) : ?>
        <figure class="entry-figure">
            <?php the_post_thumbnail('large'); ?>
        </figure>
    <?php endif; ?>
</article>
