<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
	<div class="col-12 shadow p-3 mb-3 bg-white rounded">
		<sapn class="font-weight-bolder text-center text-secondary ps-3"><?= (isset($media_res) && !empty($media_res)) ? 'Image Gallery | <small><i class="text-secondary">' . $media_res['media_title'] . '</i></small>' : 'Add Image Gallery' ?> </sapn>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<form id="mediaForm" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">

			<div class="form-row mb-3 px-2">
				<div class="col-12" id="gender">
					<label for="gender" class="text-secondary">Gallery type</label> <br>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="media_type" id="gallery_type" value="gallery" checked>
						<label class="form-check-label" for="gallery_type">Gallery</label>
					</div>
				</div>
			</div>

			<div id="tittleDiv" class="input-group mb-2">
				<span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-newspaper"></i> </b> </span>
				<div class="form-floating form-floating-group flex-grow-1">
					<input type="text" name="media_title" class="special_form form-control shadow-none" id="media_title" value="<?= ((isset($media_res) && !empty($media_res)) ? $media_res['media_title'] : '') ?>" placeholder="Gallery Title" style="border-radius: 0 12px 12px 0;">
					<label for="media_title">Gallery title</label>
				</div>
				<section id="titleFeedback" class="valid-feedback">
					Invalid gallery title
				</section>
				<input type="hidden" class="invalid_text" value="Invalid gallery title">
			</div>

			<div id="dateDiv" class="input-group mb-2">
				<span class="input-group-text"><b class="mt-3"> <i class="fa-solid fa-calendar-day"></i> </b> </span>
				<div class="form-floating form-floating-group flex-grow-1">
					<input type="date" name="media_publish_date" class="special_form form-control shadow-none" id="media_publish_date" value="<?= ((isset($media_res['media_publish_date'])) ? date('Y-m-d', strtotime($media_res['media_publish_date'])) : '') ?>" placeholder="YYYY/mm/dd" style="border-radius: 0 12px 12px 0;">
					<label for="media_publish_date">Media Published date</label>
				</div>
				<section id="dateFeedback" class="valid-feedback">
					Invalid Published date
				</section>
				<input type="hidden" class="invalid_text" value="Invalid Published date">
			</div>

			<div id="contentDiv" class="mb-2 d-flex">
				<span class="input-group-text flex-shrink-1 border-end-0 border-radius-end-none" style="border-radius: 12px 0 0 12px"><b class="mt-3"> <i class="fa-solid fa-file-lines"></i> </b> </span>
				<div class="form-floating form-floating-group w-100">
					<textarea class="special_form form-control shadow-none" id="media_content" name="media_content" value="" rows="4" cols="80" placeholder="Media Content" style="border-radius: 0 12px 12px 0;"><?= ((isset($media_res['media_content'])) ? $media_res['media_content'] : '') ?></textarea>
					<label for="media_content">Gallery Description</label>
				</div>
				<section id="dateFeedback" class="valid-feedback w-100">
					Invalid Gallery Description
				</section>
				<input type="hidden" class="invalid_text" value="Invalid Gallery Description">
			</div>

			<?php if (isset($_POST['media_id']) && $_POST['media_id'] != '') : ?>
				<input id="media_id" type="hidden" name="media_id" value="<?= $_POST['media_id'] ?>">
			<?php endif; ?>
		</form>
	</div>
	<div class="col-md-6 border-start">
		<div class="col border border-3 bg-secondary d-md-none mt-3"> </div>
		<label for="gender" class="text-secondary">Upload image Gallery</label> <br>
		<hr class="mt-0">
		<form id="product_form_img" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">
			<div class="row mb-3">
				<div class="col-md-12" align="center" id="product_preview">
					<div class="row" id="imgs_container">
						<?php if (isset($media_res) && !empty($media_res)) : ?>
							<?= global_imgs($dir_url, 'col-md-3', 24) ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="custom-file"> </div>

				<div class="w-100 mb-3">
					<input class="form-control col-12" id="product_images" type="file" accept="image/*" name="product_images[]" multiple>
					<!-- <label class="form-label file_label_2" for="product_images"><i class="fa fa-upload"></i> <span id="label_span_1"><?= ((isset($media) && !empty($media)) ? 'Add ' : '') ?>Gallery Images</span></label> -->
				</div>
			</div>
			<div class="multi_img_msg"> </div>
		</form>
	</div>
</div>

<div class="row">
	<div id="error_pop" class="col-md-12"></div>

	<div class="col-12 mt-4">
		<?php if (isset($media_res) && !empty($media_res)) : ?>
			<a type="button" class="btn btn-danger btn-sm shadow-none text-white float-end border-radius-lg" onclick="postCheck('error_pop', {'media_remove':true,'media_id':<?= $media_res['media_id'] ?>});" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Remove</a>
		<?php endif; ?>
		<button class="btn btn-secondary btn-sm border-radius-lg shadow-none" onclick="media_post()" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <?= ((isset($_POST['media_id']) && $_POST['media_id'] != '') ? 'Edit' : 'Add') ?> Gallery</button>
	</div>
</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>

<script class="script">
	$(document).ready(function() {
		$('#product_images').change(function(e) {
			var limit = 50;
			var files = $(this)[0].files;
			var div_len = $('#img_preview div.img_mult').length;
			console.log('files :' + files.length, 'div_len: ' + div_len);
			if (files.length > (limit - div_len)) {
				$('#error_span').text('You can only have ' + limit + ' images');
				$('#product_images').val('');
			} else {
				$('#product_form_img').submit();
				$('#error_span').text('');
				if (files.length >= 2) {
					$('#label_span').text(files.length + ' files selected')
				} else {
					var fileName = e.target.value.split('\\').pop();
					$('#label_span').text(fileName);
				}
			}
		});

		$('#product_form_img').on('submit', function(e) {
			e.preventDefault();

			postFile2('media_id', 'product_form_img');

		});
	});

	$(document).on('click', '.img_del_btn', function(e) {
		var id = e.target.id;
		var img_id = $(this).parent().attr('id');
		var prod_id = $('#media_id').val();
		var action = (prod_id != undefined && prod_id != '') ? 'edit' : 'create';
		// var path    = $('#'+id).data('path');

		var path = $(this).prevAll('img').attr('path');
		var image = $(this).prevAll('img').attr('image');

		// if( confirm('Are you sure you want to remove this image') ){
		console.log('image : ' + img_id);
		// console.log('path : ' + path);
		var data = {
			'path': path,
			'image': image,
			'action_type': action,
			'media_id': prod_id
		};
		data = Object.assign({
			'get_type': post_type[0],
			'token': token
		}, data);
		postCheck(img_id, data);

	});
</script>