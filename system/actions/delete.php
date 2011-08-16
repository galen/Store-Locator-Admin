<?php

if ( REQUEST_IS_AJAX ) {
	require( '../config/config.php' );
	require( DIR_SYSTEM . '/core/Db.php' );
	try {
		$db = new PDO( sprintf( 'mysql:dbname=%s;host=%s', 'development', 'localhost' ), 'mysql', 'mariokartyoshi' );
	}
	catch ( PDOException $e ) {
		$json = array( 'status' => 0, 'message' => 'Error deleting the store' );
	}
	require( DIR_SYSTEM . '/models/StoreTableGateway.php' );
	$stg = new StoreTableGateway( $db, STORE_LOCATIONS_TABLE );
	
	if ( $stg->deleteStore( $_POST['id'] ) ) {
		$json = array( 'status' => 1, 'message' => 'Store deleted Successfully' );
	}
	else {
		$json = array( 'status' => 0, 'message' => 'Error deleting the store' );
	}
	die( json_encode( $json ) );
}

if ( isset( $_POST['referrer'] ) ) {

	if ( isset( $_POST['cancel'] ) ) {
		$b = isset( $_GET['b'] ) ? $_GET['b'] : URL_LIST;
		header( 'Location: ' . $b );
		exit;
	}
	if ( isset( $_POST['delete'] ) ) {
		if ( $stg->deleteStore( $vars['store_id'] ) ) {
			header( 'Location: ' . URL_LIST . '?status=success&message=Store+deleted+successfully' );
			exit;
		}
		else {
			$status_message->setStatus( 'error' );
			$status_message->setMessage( 'Error deleting the store' );
		}
	}

}

?>
<h2>Delete Store #<?php echo $store->getID() ?></h2>
<form action="" method="post">

	<fieldset>

		<input type="hidden" name="referrer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>">
		<p>Are you sure you want to delete this store?</p>
	
		<input type="submit" value="Yes" name="delete">
		<input type="submit" value="Cancel" name="cancel">
	</fieldset>

</form>