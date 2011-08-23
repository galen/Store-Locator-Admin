<?php require( DIR_SYSTEM . '/views/header.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_navigation.php' ) ?>

<h2>Store listing</h2>

<?php require( DIR_SYSTEM . '/views/widget_page_status_message.php' ) ?>

<?php if( $vars['total_store_count'] > 0 ): ?>
<?php require( DIR_SYSTEM . '/views/widget_result_numbers.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_pages.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_store_listing.php' ) ?>
<?php else: ?>
<p class="no_result">No Stores</p>
<?php endif; ?>

<?php require( DIR_SYSTEM . '/views/footer.php' ) ?>