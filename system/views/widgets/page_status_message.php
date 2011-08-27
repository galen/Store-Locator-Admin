<?php if ( $status_message->getStatus() ): ?>
<div class="alert-message <?php e( $status_message->getStatuses() ) ?>">
	<a href="#" class="close">&times;</a>
	<p><?php e( $status_message->getMessage() ) ?></p>
</div>
<?php endif; ?>