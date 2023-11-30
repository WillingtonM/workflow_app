<div class="container">
    <div class="row">

        <div class="col-12">
            <!-- <button class="btn btn-secondary border-radius-lg cursor-pointer" type="button" onclick="requestModal(post_modal[11], post_modal[11], {'member':'add'})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Add client association </button> -->
            <a href="add_member" class="btn btn-secondary border-radius-lg cursor-pointer" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Add client association</a>
            <div class="col float-right">
                <form action="" method="GET">
                    <input id="search_token" type="hidden" name="token" value="<?= get_token(); ?>">

                    <div id="searchDiv" class="input-group mb-1 <?= (isset($data['success']) && $data['success'] == true) ? 'has-validation' : '' ?>">
                        <div class="form-floating form-floating-group flex-grow-1">
                            <input id="searchInp" class="form-control shadow-none" type="search" name="name" value="<?= (isset($search) && !empty($search)) ? $search : '' ?>" style="border-radius: 12px 0 0 12px" placeholder="Search ..." aria-label="Search ..." aria-describedby="basic-addon2">
                            <label for="searchInp">Search...</label>
                        </div>
                        <button class="input-group-text gul" type="submit" style="border-radius: 0 12px 12px 0 !important;"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                        <section id="loginPasswordFeedback" class="valid-feedback px-3">
                            Invalid search
                        </section>
                        <input type="hidden" class="invalid_text" value="Invalid password">
                    </div>
                </form>
            </div>

            <?php if ($req_res != null) : ?>
                
            <?php else : ?>

            <?php endif; ?>


        </div>

    </div>
    <br><br>
</div>