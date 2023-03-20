<?php
wp_enqueue_style("masonry",plugin_dir_url(__FILE__)."assets/panel/masonry.css");
echo "<!--More like this-->\n<div class='tmp_mlt_block' id='tmp_mlt_block_".$uniqid."'>";
if(isset($heading) && $heading!==""){
    echo "<h3>".$heading."</h3>";
}
if(isset($blurb) && $blurb!==""){
    echo "<p>".$blurb."</p>";
}
    echo "<div class='panel-results' id='panel-results'><div class='object-list' id='tmp_mlt_panel_".$uniqid."'>";
    foreach($objs as $obj){	        
        $uuid = $obj->uuid;
        $accno = $obj->accession_number;
        $summary_title = $obj->compound_title;
        $imgs = $obj->images_arr;
        $tn = "";
        if(isset($imgs['images']) && $imgs['images'][0]){
            $tn = "<img src='".$GLOBALS['mediaPath'].$imgs['images'][0]['mid']."' class='tmp-panel__image'/>";
        }
?>
        <div class="object-list__item">
            <div class="object-list__inner">
                <a class="object-list__link" href="<?php echo get_permalink() . $uuid;?>/?<?php echo urlencode($_SERVER['QUERY_STRING']);?>&pos=<?php echo $qs;?>">
                    <?php echo $tn; ?>
                    <h3 class="object-list__title"><?php echo $summary_title; ?></h3>
                </a>
            </div>
        </div>
<?php 
    }
    echo "</div></div>";
    if(isset($post_blurb) && $post_blurb!==""){
        echo "<p>".$post_blurb."</p>";
    }
//If you can load the JS & CSS into the head instead then the following needn't be enclosed in the "ready" handler
?>
<script>
    	function resizeGridItem(item){
		grid = document.getElementById('tmp_mlt_panel_<?php echo $uniqid ?>');
		rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
		rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
		rowSpan = Math.ceil((item.querySelector('.object-list__inner').getBoundingClientRect().height+rowGap)/(rowHeight+rowGap));
		item.style.gridRowEnd = "span "+rowSpan;
	}

	function resizeAllGridItems(){
		allItems = document.getElementsByClassName("object-list__item");
		for(x=0;x<allItems.length;x++){
			resizeGridItem(allItems[x]);
		}
	}

	function resizeInstance(instance){
		item = instance.elements[0];
		resizeGridItem(item);
	}

	window.addEventListener("load", resizeAllGridItems, false);
	window.addEventListener("resize", resizeAllGridItems);
</script>
</div>