<?php
/*
Active: true
UUID: book-now-button
Title: Book now button for what's on
Description: Insert a book now button
Keywords: book,book-now,button
CSS: assets/css/block.css
JS: assets/js/block.js
Version: 1.0
Post Types: acta_whatson
Allow Multiple: true
*/
?>

<div class="booknow-button-container">
<?php
$postid = get_the_ID();
echo acta_booking_link($postid);
?> 
</div>