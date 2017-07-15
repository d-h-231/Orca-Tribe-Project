<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
$ftstory_query = new WP_Query( array(
                                'category_name'=>'featured-story',
                                'posts_per_page'=>1,
                                ));
        while ( $ftstory_query->have_posts() ) : $ftstory_query->the_post();
        //Store the latest post's ID in $latest_post, then assign variables to post info
            $fts_postID = $post->ID;
            $fts_ID = get_the_id();
            $fts_headline = get_the_title($fts_postID);
            $fts_image_url = get_the_post_thumbnail_url($fts_postID);
            $fts_featured_image = get_the_post_thumbnail($fts_postID);
            $fts_URL = get_the_permalink($fts_postID);
        endwhile;
$ftartist_query = new WP_Query( array(
                                'category_name'=>'featured-artist',
                                'posts_per_page'=>1,
                                ));
        while ( $ftartist_query->have_posts() ) : $ftartist_query->the_post();
        //Store the latest post's ID in $latest_post, then assign variables to post info
            $fta_postID = $post->ID;
            $fta_ID = get_the_id();
            $fta_headline = get_the_title($fta_postID);
            $fta_image_url = get_the_post_thumbnail_url($fta_postID);
            $fta_featured_image = get_the_post_thumbnail($fta_postID);
            $fta_URL = get_the_permalink($fta_postID);
        endwhile;
?>
<style>
    
    #featured-story {
	   width: 539px;
	   height: 385px;
	   margin-right: 24px;
	   float: left;
       overflow: hidden;
       position: relative;
       display: flex;
       justify-content: center;
       align-items: center;
    }   

    #featured-artist {
	   width: 385px;
	   height: 385px; 
	   float: left;
       overflow: hidden;
       position: relative;
       display: flex;
       justify-content: center;
       align-items: center;
    }   
    .featuredbottomleft {
        position: absolute;
        bottom: 8px;
        left: 16px;
    }
    
    .featuredtopright {
        position: absolute;
        top: 8px;
        right: 16px;
        text-align: right;
    }
    
    
    div.fill {
        position:relative;
        border:1px dashed red;
        display:flex;
        justify-content:center;
        align-items:center;
        overflow:hidden
    }
    div.fill img {
        flex-shrink: 0;
        min-width:100%;
        min-height:100%
    }
</style>

<!--Featured Story-->

<a href="<?php echo $fts_URL;?>">
    <div class="fill" id="featured-story" onmouseover="selectFeaturedStory();" onmouseout="unselectFeaturedStory();">
        <img id="featured-story-image" src="<?php echo $fts_image_url; ?>"/>
            <div class="featuredbottomleft">
                <h1><?php echo $fts_headline;?></h1>
            </div>
    </div>
</a>
<!--Featured Artist-->
<a href="<?php echo $fta_URL;?>">
    <div class="fill" id="featured-artist" onmouseover="selectFeaturedArtist();" onmouseout="unselectFeaturedArtist();">
        <img id="featured-artist-image" src="<?php echo $fta_image_url; ?>"/>
            <div class="featuredtopright">
                <h1><?php echo $fta_headline;?></h1>
            </div>
    </div>
</a>

<script>
    /* var imgStory = document.getElementById("featured-story-image");
    var imgArtist = document.getElementById("featured-artist-image");
    var widthStory = imgStory.width;
    var heightStory = imgStory.height;
    var widthArtist = imgArtist.width;
    var heightArtist = imgArtist.height;
    
    fitImage();

    //if img W>H, set style to height: 100%; width: auto.
    //if H>W, set style to width: 100%; height: auto

    function fitImage(){
        console.log("fitImage is running!");
        console.log(imgStory);
        console.log(imgArtist);
        if (widthStory > heightStory) {
            imgStory.style.height = "385px";
            imgStory.style.width = "auto";
        }   else {
            imgStory.style.width = "539px";
            imgStory.style.height = "auto";
        }
        if (widthArtist > heightArtist) {
            imgArtist.style.height = "385px";
            imgArtist.style.width = "auto";
        }   else {
            imgArtist.style.width = "385px";
            imgArtist.style.height = "auto";
        }

    }
    function unselectFeaturedStory(){
        imgStory.style.filter="opacity(100%)";
    }
        
    function selectFeaturedStory(){
        imgStory.style.filter="opacity(70%)";
    }
    function unselectFeaturedArtist(){
        imgArtist.style.filter="opacity(100%)";
    }
        
    function selectFeaturedArtist(){
        imgArtist.style.filter="opacity(70%)";
    }*/
</script>
