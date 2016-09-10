<?php
/**
 * Template Name: Single MTG Card
 */

get_header(); ?>
<div class="mtg-container">
    <div class="mtg-content">
        <?php
            $mtg_args = array( 'post_type' => 'mtg_cards' );
            $mtg_loop = new WP_Query($mtg_args);
            while( $mtg_loop->have_posts() ) : $mtg_loop->the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
            <strong>Name: </strong><?php the_title(); ?><br>
            <strong>Set: </strong><?php echo esc_html( get_post_meta( get_the_ID(), 'card_set', true ) ); ?><br>
            <strong>Rarity: </strong><?php echo esc_html( get_post_meta( get_the_ID(), 'card_rarity', true ) ); ?><br>
            <strong>Notes: </strong><br>
            <?php the_content(); ?>
        </article>
    <?php endwhile; ?>
    </div>
</div>
<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>
