<div class="container-fluid bg-white border-radius-xl">
    <div class="container min-vh-100">

        <?php if ($member != null && $user_type != 'client') : ?>
            <div class="row">
                <div id="home-first" class="col-12 text-center px-3 mt-4 mb-1">
                    <h5 class="text-secondary" style="font-weight: normal;">
                        <span> Information for <b class="alt_dflt"><?= $member['association_name'] ?></b> </span>
                    </h5>
                </div>
            </div>
            <hr class="horizontal dark mt-1 mb-0">

            <div class="col-12 mt-4" style="border-radius: 35px;">
                <div class="col-row">
                    <div class="col-12 bg-white p-0 shadow">
                        <table class="table table-striped table-sm">
                            <tbody class="text-secondary">
                                <tr>
                                    <th scope="row" class="px-3" style="white-space: nowrap; width: 1%;">Name </th>
                                    <td class="col"> &nbsp; | &nbsp; <?= $member['association_name'] ?> </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="px-3" style="white-space: nowrap; width: 1%;">Office</th>
                                    <td class="col"> &nbsp; | &nbsp; <?= (isset($office['office_name'])) ? $office['office_name'] : '' ?> </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="px-3" style="white-space: nowrap; width: 1%;"> Reference Number </th>
                                    <td class="col"> &nbsp; | &nbsp; <?= $member['association_reference'] ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="col-row">
                    <?php require $config['PARSERS_PATH'] . 'assigns' . DS . 'table_view.php' ?>
                </div>
                <br>
            </div>
        <?php elseif ($member != null && $user_type == 'client') : ?>

        <?php endif; ?>

    </div>
</div>