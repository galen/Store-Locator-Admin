<?php require( DIR_SYSTEM . '/views/header.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_navigation.php' ) ?>

<h2>Search Stores</h2>

<form action="" method="get">
	<fieldset>
<?php for( $i=0;$i<count($vars['table_columns_list']);$i++ ): ?>
		<div>
			<?php e( prettify_var( $vars['table_columns_list'][$i] ) ) ?>
			<input type="hidden" name="search_params[<?php echo $i ?>][0]" value="<?php echo $vars['table_columns_list'][$i] ?>">
			<input type="text" name="search_params[<?php echo $i ?>][1]" value="<?php if( isset( $vars['search_params'][$i][1] ) ): ?><?php echo $vars['search_params'][$i][1] ?><?php endif; ?>">
			<input type="text" name="search_params[<?php echo $i ?>][2]" value="<?php if( isset( $vars['search_params'][$i][2] ) ): ?><?php echo $vars['search_params'][$i][2] ?><?php endif; ?>">
		</div>
<?php endfor; ?>
		<div>
			Geocoded
			<select name="geocode_status">
				<option value="2"<?php if( $vars['geocode_status'] == null ): ?> selected="selected"<?php endif; ?>>All</option>
				<option value="1"<?php if( $vars['geocode_status'] == '1' ): ?> selected="selected"<?php endif; ?>>Yes</option>
				<option value="0"<?php if( $vars['geocode_status'] == '0' ): ?> selected="selected"<?php endif; ?>>No</option>
			</select>
		</div>
<input type="submit" value="Search">
<input type="reset" value="Reset">
	</fieldset>
</form>

<?php if( $vars['total_store_count'] > 0 ): ?>
<?php require( DIR_SYSTEM . '/views/widget_result_numbers.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_pages.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_store_listing.php' ) ?>
<?php else: ?>
<p class="no_result">No Stores match your search criteria</p>
<?php endif; ?>