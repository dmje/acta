<div class="featured-item <?php echo $arr['item_class']; ?>" <?php if(isset($arr['item_id'])){echo 'id="' . $arr['item_id'] . '"';} ?>>
	<?php if($arr['image_src']){ 
		$src=' src="'.$arr['image_src'].'"';
		$srcset="";
		$sizes="";
		$image_alt = isset($arr['image_alt'])?' alt="'.$arr['image_alt'].'"':"";
		if($arr['image_src_thumb']){	//set up srcset
			$srcset.=isset($arr['image_src_thumb'])?$arr['image_src_thumb']." 400w, ":"";
			$sizes.="400px 400px,";
			$src=isset($arr['image_src_thumb'])?' src="'.$arr['image_src_thumb'].'"':$src;
		}
		if($arr['image_src_mid']){	//set up srcset
			$srcset.=isset($arr['image_src_mid'])?$arr['image_src_mid']." 620w, ":"";
			$sizes.="700px 620px,";
		}
		if($arr['image_src_thumb']){	//set up srcset
			$srcset.=isset($arr['image_src_large'])?$arr['image_src_large']." 800w":"";
			$sizes.="1000px 800px";
		}
		if($srcset<>""){$srcset=' srcset="'.$srcset.'"';}
		if($sizes<>""){$sizes=' sizes="'.$sizes.'"';}
	?>
	<div class="featured-item__media">
		<a href="<?php echo $arr['item_link']; ?>">
			<img <?php echo $src.$image_alt.$srcset.$sizes; ?> class="featured-item__img">
		</a>
	</div>
	<?php	}	?>
</div>