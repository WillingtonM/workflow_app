<nav aria-label="breadcrumb mb-0">
        <ol class="breadcrumb px-3 shadow-sm" style="border-radius: 15px">
            <li class="breadcrumb-item font-weight-bolder"><a class="def_text" href="#">Admin</a></li>
            <li class="breadcrumb-item font-weight-bolder" aria-current="page">Manage</li>
            <li class="breadcrumb-item font-weight-bolder active" aria-current="page">Practice Areas</li>
        </ol>
    </nav>
    <div class="row shadow p-3 mb-5 bg-white border-radius-xl/" style="border-radius: 15px;">

        <div class="col-12 mb-3">
            <button type="button" class="btn btn-secondary shadow-none border-radius-lg" onclick="requestModal(post_modal[23], post_modal[23])" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> Add Practice Area </button>
        </div>

        <!-- <h6 class="mb-3"> Practice Areas </h6> -->
        <div class="col-12 p-0 mb-3">
            <table class="table table-striped">
                <thead class="thead-light">
                    <tr class="">
                        <th scope="col" class="px-2 font-weight-bolder">Practice Areas </th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($practices)): ?>
                        <?php $count = 0 ?>
                        <?php foreach ($practices as $key => $practice) : ?>
                            <?php $count++ ?>
                            <tr>
                                <td> <span> <?= ((!empty($practice['practice_area'])) ? $practice['practice_area'] : '') ?> </span> </td>
                                <td>
                                    <a class="float-end me-3 cursor-pointer" type="button" onclick="requestModal(post_modal[23], post_modal[23], {'practice':<?= $practice['practice_area_id'] ?>})" <?= ((!$is_admin || !$subscription) ? 'disabled' : '') ?>> <i class="fa-solid fa-pen-to-square me-1"></i> Edit </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(isset($stage) && $stage !== NULL): ?>
        <hr class="horizontal dark my-2">
        <div class="col-12">
            <a href="./admin?tab=company&stage=1" class="btn btn-warning border-radius-lg me-2"> <i class="fa-solid fa-left-long me-2"></i> <span class="me-2">Previous</span></a>
            <a href="./admin?tab=practice_task&stage=3" class="btn btn-warning border-radius-lg" <?= (empty($practice_tasks)) ? 'disabled' : '' ?>> <span class="me-2">Next</span> <i class="fa-solid fa-right-long me-2"></i> </a>
        </div>
        <?php endif; ?>

    </div>