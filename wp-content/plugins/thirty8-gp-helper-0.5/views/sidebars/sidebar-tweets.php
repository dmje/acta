<?php

$twitter_link = get_field('twitter_link','option');

if($twitter_link)
{
	
?>

<aside class="widget inner-padding widget_text">

	<a class="twitter-timeline" 
		data-height="450" 
		data-link-color="#8E143D" 
		href="<?php echo $twitter_link;?>">Tweets</a> 
		<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		
</aside>

<?php
}
else
{
	echo '<p>You need to define your Twitter account in the Site Settings menu!</p>';
}
?>