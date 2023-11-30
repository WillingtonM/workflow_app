<div class="row p-3 mb-5">
    <nav aria-label="breadcrumb mb-0 px-0">
        <ol class="breadcrumb bg-white px-0 shadow-none bg-none" style="border-radius: 15px">
            <li class="breadcrumb-item font-weight-bolder"><a class="def_text/" href="#">Company and Offices</a></li>
            <li class="breadcrumb-item font-weight-bolder active" aria-current="page">Manage</li>
        </ol>
    </nav>

    <div class="col-12 mb-3 px-0">
        <button type="button" class="btn btn-secondary shadow-none border-radius-lg me-1" onclick="requestModal(post_modal[25], post_modal[25], {'type':'company'})" <?= ((!$is_admin)? 'disabled' : '') ?>> <?= (isset($company) && !empty($company)) ? 'Edit':'Add' ?> Company </button>
        <button type="button" class="btn btn-warning shadow-none border-radius-lg" onclick="requestModal(post_modal[25], post_modal[25], {'type':'office'})" <?= ((!$is_admin) ? 'disabled' : '') ?>> Add Office </button>
    </div>

    <!-- <h6 class="mb-3"> Company Offices </h6> -->
    <div class="col-12 p-0 mb-3">
        <table class="table table-striped">
            <thead class="thead-light">
                <tr class="">
                    <th scope="col" class="px-2 font-weight-bolder"> Company Offices </th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($offices)): ?>
                    <?php $count = 0 ?>
                    <?php foreach ($offices as $key => $offc) : ?>
                        <?php $count++ ?>
                        <tr>
                            <td> <span> <?= ((!empty($offc['office_name'])) ? $offc['office_name'] : '') ?> </span> </td>
                            <td>
                                <a class="float-end me-3 cursor-pointer" type="button" onclick="requestModal(post_modal[25], post_modal[25], {'type':'office', 'office':<?= $offc['office_id'] ?>})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa-solid fa-pen-to-square me-1"></i> Edit </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
