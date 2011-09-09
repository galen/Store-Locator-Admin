<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>
<div id="search_modal" class="modal<?php if( !isset( $vars->search_params ) && !isset( $vars->geocode_status ) || !count( $vars->stores ) ): ?> show_search_modal<?php endif; ?>">
<div class="modal-header"><h2>Search Parameters</h2><?php if( $vars->search_results_exist ): ?><a href="" class="close">&times;</a><?php endif; ?></div>
<form action="<?php echo URL_SEARCH ?>" method="get" id="search_form">
	<fieldset>
		<div class="modal-body">
	<?php for( $i=0;$i<count($vars->columns_list);$i++ ): ?>
			<div>
				<label><?php e( prettify_var( $vars->columns_list[$i] ) ) ?></label>
				<?php if( $vars->column_info[$vars->columns_list[$i]]['type'] == 'select' ): ?>
					<div class="search_compare">=</div>
				<?php else: ?>
					<select name="<?php echo $vars->columns_list[$i] ?>[]" class="search_compare">
						<option value=""></option>
						<option value="="<?php if( isset( $vars->search_params[$vars->columns_list[$i]] ) && $vars->search_params[$vars->columns_list[$i]][1] == "=" ): ?> selected="selected"<?php endif; ?>>=</option>
						<option value="like"<?php if( isset( $vars->search_params[$vars->columns_list[$i]] ) && $vars->search_params[$vars->columns_list[$i]][1] == "like" ): ?> selected="selected"<?php endif; ?>>like</option>
						<option value="!="<?php if( isset( $vars->search_params[$vars->columns_list[$i]] ) && $vars->search_params[$vars->columns_list[$i]][1] == "!==" ): ?> selected="selected"<?php endif; ?>>!=</option>
						<option value="<"<?php if( isset( $vars->search_params[$vars->columns_list[$i]] ) && $vars->search_params[$vars->columns_list[$i]][1] == "<" ): ?> selected="selected"<?php endif; ?>><</option>
						<option value=">"<?php if( isset( $vars->search_params[$vars->columns_list[$i]] ) && $vars->search_params[$vars->columns_list[$i]][1] == ">" ): ?> selected="selected"<?php endif; ?>>></option>
					</select>
				<?php endif; ?>			
	
				<?php if( $vars->column_info[$vars->columns_list[$i]]['type'] == 'select' ): ?>
				<select name="<?php echo $vars->columns_list[$i] ?>[]">
					<option value="select_<?php e( $vars->columns_list[$i] ) ?>">Select <?php e( $vars->columns_list[$i] ) ?></option>
					<option value=""<?php if( isset( $vars->search_params[$vars->columns_list[$i]][2] ) && $vars->search_params[$vars->columns_list[$i]][2] == '' ): ?> selected="selected"<?php endif; ?>></option>
					<?php foreach( $vars->column_info[$vars->columns_list[$i]]['values'] as $option ): ?>
					<option value="<?php echo $option ?>"<?php if( isset( $vars->search_params[$vars->columns_list[$i]][2] ) && $vars->search_params[$vars->columns_list[$i]][2] == $option ): ?> selected="selected"<?php endif; ?>><?php echo $option ?></option>
					<?php endforeach; ?>
				</select>
				<?php elseif( $vars->column_info[$vars->columns_list[$i]]['type'] == 'textarea' ): ?>
					<textarea name="<?php echo $vars->columns_list[$i] ?>[]"><?php if( isset( $vars->search_params[$vars->columns_list[$i]][2] ) ): ?><?php echo $vars->search_params[$i][2] ?><?php endif; ?></textarea>
				<?php else: ?>
					<input type="text" name="<?php echo $vars->columns_list[$i] ?>[]" value="<?php if( isset( $vars->search_params[$vars->columns_list[$i]][2] ) ): ?><?php echo $vars->search_params[$vars->columns_list[$i]][2] ?><?php endif; ?>">
				<?php endif; ?>
			</div>
	<?php endfor; ?>
			<div>
				<label for="geocode_status">Geocoded</label>
				<select name="geocode_status" id="geocode_status">
					<option value="<?php echo StoreTableGateway::GEOCODE_STATUS_ALL ?>"<?php if( $vars->geocode_status == StoreTableGateway::GEOCODE_STATUS_ALL ): ?> selected="selected"<?php endif; ?>>All</option>
					<option value="<?php echo StoreTableGateway::GEOCODE_STATUS_TRUE ?>"<?php if( $vars->geocode_status == StoreTableGateway::GEOCODE_STATUS_TRUE ): ?> selected="selected"<?php endif; ?>>Yes</option>
					<option value="<?php echo StoreTableGateway::GEOCODE_STATUS_FALSE ?>"<?php if( $vars->geocode_status == StoreTableGateway::GEOCODE_STATUS_FALSE ): ?> selected="selected"<?php endif; ?>>No</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
		
			<?php if( $vars->active_search && !$vars->search_results_exist ): ?>
				<p id="search_modal_note" class="no_results">No stores match your search criteria</p>
			<?php else: ?>
				<p id="search_modal_note">Enter your search terms and click Search</p>
			<?php endif; ?>
			<?php if( $vars->search_results_exist ): ?><a href="" class="close btn danger">Close</a><?php endif; ?>
			<?php if( $vars->active_search ): ?><input type="reset" value="Reset" onclick="window.location='<?php echo URL_SEARCH ?>'" class="btn"><?php endif; ?>
			<input type="submit" value="Search" class="btn primary">
		</div>
	</fieldset>
</form>
</div>
<div id="store_listing_header">
<h2>Search Stores</h2>

<?php require( DIR_VIEWS . '/widgets/result_numbers.php' ) ?>
<?php if( $vars->total_pages > 1 ): ?><?php require( DIR_VIEWS . '/widgets/pagination.php' ) ?><?php endif; ?>
<p><a href="#" class="show_search_form">Show search form</a></p>
</div>
<?php require( DIR_VIEWS . '/widgets/store_listing.php' ) ?>

<?php require( DIR_VIEWS . '/footer.php' ) ?>