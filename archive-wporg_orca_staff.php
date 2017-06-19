<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 *
 * @file           archive-wporg_orca_staff.php
 * @package        Responsive
 * @author         Michael Hall based on work by Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive-wporg_orca_staff.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */


get_header(); ?>
<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
<div id="content-archive" class="<?php echo esc_attr( implode( ' ', responsive_get_content_classes() ) ); ?>">

	<?php if ( have_posts() ) : ?>

		<?php get_template_part( 'loop-header', get_post_type() ); ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

                <style>

                .staff-picture{
                        width: 20%;
                        float: left;
                        position: relative;
                        margin: 10px;
                    }
                #staff-link-<?php the_ID(); ?>{
                     position:absolute; 
                    width:100%;
                    height:100%;
                    top:0;
                    left: 0;
                    z-index: 1;
	               }
/*
                .staff-picture-<?php the_ID(); ?>:hover{
                    filter: grayscale(100%);
                    }
*/
                #staff-info-<?php the_ID(); ?>{
                   /* max-width: 150px;*/
                    font-family: "Source Sans Pro", sans-serif;
	                position: absolute;
                    font-weight: bold;
                    text-transform: uppercase;
                    font-size: 20px;
                    display: none;
                    text-align: center;
	                top: 20%;
                    width: 100%;
                    left: 0;
	                color: black;
                    }
                </style>
                
                <script>
                function mouseOver(post) {
                    document.getElementById("staff-info-" + post).style.display = "inline";
                    document.getElementById("staff-picture-" + post).style.filter = "opacity(50%)";
                }

                function mouseOut(post) {
                    document.getElementById("staff-info-" + post).style.display = "none";
                    document.getElementById("staff-picture-" + post).style.filter = "opacity(100%)";
                }
                </script>

				<div class='staff-picture' onmouseover="mouseOver(<?php the_ID(); ?>)" onmouseout="mouseOut(<?php the_ID(); ?>)">
						<a href='<?php the_permalink(); ?>' title="<?php the_title_attribute(); ?>">
							<?php $imgid = "staff-picture-"; $imgid.=get_the_ID(); the_post_thumbnail( 'thumbnail', array( 'class' => 'aligncenter', 'id' => $imgid ) ); ?>                                
						</a>
                    <a href='<?php the_permalink(); ?>' title="<?php the_title_attribute(); ?>">
                    <span id="staff-link-<?php the_ID(); ?>">
                        </span>
                    </a>
                  <div id="staff-info-<?php the_ID(); ?>"> <?php the_title();?> <br> <span style="font-size: 16px"> <?php $job = get_post_meta(get_the_ID(), 'job-title', true); echo $job?>  </span></div>
			
					
				</div><!-- end of .staff-picture -->


				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

		<?php
		endwhile;

		get_template_part( 'loop-nav', get_post_type() );

	else :

		get_template_part( 'loop-no-posts', get_post_type() );

	endif;
	?>

</div><!-- end of #content-archive -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
