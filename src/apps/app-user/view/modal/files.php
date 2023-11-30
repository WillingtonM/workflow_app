<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
	<div id="error_pop" class="col-md-12"></div>

	<div class="col-12">
		<h5 id="error_span" class="text-center text-danger col-md-12"></h5>
		<form id="product_form_img" class="form-horizontal" method="POST" enctype="multipart/form-data">
			<div class="row col-md-12 mb-3" style="width: 100%;">
				<div class="col-md-12" align="center" id="product_preview">
					<?php if (isset($media_res) && !empty($media_res)) : ?>
						<div class="col-md-12" align="center"><a href="<?= $media_res['media_image'] ?>"> <?= $media_res['media_image'] ?></a></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="input-group">
				<div class="custom-file">
					<label class="custom-file-label file_label_2" for="file_doc"><i class="fa fa-upload"></i> <span id="label_span_1">Upload Document</span></label>
					<input type="file" class="form-control border w-100" name="file_doc" id="file_doc" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf">
				</div>
			</div>
		</form>
		<br>
	</div>

	<div class="col-12" style="padding: 30px; border-top: 5px solid #aaa">
		<form id="mediaForm" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">

			<h5 class="col-12" id="file_upld_cntnr">
				<a class="doc_anchor text-secondary me-2" href="" style="padding-bottom: 15px !important;">
					<span>File name</span>
				</a>
				<embed id="file_upload" type="application/pdf" class="image" src="" height="500" style="width: 100%; max-height: 300px; overflow-y: hidden !important; overflow: hidden;">
				<input type="hidden" name="file_name" class="file_name" value="">
			</h5>
			<div id="product_preview"></div>
			<div id="modal_add_errors"></div>

		</form>
	</div>

</div>

<div class="row">
	<div class="col-12">
		<button class="btn btn-secondary shadow-none btn-sm" onclick="shift_upld_file ('fileModal')" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>><i class="fa fa-file-upload me-2"></i> <?= ((isset($_POST['media_id']) && $_POST['media_id'] != '') ? 'Edit' : 'Add') ?> Document</button>
	</div>
</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>

<script class="script">
	$(document).ready(function() {
		$('#file_doc').change(function(e) {
			$('#product_form_img').submit();
			var files = $(this)[0].files;
			console.log(files);
			if (files.length != 0) {
				var fileName = e.target.value.split('\\').pop()
				$('#label_span_1').text(fileName);
			}
		});

		$('#product_form_img').on('submit', function(e) {
			e.preventDefault();
			var data = new FormData();
			data.append('url', post_urls[0]);
			data.append('token', token);
			data.append('get_type', post_type[0]);
			data.append('post_image', $("#product_form_img")[0]);

			postFile3('file_upload', 'product_form_img', url_val = 0, '.file_name');

			var file_src = $('#file_upload').prop('src');

		});
	});
</script>

<?php echo ob_get_clean(); ?>