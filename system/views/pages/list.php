<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>

<div id="location_listing_header">
<h2>Location listing</h2>
<?php if( $registry->total_location_count ): ?>
<?php require( DIR_VIEWS . '/widgets/result_numbers.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/pagination.php' ) ?>
</div>
<?php require( DIR_VIEWS . '/widgets/page_status_message.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/location_listing.php' ) ?>
<?php else: ?>
</div>
<p class="no_result">No Locations</p>
<?php endif; ?>

<?php require( DIR_VIEWS . '/footer.php' ) ?>