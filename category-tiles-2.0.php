<?php
/**
 * Plugin Name:   Category Tiles
 * Plugin URI:    https://www.dxhdev.wordpress.com
 * Description:   Widget that displays the title, date, and featured image of the most recent post in a category.
 * Version:       1.0
 * Author:        Diane Huang
 * Author URI:    https://www.dxhdev.wordpress.com
 */

//Basic setup modeled off the "Example Widget Plugin" by Jon Penland. Info below:
// Plugin Name:   Example Widget Plugin
// Plugin URI:    https://jonpenland.com
// Description:   Adds an example widget that displays the site title and tagline in a widget area.
// Version:       1.0
// Author:        Jon Penland
// Author URI:    https://www.jonpenland.com

//Extends the WP_Widget class, which provides a set of methods that can be modified in a new class

class cat2_widget extends WP_Widget {

// Set up the widget name and description.
    public function __construct() {
        $widget_options = array( 
            'classname' => 'cat2_widget', 
            'description' => 'This is the Category Tiles Widget' );
    parent::__construct( 'cat2_widget', 'Category Tiles 2.0', $widget_options );
    }
    
// Create the widget output.
    public function widget( $args, $instance ) {
//Assigns $title to the 'title' input from the $instance array in public function form($instance)
    $title = apply_filters( 'widget_title', $instance[ 'title' ] );
    $cat2_category = $instance['category'];
//Query the latest post in a category --> "display one post whose category slug is _____"
    $my_query = new WP_Query( array(
                                'category_name'=>$cat2_category,
                                'posts_per_page'=>1,
                                'offset'=>$instance['count']-1
                                ));
        while ( $my_query->have_posts() ) : $my_query->the_post();
        //Store the latest post's ID in $latest_post, then assign variables to post info
            $latest_postID = $post->ID;
            $tag_ID = get_the_id();
            $headline = get_the_title($latest_postID);
            $cat2_date = get_the_date($latest_postID);
            $featured_image = get_the_post_thumbnail($latest_postID);
            $cat2_URL = get_the_permalink($latest_postID);
        endwhile;?>
    
    <!--Plugin style, assigned class="tile" to widget objects -->
    <style>
        
        .tile<?php echo $tag_ID;?>{
            position: relative;
        }
        
        .tilebottomleft<?php echo $tag_ID;?> {
            position: absolute;
            bottom: 8px;
            left: 16px;
        }
        
        /*Image default display as b&w photo, hover turns it to color*/
        .tile<?php echo $tag_ID;?> img {
            -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
            filter: grayscale(100%);
        }
        
    
        /*Text default visibility: hidden, show when hover*/
        #tileheadline<?php echo $tag_ID;?> {
            visibility: hidden;
            text-transform: uppercase;
        }
        #tiledate<?php echo $tag_ID;?> {
            visibility: hidden;
            padding-bottom: 0px;
        }
    </style>
<!--Scripts for user interaction/animation functions-->
    <script>
        function unselectStory<?php echo $tag_ID?>(){
            var headline = document.getElementById("tileheadline<?php echo $tag_ID;?>");
            var date = document.getElementById("tiledate<?php echo $tag_ID;?>");
            var image = document.querySelector(".tile<?php echo $tag_ID;?> img");
            headline.style.visibility = "hidden";
            date.style.visibility = "hidden";
            image.style.filter = "grayscale(100%)";
            console.log("post ID is: "+<?php echo $tag_ID;?>);
            console.log("post offset is: "+<?php echo $offset;?>);
        }
        
        function selectStory<?php echo $tag_ID?>(){
            var headline = document.getElementById("tileheadline<?php echo $tag_ID;?>");
            var date = document.getElementById("tiledate<?php echo $tag_ID;?>");
            var image = document.querySelector(".tile<?php echo $tag_ID;?> img");
            headline.style.visibility = "visible";
            date.style.visibility = "visible";
            image.style.filter = "grayscale(0%)";
            console.log("post ID is: "+<?php echo $tag_ID;?>);
            console.log("post offset is: "+<?php echo $offset;?>);
        }
        
    </script>
    
    <?php
    //Display the widget spacing, title
    echo $args['before_widget'] ; ?>
        
        
    <a href="<?php echo $cat2_URL;?>">
        <div class="tile<?php echo $tag_ID;?>" id="tilediv<?php echo $tag_ID;?>" onmouseout="unselectStory<?php echo $tag_ID?>()" onmouseover="selectStory<?php echo $tag_ID?>()">
            <?php echo $featured_image;?>
            <div class="tilebottomleft<?php echo $tag_ID;?>">
                <h1 class="tile<?php echo $tag_ID;?>" id="tileheadline<?php echo $tag_ID;?>"><?php echo $headline;?></h1>
                <p class="tile<?php echo $tag_ID;?>" id="tiledate<?php echo $tag_ID;?>"><?php echo $cat2_date; ?> </p>
            </div>
        </div>
    </a>
        
        
    <?php
    echo $args['after_widget'];
     ?><?php
	}

// Create the admin form.
    public function form( $instance ) {
//set the title
		$title = !empty( $instance['title'] )? 
            $instance['title'] : '';
//set the category
        $category = !empty( $instance['category'])?
            $instance['category'] : '';
        $count= !empty( $instance['count'] )? 
            $instance['count'] : '';
?>  
    <p>
    <!--user end input-->
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" /> <br />
        <label for="<?php echo $this->get_field_id( 'category' ); ?>">Category:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" value="<?php echo esc_attr( $category ); ?>" /><br />
        <label for="<?php echo $this->get_field_id( 'category' ); ?>">Count:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo esc_attr( $count ); ?>" />

    </p>
    
<?php
	}
    
// Apply settings to the widget instance.
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'category' ] = strip_tags( $new_instance[ 'category' ] );
        $instance[ 'count' ] = strip_tags( $new_instance[ 'count' ] );
        return $instance;
    }

}

// Register the widget with wordpress.
    function register_cat2_widget() { 
        register_widget( 'cat2_widget' );
    }
//Add action hook
add_action( 'widgets_init', 'register_cat2_widget' );
?>
