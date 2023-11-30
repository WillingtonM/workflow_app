
<div class="row shadow p-3 mb-5 bg-white border-radius-xl/" style="border-radius: 15px;">
    <ol class="breadcrumb bg-white px-3 shadow-none bg-none" style="border-radius: 15px">
        <li class="breadcrumb-item font-weight-bolder"><a class="def_text/" href="#">Admin</a></li>
        <li class="breadcrumb-item font-weight-bolder" aria-current="page">Data Migration</li>
    </ol>

    <hr class="horizontal dark mt-0 mb-3">

    <h6 class="mb-3"> Sample file structure </h6>
    <div id="data_temp_err" class="col-12 px-3 py-2"></div>
    <div class="col-12 mb-3">
        <?php if ( is_array($practices) || is_object($practices)) : ?>
            <?php foreach ($practices as $key => $pract) : ?>
                <?php $file_name      = ((isset($pract['practice_area_slug']) && !empty($pract['practice_area_slug']) ? $pract['practice_area_slug'] : '')) . '-template.xlsx'; ?>
                <?php $file_download  = DS . ABS_MIGRATIONS_DOCS . $file_name; ?>
                <button type="button" class="btn btn-secondary shadow-none border-radius-lg me-2" onclick="postCheck('data_temp_err', {'form_type':'data_template', 'practice_area':<?= $pract['practice_area_id'] ?>}, 0); return;" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
                    <span> Download <?= $pract['practice_area'] ?> Data </span>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h6 class="mt-4 mb-3"> Migrate from file </h6>
    
    <form id="product_form_img" class="col-12 mb-3/">
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="form-control border w-100" name="data_file" id="file_doc" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
            </div>
        </div>
    </form>

    <form id="mediaForm" class="col-12 mb-3/ bg-light border-radius-xl">
        <input type="hidden" class="form-control border w-100" name="form_type" value="client_association_data">
        <div class="col-auto contact_radio mb-3 px-3/"><br>
            <label for="practice_area" class="text-secondary">Choose Practice Area to upload </label> <br>
            <?php $count = 0 ?>
            <?php if ( is_array($practices) || is_object($practices)) : ?>
                <?php foreach ($practices as $key => $pract) : ?>
                    <?php $count++ ?>
                    <div class="form-check form-check-inline me-3">
                        <input class="form-check-input me-2" type="radio" name="practice_area" id="reasonRadio<?= $count ?>" value="<?= $pract['practice_area_id'] ?>" <?= (( $count == 1 ) ? 'checked' : '') ?> <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>
                        <label class="custom-control-label text-muted" for="reasonRadio<?= $count ?>"><?= $pract['practice_area'] ?></label>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </form>

    <div class="col-12">
        <div class="row px-3 mt-3 py-2" id="error_pop"></div>
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-secondary shadow-none border-radius-lg" onclick="media_post()" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa-solid fa-upload me-2"></i> Upload Document </button>
            </div>
        </div>
    </div>

    <h6 class="mt-4 mb-3"> Download data </h6>

    <div id="data_err" class="col-12 px-3 py-2"></div>

    <div class="col-12">
        <?php if ( is_array($practices) || is_object($practices)) : ?>
            <?php foreach ($practices as $key => $nav) : ?>
                <button type="button" class="btn btn-danger shadow-none border-radius-lg me-2" onclick="$('#data_err').html(''), postCheck('data_err', {'form_type':'data_download', 'practice_area':<?= $nav['practice_area_id'] ?>}, 0); return;" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>>  
                    <span> Download <?= $nav['practice_area'] ?> Data </span>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if(isset($stage) && $stage !== NULL): ?>
    <hr class="horizontal dark my-2">
    <div class="col-12">
        <a href="./admin?tab=practice_task&stage=3" class="btn btn-warning border-radius-lg me-2"> <i class="fa-solid fa-left-long me-2"></i> <span class="me-2">Previous</span></a>
        <a href="./admin?setup=complete&stage=5" class="btn btn-warning border-radius-lg"> Complete </a>
    </div>
    <?php endif; ?>

</div>