<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>
<div id="search_modal" class="modal<?php if( !isset( $registry->search_params ) && !isset( $registry->geocode_status ) || !count( $registry->stores ) ): ?> show_search_modal<?php endif; ?>">
<div class="modal-header"><h2>Search Parameters</h2><?php if( $registry->search_results_exist ): ?><a href="" class="close">&times;</a><?php endif; ?></div>
<form action="<?php echo URL_SEARCH ?>" method="get" id="search_form">
	<fieldset>
		<div class="modal-body">
	<?php for( $i=0;$i<count($registry->columns);$i++ ): ?>
			<div>
				<label><?php e( prettify_var( $registry->columns[$i] ) ) ?></label>
				<?php if( $registry->column_info[$registry->columns[$i]]['type'] == 'select' ): ?>
					<div class="search_compare">=</div>
				<?php else: ?>
					<select name="search_params[<?php echo $registry->columns[$i] ?>][compare]" class="search_compare">
						<option value=""></option>
						<option value="="<?php if( isset( $registry->search_params[$registry->columns[$i]] ) && $registry->search_params[$registry->columns[$i]]['compare'] == "=" ): ?> selected="selected"<?php endif; ?>>=</option>
						<option value="like"<?php if( isset( $registry->search_params[$registry->columns[$i]] ) && $registry->search_params[$registry->columns[$i]]['compare'] == "like" ): ?> selected="selected"<?php endif; ?>>like</option>
						<option value="!="<?php if( isset( $registry->search_params[$registry->columns[$i]] ) && $registry->search_params[$registry->columns[$i]]['compare'] == "!==" ): ?> selected="selected"<?php endif; ?>>!=</option>
						<option value="<"<?php if( isset( $registry->search_params[$registry->columns[$i]] ) && $registry->search_params[$registry->columns[$i]]['compare'] == "<" ): ?> selected="selected"<?php endif; ?>><</option>
						<option value=">"<?php if( isset( $registry->search_params[$registry->columns[$i]] ) && $registry->search_params[$registry->columns[$i]]['compare'] == ">" ): ?> selected="selected"<?php endif; ?>>></option>
					</select>
				<?php endif; ?>			
	
				<?php if( $registry->column_info[$registry->columns[$i]]['type'] == 'select' ): ?>
				<select name="search_params[<?php echo $registry->columns[$i] ?>][value]">
					<option value="select_<?php e( $registry->columns[$i] ) ?>">Select <?php e( $registry->columns[$i] ) ?></option>
					<option value=""<?php if( isset( $registry->search_params[$registry->columns[$i]]['value'] ) && $registry->search_params[$registry->columns[$i]]['value'] == '' ): ?> selected="selected"<?php endif; ?>></option>
					<?php foreach( $registry->column_info[$registry->columns[$i]]['values'] as $option ): ?>
					<option value="<?php echo $option ?>"<?php if( isset( $registry->search_params[$registry->columns[$i]]['value'] ) && $registry->search_params[$registry->columns[$i]]['value'] == $option ): ?> selected="selected"<?php endif; ?>><?php echo $option ?></option>
					<?php endforeach; ?>
				</select>
				<?php elseif( $registry->column_info[$registry->columns[$i]]['type'] == 'textarea' ): ?>
					<textarea name="search_params[<?php echo $registry->columns[$i] ?>][value]"><?php if( isset( $registry->search_params[$registry->columns[$i]]['value'] ) ): ?><?php echo $registry->search_params[$i]['value'] ?><?php endif; ?></textarea>
				<?php else: ?>
					<input type="text" name="search_params[<?php echo $registry->columns[$i] ?>][value]" value="<?php if( isset( $registry->search_params[$registry->columns[$i]]['value'] ) ): ?><?php echo $registry->search_params[$registry->columns[$i]]['value'] ?><?php endif; ?>">
				<?php endif; ?>
			</div>
	<?php endfor; ?>
			<div>
				<label for="geocode_status">Geocoded</label>
				<select name="geocode_status" id="geocode_status">
					<option value="<?php echo StoreTableGateway::GEOCODE_STATUS_ALL ?>"<?php if( $registry->geocode_status == StoreTableGateway::GEOCODE_STATUS_ALL ): ?> selected="selected"<?php endif; ?>>All</option>
					<option value="<?php echo StoreTableGateway::GEOCODE_STATUS_TRUE ?>"<?php if( $registry->geocode_status == StoreTableGateway::GEOCODE_STATUS_TRUE ): ?> selected="selected"<?php endif; ?>>Yes</option>
					<option value="<?php echo StoreTableGateway::GEOCODE_STATUS_FALSE ?>"<?php if( $registry->geocode_status == StoreTableGateway::GEOCODE_STATUS_FALSE ): ?> selected="selected"<?php endif; ?>>No</option>
				</select>
			</div>
		</div>
		<div class="modal-footer">
		
			<?php if( $registry->active_search && !$registry->search_results_exist ): ?>
				<p id="search_modal_note" class="no_results">No stores match your search criteria</p>
			<?php else: ?>
				<p id="search_modal_note">Enter your search terms and click Search</p>
			<?php endif; ?>
			<?php if( $registry->search_results_exist ): ?><a href="" class="close btn danger">Close</a><?php endif; ?>
			<?php if( $registry->active_search ): ?><input type="reset" value="Reset" onclick="window.location='<?php echo URL_SEARCH ?>'" class="btn"><?php endif; ?>
			<input type="submit" value="Search" class="btn primary">
		</div>
	</fieldset>
</form>
</div>
<div id="store_listing_header">
<h2>Search Stores</h2>

<?php if( count( $registry->stores ) ): ?>

<?php require( DIR_VIEWS . '/widgets/result_numbers.php' ) ?>
<?php if( $registry->total_pages > 1 ): ?><?php require( DIR_VIEWS . '/widgets/pagination.php' ) ?><?php endif; ?>
<p><a href="#" class="show_search_form">Show search form</a></p>
</div>
<?php require( DIR_VIEWS . '/widgets/store_listing.php' ) ?>
<?php else: ?>
<?php if( $registry->active_search && !$registry->search_results_exist ): ?>
<p class="no_results"><strong>No stores match your search criteria</strong></p>
<?php endif; ?>
</div>
<?php endif; ?>
<?php require( DIR_VIEWS . '/footer.php' ) ?>