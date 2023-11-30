<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'header.php'; ?>

<div class="row">
    <div class="col-12 shadow p-3 mb-3 bg-white rounded mb-4">
        <sapn class="font-weight-bolder text-center text-secondary"> Alert message</sapn>
    </div>
</div>

<div class="row">
    <div class="col-12 shadow p-3 mb-3 bg-white rounded alert <?= (isset($data['message']) && !empty($data['message']) ? $data['alert'] : '') ?>">
        <h6> <?= ((isset($data['message']) && !empty($data['message'])) ? $data['message'] : '') ?> </h6>
    </div>
</div>

<?php require_once $config['PARSERS_PATH'] . 'modal' . DS . 'footer.php'; ?>