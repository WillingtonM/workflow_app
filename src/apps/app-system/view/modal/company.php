    <!-- Modal -->
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>
    <div class="row">
        <h5 class="col-12 p-3 px-4 shadow mb-3"> <?= (( (isset($company) && $company) || (isset($office) && $office)) ? 'Edit ': 'Add ') . ucfirst($_POST['type']) ?> </h5>

        <div class="col-12" id="form_member">

            <form id="companyForm" class="form-horizontal">

                <?php if ($type == 'company'): ?>
                    <div class="col-auto contact_radio mb-3 px-3"><br>
                        <label for="practice_area" class="text-secondary">Company type</label> <br>
                        <?php $count = 0 ?>
                        <?php foreach ($company_types as $key => $c_type) : ?>
                            <?php $count++ ?>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input me-2" type="radio" name="company_type" id="reasonRadio<?= $count ?>" value="<?= $key ?>" <?= (((isset($company) && $company['company_type'] == $key)     ) ? 'checked' : '') ?>>
                                <label class="custom-control-label text-muted" for="reasonRadio<?= $count ?>"><?= $c_type['short'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <input id="company_name" type="text" name="company_name" value="<?= (($company != null) ? $company['company_name'] : '') ?>" class="form-control shadow-none" placeholder="Company name">
                        <label for="company_name"> Company name</label>
                        <div class="valid-feedback ps-3 mt-0">
                            <span>Invalid company name</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid company name">
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <input id="company_short" type="text" name="company_short" value="<?= (($company != null) ? $company['company_short'] : '') ?>" class="form-control shadow-none" placeholder="Company short name">
                        <label for="company_short"> Company short name</label>
                        <div class="valid-feedback ps-3 mt-0">
                            <span>Invalid company short name</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid company short name">
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <textarea id="company_description" class="form-control shadow-none" name="company_description" placeholder="Company Description" rows="4" style="width: 100%;" required><?= (( isset($company['company_description'])) ? $company['company_description'] : '') ?></textarea>
                        <label for="company_description"> Company Description </label>
                        <div class="valid-feedback ps-3 mt-0">
                            <span>Invalid company description</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid company description">
                    </div>

                    <?php if ($company != null) : ?>
                        <input type="hidden" name="company_id" value="<?= $company_id ?>">
                    <?php endif; ?>
                    <input type="hidden" name="form_type" value="company_form">

                    <div id="company_err" class="col-12" style="padding: 9px 0px;"></div>

                    <div class="col-12">
                        <?php if (isset($company_id) && !empty($company_id)) : ?>
                        <!-- <button type="button" class="btn shadow-none text-danger float-end border-radiusl-lg" onclick="postCheck('company_err', {'form_type':'company_form_remove', 'company_id':<?= $company['company_id'] ?>}, 0); return;"> <i class="fa fa-trash me-2" aria-hidden="true"></i> Remove</button> -->
                        <?php endif; ?>
                        <button type="button" class="btn btn-sm btn-secondary px-3 shadow-none <?= (isset($company_id) && !empty($company_id)) ? '' : 'col-12' ?>" style="border-radius: 11px;" onclick="postCheck('company_err', $('#companyForm').serialize(), 0, true)" <?= ((!$is_admin) ? '' : '') ?>> <?= (($company != null) ? 'Edit' : 'Add') ?> Company </button>
                    </div>
                    
                <?php else: ?>
                    <div class="form-floating mb-2 has-validation">
                        <input id="office_name" type="text" name="office_name" value="<?= (($office != null) ? $office['office_name'] : '') ?>" class="form-control shadow-none" placeholder="Office name">
                        <label for="office_name"> Office name</label>
                        <div class="valid-feedback ps-3 mt-0">
                            <span>Invalid office name</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid office name">
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <input id="office_short" type="text" name="office_short" value="<?= (($office != null) ? $office['office_short'] : '') ?>" class="form-control shadow-none" placeholder="Office short name">
                        <label for="office_short"> Office short name</label>
                        <div class="valid-feedback ps-3 mt-0">
                            <span>Invalid office short name</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid office short name">
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <input id="office_telephone" type="number" name="office_telephone" value="<?= ((isset($office['office_telephone'])) ? $office['office_telephone'] : '' ) ?>" class="form-control shadow-none" placeholder="Telephone">
                        <label for="office_telephone"> Telephone</label>
                        <div class="valid-feedback ps-3 mt-0">
                            <span>Invalid Telephone</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid Telephone">
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <textarea id="office_address" class="form-control shadow-none" name="office_address" placeholder="Office address" rows="4" style="width: 100%;" required><?= (($office != null) ? $office['office_address'] : '') ?></textarea>
                        <label for="office_address"> Office address </label>
                        <div class="valid-feedback ps-3 mt-0">
                            <span>Invalid office address</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid office address">
                    </div>

                    <?php if ($office != null) : ?>
                        <input type="hidden" name="office_id" value="<?= $office_id ?>">
                    <?php endif; ?>
                    <input type="hidden" name="form_type" value="office_form">

                    <div id="office_err" class="col-12" style="padding: 9px 0px;"></div>

                    <div class="col-12">
                        <?php if (isset($office_id) && !empty($office_id)) : ?>
                        <button type="button" class="btn shadow-none text-danger float-end border-radiusl-lg" onclick="postCheck('office_err', {'form_type':'office_remove', 'office':<?= $office_id ?>}, 0); return;"> <i class="fa fa-trash me-2" aria-hidden="true"></i> Remove</button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-sm btn-secondary px-3 shadow-none <?= (isset($office_id) && !empty($office_id)) ? '' : 'col-12' ?>" style="border-radius: 11px;" onclick="postCheck('office_err', $('#companyForm').serialize(), 0, true)" <?= ((!$is_admin) ? 'disabled' : '') ?>> <?= (($practice != null) ? 'Edit' : 'Add') ?> Office </button>
                    </div>

                <?php endif; ?>

            </form>
        </div>

    </div>
    <div class="col-12" id="error_pop"></div>
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>
