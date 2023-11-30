<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
	<div class="col-12">
		<h5 class="modal-title"><?= ((isset($_POST['subscrb_id']) && $_POST['subscrb_id'] != '') ? 'Subscription | <i class="text-warning">' . $user['subscription_name'] . $user['subscription_last_name'] . '</i>' : 'Add Subscriber') ?></h5>
	</div>
	<form id="signup_form" class="col-12" method="post"><br><br>
		<div class="rounded-0/">

			<?php require_once $config['PARSERS_PATH'] . 'forms' . DS . 'subscription.php' ?>

		</div>
	</form>

</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>