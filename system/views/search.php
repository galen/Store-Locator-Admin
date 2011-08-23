<?php require( DIR_SYSTEM . '/views/header.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_navigation.php' ) ?>

<h2>Search Stores</h2>

<form action="" method="get">
	<fieldset>
<?php for( $i=0;$i<count($vars['columns_list']);$i++ ): ?>
		<div>
			<?php e( prettify_var( $vars['columns_list'][$i] ) ) ?>
			<input type="hidden" name="search_params[<?php echo $i ?>][0]" value="<?php echo $vars['columns_list'][$i] ?>">

			<?php if( $vars['column_info'][$vars['columns_list'][$i]]['type'] == 'select' ): ?>
				<input type="hidden" name="search_params[<?php echo $i ?>][1]" value="=">
			<?php else: ?>
				<input type="text" name="search_params[<?php echo $i ?>][1]" value="<?php if( isset( $vars['search_params'][$i][1] ) ): ?><?php echo $vars['search_params'][$i][1] ?><?php endif; ?>">
			<?php endif; ?>			

			<?php if( $vars['column_info'][$vars['columns_list'][$i]]['type'] == 'select' ): ?>
			<select name="search_params[<?php echo $i ?>][2]">
				<option value=""></option>
				<?php foreach( $vars['column_info'][$vars['columns_list'][$i]]['values'] as $option ): ?>
				<option value="<?php echo $option ?>"<?php if( isset( $vars['search_params'][$i][2] ) && $vars['search_params'][$i][2] == $option ): ?> selected="selected"<?php endif; ?>><?php echo $option ?></option>
				<?php endforeach; ?>
			</select>
			<?php elseif( $vars['column_info'][$vars['columns_list'][$i]]['type'] == 'textarea' ): ?>
				<textarea name="search_params[<?php echo $i ?>][2]"><?php if( isset( $vars['search_params'][$i][2] ) ): ?><?php echo $vars['search_params'][$i][2] ?><?php endif; ?></textarea>
			<?php else: ?>
				<input type="text" name="search_params[<?php echo $i ?>][2]" value="<?php if( isset( $vars['search_params'][$i][2] ) ): ?><?php echo $vars['search_params'][$i][2] ?><?php endif; ?>">
			<?php endif; ?>
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
<input type="reset" value="Reset" onclick="window.location='<?php echo URL_SEARCH ?>'">
	</fieldset>
</form>

<?php if( $vars['total_store_count'] > 0 ): ?>
<?php require( DIR_SYSTEM . '/views/widget_result_numbers.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_pages.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_store_listing.php' ) ?>
<?php else: ?>
<p class="no_result">No Stores match your search criteria</p>
<?php endif; ?>

<?php require( DIR_SYSTEM . '/views/footer.php' ) ?>