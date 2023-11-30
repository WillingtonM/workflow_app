<div class="container">

    <div class="row">
        <div class="media_div col-12 shadow bg-white" style="border-radius: 25px;">
            <div class="row">

                <div class="col-12 mt-3">
                    <button type="button" class="btn btn-secondary border-radius-lg" onclick="requestModal(post_modal[10], post_modal[10], {})" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                        <i class="fas fa-user-plus me-2"></i> Create User
                    </button>

                    <button type="button" class="btn btn-warning border-radius-lg" onclick="requestModal(post_modal[19], post_modal[19], {})" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                        <i class="fa-solid fa-user-group me-2"></i> Add user types
                    </button>
                </div>
                <hr>
                <div class="clearfix p-0 m-0"></div>

                <?php require_once $config['PARSERS_PATH'] . 'settings' . DS . 'users_table.php' ?>

            </div>
        </div>

    </div>
    
</div>

</div>