<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>

<h2>Store listing</h2>

<?php require( DIR_VIEWS . '/widgets/page_status_message.php' ) ?>

<?php if( $vars['total_store_count'] > 0 ): ?>
<?php require( DIR_VIEWS . '/widgets/result_numbers.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/pages_navigation.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/store_listing.php' ) ?>
<?php else: ?>
<p class="no_result">No Stores</p>
<?php endif; ?>

<?php require( DIR_VIEWS . '/footer.php' ) ?>