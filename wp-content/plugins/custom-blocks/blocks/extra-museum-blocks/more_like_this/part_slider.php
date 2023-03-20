<?php
//enqueue this shit
wp_enqueue_script("slick",plugin_dir_url(__FILE__)."assets/slick/slick.min.js");
wp_enqueue_style("slick",plugin_dir_url(__FILE__)."assets/slick/slick.css");
wp_enqueue_style("slick-theme",plugin_dir_url(__FILE__)."assets/slick/slick-theme.css");
wp_enqueue_style("slider",plugin_dir_url(__FILE__)."assets/slick/slider.css");
echo "<!--More like this-->\n<div class='tmp_mlt_block' id='tmp_mlt_block_".$uniqid."'>";

if(isset($heading) && $heading!==""){
    echo "<h3>".$heading."</h3>";
}
if(isset($blurb) && $blurb!==""){
    echo "<p>".$blurb."</p>";
}
    echo "<div class='tmp-slider-container' id='tmp_mlt_slider_".$uniqid."'>";
    foreach($objs as $obj){	        
        $uuid = $obj->uuid;
        $accno = $obj->accession_number;
        $summary_title = $obj->compound_title;
        $imgs = $obj->images_arr;
        $tn = "";
        if(isset($imgs['images']) && $imgs['images'][0]){
            $tn = "<img src='".$GLOBALS['mediaPath'].$imgs['images'][0]['preview']."' class='tmp-slider__image'/>";
        }
?>      <div>
            <div class="slick-slide-img-container">
                <a class="object-list__link" href="<?php echo get_permalink() . $uuid;?>/?<?php echo urlencode($_SERVER['QUERY_STRING']);?>">
                <?php echo $tn; ?>
                <h3 class="tmp-slider__content"><?php echo $summary_title; ?></h3>
                </a>
            </div>
        </div>
<?php 
    }
    echo "</div>";
    if(isset($post_blurb) && $post_blurb!==""){
        echo "<p>".$post_blurb."</p>";
    }
//If you can load the JS & CSS into the head instead then the following needn't be enclosed in the "ready" handler
?>
<script>
    jQuery( document ).ready(function() {
        jQuery('#tmp_mlt_slider_<?php echo $uniqid; ?>').slick({
            slidesToScroll: 3,
            speed: 300,
            dots:true,
            variableWidth: true,
        });
    });
</script>
</div>