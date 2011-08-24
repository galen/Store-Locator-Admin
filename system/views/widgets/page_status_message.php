<?php if ( $status_message->getStatus() ): ?>
<p id="status_message" class="<?php e( $status_message->getStatuses() ) ?>"><?php e( $status_message->getMessage() ) ?></p>
<?php endif; ?>