<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single Posts Template
 *
 *
 * @file           single-wporg_orca_staff.php
 * @package        Responsive
 * @author         Michael Hall based on work by Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/single-wporg_orca_staff.php
 * @link           http://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<div id="content">

	<?php get_template_part( 'loop-header', get_post_type() ); ?>

	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>
                
                <div>
                <h1 style='margin-bottom: 0px; text-transform: uppercase'><?php the_title();?></h1>
				<h5 style='margin-top: 0px'> <?php $job = get_post_meta(get_the_ID(), 'job-title', true); echo $job;
                      $image_size = get_post_meta('feat-image-size',true)?></h5>
                </div>
                
                
				<div class="post-entry">
					<?php the_post_thumbnail(medium)?>
                    <?php
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
					if( is_plugin_active('responsivepro-plugin/index.php')){
					responsivepro_plugin_featured_image();
					}
					the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>

					<?php if ( get_the_author_meta( 'description' ) != '' ) : ?>

						<div id="author-meta">
							<?php if ( function_exists( 'get_avatar' ) ) {
								echo get_avatar( get_the_author_meta( 'email' ), '80' );
							} ?>
							<div class="about-author"><?php _e( 'About', 'responsive' ); ?> <?php the_author_posts_link(); ?></div>
							<p><?php the_author_meta( 'description' ) ?></p>
						</div><!-- end of #author-meta -->

					<?php endif; // no description, no author's meta ?>

					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div><!-- end of .post-entry -->



				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>


		<?php
            
        wp_reset_postdata();
    
		endwhile;

		get_template_part( 'loop-nav', get_post_type() );

	else :

		get_template_part( 'loop-no-posts', get_post_type() );

	endif;
	?>

    <div>
    extra posts
<?php  

    $loop1 = new WP_Query(
        array(
            'post_type'      => 'wporg_orca_staff',
            'orderby'       => 'title',
            'order'          => 'ASC',
            'post_status'    => 'publish',
            'posts_per_page' => 2
        )                    
    );

?>
    
	<?php if ($loop1 -> have_posts() ) : ?>

		<?php while($loop1 -> have_posts() ) : $loop1 -> the_post(); ?>
        
        <?php the_title();?>
        
        <?php
            
        wp_reset_postdata();
    
		endwhile;

	endif;
	?>
    
    </div>
    
    
</div><!-- end of #content -->


<?php get_footer(); ?>
