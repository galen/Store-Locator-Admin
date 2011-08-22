<?php if ( $status_message->getStatus() ): ?>
<p id="status_message" class="<?php echo $status_message->getStatuses() ?>"><?php echo $status_message->getMessage(); ?></p>
<?php endif; ?>