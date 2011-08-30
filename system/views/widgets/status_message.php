<?php if ( $status_message->getStatus() ): ?>
<div class="alert-message <?php e( $status_message->getStatuses() ) ?>">
	<a href="#" class="close">&times;</a>
	<?php echo $status_message->getMessage() ?>
</div>
<?php endif; ?>