<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>
<div id="search_modal" class="modal">
<div class="modal-header"><h2>Search Parameters</h2><a href="#" class="close">&times;</a></div>
<form action="<?php echo URL_SEARCH ?>" method="get" id="search_form">
	<fieldset>
		<div class="modal-body">
		<?php if( $vars['total_store_count'] == 0 ): ?>
			<p class="no_results">No Stores match your search criteria</p>
		<?php endif; ?>
	<?php for( $i=0;$i<count($vars['columns_list']);$i++ ): ?>
			<div>
				<label><?php e( prettify_var( $vars['columns_list'][$i] ) ) ?></label>
				<input type="hidden" name="search_params[<?php echo $i ?>][0]" value="<?php echo $vars['columns_list'][$i] ?>">
	
	
				<?php if( $vars['column_info'][$vars['columns_list'][$i]]['type'] == 'select' ): ?>
					<div class="search_compare">=</div>
				<?php else: ?>
					<input class="search_compare" type="text" name="search_params[<?php echo $i ?>][1]" value="<?php if( isset( $vars['search_params'][$i][1] ) ): ?><?php echo $vars['search_params'][$i][1] ?><?php endif; ?>">
				<?php endif; ?>			
	
				<?php if( $vars['column_info'][$vars['columns_list'][$i]]['type'] == 'select' ): ?>
				<select name="search_params[<?php echo $i ?>][2]">
					<option value="select_<?php e( $vars['columns_list'][$i] ) ?>">Select <?php e( $vars['columns_list'][$i] ) ?></option>
					<option value=""<?php if( isset( $vars['search_params'][$i][2] ) && $vars['search_params'][$i][2] == '' ): ?> selected="selected"<?php endif; ?>></option>
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
				<label for="geocode_status">Geocoded</label>
				<select name="geocode_status" id="geocode_status">
					<option value="2"<?php if( $vars['geocode_status'] == null ): ?> selected="selected"<?php endif; ?>>All</option>
					<option value="1"<?php if( $vars['geocode_status'] == '1' ): ?> selected="selected"<?php endif; ?>>Yes</option>
					<option value="0"<?php if( $vars['geocode_status'] == '0' ): ?> selected="selected"<?php endif; ?>>No</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
		<input type="submit" value="Search" class="btn primary">
		<input type="reset" value="Reset" onclick="window.location='<?php echo URL_SEARCH ?>'" class="btn">
		</div>
	</fieldset>
</form>
</div>
<div id="store_listing_header">
<h2>Search Stores</h2>
<?php if( $vars['total_store_count'] > 0 ): ?>
<?php require( DIR_VIEWS . '/widgets/result_numbers.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/pages_navigation.php' ) ?>
<p><a href="#" class="show_search_form">Show search form</a></p>
</div>
<?php require( DIR_VIEWS . '/widgets/store_listing.php' ) ?>
<?php endif; ?>

<?php require( DIR_VIEWS . '/footer.php' ) ?>