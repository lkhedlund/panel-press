<?php
/**
 * The default template for displaying content
 *
 * Used for index.
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
    <?php do_action( 'pp_comics_pagination' ); ?>
    <?php if (has_post_thumbnail()) : ?>
        <figure class="entry-figure">
            <?php the_post_thumbnail('large'); ?>
        </figure>
    <?php endif; ?>
    <?php do_action( 'pp_comics_pagination' ); ?>
    <div class="post-inner">
		<div class="entry-content">
			<?php the_content();?>
        </div>
        <?php if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) : ?>
            <div class="comments-wrapper section-inner">
                <?php comments_template(); ?>
            </div>
		<?php endif; ?>
	</div>
</article>
