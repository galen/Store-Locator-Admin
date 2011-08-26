<?php if ( $status_message->getStatus() ): ?>
<div><p class="alert-message <?php e( $status_message->getStatuses() ) ?>"><?php e( $status_message->getMessage() ) ?></p></div>
<?php endif; ?>