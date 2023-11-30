    <!-- Modal -->
    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

    <div class="row">
        <div class="col-12 shadow p-3 mb-3 bg-white rounded">
            <sapn class="font-weight-bolder text-center text-secondary ps-3"> <?= (($usr_arr != null) ? 'Edit' : 'Add') ?> <?= (isset($dft_user_type) && $dft_user_type != 'guest') ? ' User' : 'Applicant / Executor' ?> </sapn>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <form id="userForm" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">
                <?php if (isset($dft_user_type) && $dft_user_type != 'guest') : ?>
                    <div class="form-floating mb-2 has-validation">

                        <select id="user_type" name="user_type" value="" class="form-control shadow-none">
                            <option value="">Select User Type</option>
                            <?php foreach ($usrt_qry as $key => $user_type) : ?>
                                <?php if ($user_type['user_type'] == 'guest') continue ?>
                                <?php if ($usr_arr != null && ($user_type['user_type_id'] == $usr_arr['user_type_id']) || $dft_user_type == $user_type['user_type']) : ?>
                                    <option value="<?= $user_type['user_type_id'] ?>" selected> <?= ucfirst($user_type['user_type']) ?> </option>
                                <?php else : ?>
                                    <option value="<?= $user_type['user_type_id'] ?>"><?= ucfirst($user_type['user_type']) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <label for="event_title"> User Type </label>
                        <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                            <span>Invalid User Type</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid User Type">
                    </div>
                <?php else : ?>
                    <input type="hidden" name="user_type" value="6">
                <?php endif; ?>

                <div class="form-floating mb-2 has-validation">
                    <input id="username" type="text" name="username" value="<?= (($usr_arr != null) ? $usr_arr['username'] : '') ?>" class="form-control shadow-none" placeholder="Username">
                    <label for="event_title"> Username </label>
                    <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                        <span>Invalid Username</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Username">
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="name" type="text" name="name" value="<?= (($usr_arr != null) ? $usr_arr['name'] : '') ?>" class="form-control shadow-none" placeholder="Name">
                    <label for="event_title"> Name </label>
                    <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                        <span>Invalid Name</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Name">
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="surname" type="text" name="surname" value="<?= (($usr_arr != null) ? $usr_arr['last_name'] : '') ?>" class="form-control shadow-none" placeholder="Surname">
                    <label for="event_title"> Surname </label>
                    <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                        <span>Invalid Surname</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Surname">
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="mobile" type="tel" name="mobile" value="<?= (($usr_arr != null) ? $usr_arr['contact_number'] : '') ?>" class="form-control shadow-none" placeholder="Mobile Number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                    <label for="event_title"> Contact Number </label>
                    <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                        <span>Invalid Contact Number</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Contact Number">
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="telephone" type="tel" name="telephone" value="<?= (($usr_arr != null) ? $usr_arr['alt_contact_number'] : '') ?>" class="form-control shadow-none" placeholder="Telephone Number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                    <label for="event_title"> Alternative Contact Number </label>
                    <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                        <span>Invalid Alternative Contact Number</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Alternative Contact Number">
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="email" type="email" name="email" value="<?= (($usr_arr != null) ? $usr_arr['email'] : '') ?>" class="form-control shadow-none" placeholder="Email">
                    <label for="event_title"> Email </label>
                    <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                        <span>Invalid Email</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Email">
                </div>

                <div class="form-floating mb-2 has-validation">
                    <input id="password" type="password" name="password" value="" class="form-control shadow-none" placeholder="Password">
                    <label for="event_title"> Password </label>
                    <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                        <span>Invalid Password</span>
                    </div>
                    <input type="hidden" class="invalid_text" value="Invalid Password">
                </div>

                <?php if (isset($dft_user_type) && $dft_user_type != 'guest') : ?>
                    <div class="form-floating mb-2 has-validation">
                        <input id="position" type="text" name="position" value="<?= (($usr_arr != null) ? $usr_arr['user_position'] : '') ?>" class="form-control shadow-none" placeholder="Position/Title" required>
                        <label for="event_title"> User Position </label>
                        <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                            <span>Invalid User Position</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid User Position">
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <input id="list_position" type="number" min="0" name="list_position" value="<?= (($usr_arr != null) ? $usr_arr['user_listpos'] : '') ?>" class="form-control shadow-none" placeholder="List Position">
                        <label for="event_title"> List Position </label>
                        <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                            <span>Invalid List Position</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid List Position">
                    </div>

                    <div class="form-floating mb-2 has-validation">
                        <textarea id="description" class="form-control shadow-none" name="description" placeholder="User Description" rows="4" style="width: 100%;" required><?= (($usr_arr != null) ? $usr_arr['user_description'] : '') ?></textarea>
                        <label for="event_title"> User Description </label>
                        <div id="articleTitleFeedback" class="valid-feedback ps-3 mt-0">
                            <span>Invalid User Description</span>
                        </div>
                        <input type="hidden" class="invalid_text" value="Invalid User Description">
                    </div>
                <?php else : ?>
                    <input type="hidden" name="position" value="Client/Applicant">
                    <input type="hidden" name="list_position" value="0">
                    <input type="hidden" name="province" value="">
                    <input type="hidden" name="description" value="Client/Applicant">
                <?php endif; ?>


                <?php if ($usr_arr != null) : ?>
                    <input type="hidden" name="post_user" value="<?= $user_id ?>">
                <?php endif; ?>

            </form>
        </div>
        <div class="col-sm-6">
            <!-- <h5 class="alt_dflt text-center">Profile Image</h5> -->
            <form id="product_form_img" class="form-horizontal" action="includes/action/create_product.php" method="POST" enctype="multipart/form-data">

                <div id="profile_img_form" class="text-center body_element/">
                    <div id="img_cspture_img" class="row shadow w-100 border-radius-lg p-3">
                        <p class="col-12">
                            <img id="image_profile" class="image" style="height: 160px;" src="<?= (($usr_arr != null) ? img_path(ABS_USER_PROFILE, $usr_arr['user_image'], 1) : '') ?>" alt="<?= ((isset($req_res) && $req_res != NULL) ? $req_res['article_title'] : '') ?>">
                            <br>
                            <i class="fas fa-camera fa-3x"></i>
                            <br>
                            <small>Upload profile image </small>
                        </p>
                    </div>
                    <input id="post_image" type="file" name="post_image" accept="image/*" style="display: none;">
                </div>

            </form>
        </div>
    </div>
    <div class="col-12" id="error_pop"></div>

    <div class="row">
        <div class="col-12 mt-3">
            <button class="btn border-radius-lg btn-warning me-3" onclick="modal_user_post()" <?= ((!$is_admin) ? 'disabled' : '') ?>> <?= (($usr_arr != null) ? 'Edit' : 'Add') ?> User</button>
            <?php if (!empty($usr_arr)): ?>
                <button type="button" class="btn btn-danger" style="border-radius: 12px; font-weight: bolder" onclick="postCheck('error_pop', {'user' : parseInt(<?= (isset($usr_arr['user_id'])) ? $usr_arr['user_id'] : 0 ?>), 'form_type': 'remove_user'})" <?= ((!$is_admin || ($usr_arr['user_id'] == $_SESSION['user_id']) || !$_SESSION['is_admin'] || $usr_type['user_type_admin']) ? 'disabled' : '') ?>> Remove user </button>
            <?php endif; ?>
        </div>
    </div>

    <?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php' ?>

    <script class="script">
        // post to images
        jQuery(function($) {
            $('#img_cspture_img').on('click', function(e) {
                e.preventDefault();
                $('#post_image')[0].click();
            });

            $('#post_image').on('change', function(e) {
                var file_data = new FormData();
                if ($('#post_image').val()) {
                    $('.fa-camera.fa-3x').css('color', '#03556b');
                    file_data.append('post_image', $("#post_image")[0].files[0]);
                    file_data = $("#post_image")[0].files[0];
                    postFile3('image_profile', 'product_form_img', 2)
                } else {
                    $('#img_cspture_img').css('color', '');
                }
            });
        });
    </script>