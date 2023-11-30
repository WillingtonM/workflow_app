<div class="row">
  <div class="container">

    <div class="row mb-3">
        <div class="col col-md-6 col-lg-7">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6>Task overview</h6>
                    <p class="text-sm">
                        <!-- <i class="fa fa-arrow-up text-success"></i>
                        <span class="font-weight-bold">4% more</span> in 2021 -->
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

      <!-- tasks -->
      <div class="col col-md-6 col-lg-5">
        <div class="card h-100">
          <div class="card-header pb-0 p-3">
            <div class="row">
              <div class="col-6 d-flex align-items-center">
                <h6 class="mb-0">Recent tasks</h6>
              </div>
              <div class="col-6 text-end">
                <a class="btn btn-outline-dark btn-sm/ mb-0 fs-6 px-3" href="./tasks"> <i class="fa-solid fa-list-check me-2"></i> View All</a>
              </div>
            </div>
          </div>
          <div class="card-body p-3 pb-0">

            <?php if (is_array($orders) || is_object($orders)) : ?>

              <ul class="list-group">
                <?php $count = 0 ?>

                <?php foreach ($orders as $order) : ?>
                  <?php $count++ ?>
                  <?php $order_id     = $order['task_id'] ?>
                  <?php $notif_id     = $order_id ?>
                  <?php $user_id      = $order['user_id'] ?>
                  <?php $order_date   = $order['task_date_created']; ?>
                  <?php $date_format  = (date('Y') == date('Y', strtotime($order_date))) ? 'd M' : 'd M Y'; ?>
                  <?php $order_date   = change_date_format($order['task_date_created'], DATE_FORMAT, $date_format); ?>
                  <?php $order_state  = "Active"; ?>

                  <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark font-weight-bold text-sm">
                        <a class="text-dark font-weight-bolder" href="view?task=<?= $order_id ?>"> <?= $order['task_name'] ?> </a>
                        <a class="text-info font-weight-bolder" href="view?task=<?= $order_id ?>"> <?= $order_date ?> </a>
                      </h6>
                    </div>
                    <div class="d-flex align-items-center text-sm">
                      <span class="badge badge-lg bg-gradient-danger font-size-large">
                        <?= $order_state ?>
                      </span>
                      <a type="button" class="ms-2 font-weight-bolder" href="view?task=<?= $order_id ?>">
                         View
                      </a>
                      <!-- <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"><i class="fas fa-file-pdf text-lg me-1"></i> PDF</button> -->
                    </div>
                  </li>
                <?php endforeach; ?>

              </ul>
            <?php endif; ?>

          </div>
        </div>
      </div>

    </div>

    <div class="row mb-3">
      <div class="col-12">
        <div class="card h-100 bg-light">
          <div class="card-header pb-3 p-3">
            <div class="row">
              <div class="col-6/ col-12 d-flex align-items-center">
                <h6 class="mb-0">Task Management</h6>
              </div>
              <!-- <div class="col-6 text-end">
                <a class="btn btn-outline-dark btn-sm mb-0 fs-6 px-3" href="./activities"> <i class="fas fa-columns fs-6 me-2"></i> Task Activities</a>
              </div> -->
            </div>
          </div>
          <div class="card-body p-3 pb-0 mb-5">

            <div class="row">

              <div class="col col-md-6 col-lg-7">

                <div class="py-3 mb-3">
                  <?php $admin_pages ?>
                  <?php foreach ($admin_pages as $key => $admin_page) : ?>
                    <a class="text-dark fs-6 btn btn-outline-light btn-md bg-white mb-1 border-radius-lg" href="./<?= $admin_page['link'] ?>">
                      <span>
                        <i class="<?= $admin_page['imgs'] ?> <?= (($page == $key) ? 'white' : 'dark-col-custom') ?>" style="width: 22px; height: 22px;"></i>
                      </span>
                      <span class="nav-link-text ms-1"><?= $admin_page['short'] ?></span>
                    </a>
                  <?php endforeach; ?>
                </div>

                <hr class="horizontal dark mt-0">
                <h6 class="text-dark py-3 px-2 font-weight-bolder"> Settings </h6>


                <div class="card">

                  <div class="card-body pt-4 p-3">
                    <div class="mb-3">
                      <span class="text-secondary"> Management settings </sapn>
                    </div>

                    <button type="button" class="btn btn-dark border-radius-lg" onclick="requestModal(post_modal[19], post_modal[19], {})" <?= ((!$is_admin) ? 'disabled' : '') ?>>
                        <i class="fa-solid fa-user-group me-2"></i> Add user types
                    </button>

                    <button class="btn btn-sm btn-warning border-radius-lg px-3" type="button" onclick="requestModal(post_modal[17], post_modal[17], {'user_type':'guest'})" <?= ((!$is_admin) ? 'disabled' : '') ?>> 
                      Manage Task Categories 
                    </button>


                    <hr class="horizontal dark mt-0">


                  </div>
                </div>

              </div>

              <div class="col col-md-6 col-lg-5">
                <div class="card" style="height: 100%;">
                  <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Recent Activities</h6>
                  </div>
                  <div class="card-body pt-4 p-3">

                    <div class="col-row">
                      <div class="col-12 bg-white p-0 shadow/ border border-radius-lg" style="border-radius: 20px">
                          <table class="table table-striped table-sm">
                              <thead class="thead-light">
                                  <tr class="">
                                      <th scope="col" class="px-1" style="width:1px">User</th>
                                      <th scope="col" class="px-1" style="width:1px">Activity</th>
                                      <th scope="col" class="px-1" style="width:1px">Task</th>
                                      <th scope="col" class="px-1">Date</th>
                                  </tr>
                              </thead>
                              <tbody class="text-secondary">
                                  <?php $count = 0 ?>
                                  <?php if (is_array($task_history) || is_object($task_history)) : ?>
                                    <?php foreach ($task_history as $key => $history): ?>
                                        <?php $count ++ ?>
                                        <?php $task_date    = date("Y-m-d H:i:s", strtotime($history['history_date_created'])) ?>
                                        <?php $user         = get_user_by_id($history['user_id']) ?>
                                        <?php $image        = (($user != null) ? img_path(ABS_USER_PROFILE, $user['user_image'], 1) : '') ?>
                                            
                                        <tr>
                                            <th class="text-center/" scope="row">
                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?= $user['name'] . ' ' . $user['last_name'] ?>">
                                                    <img src="<?= $image ?>" width="35" class="border-radius-lg rounded rounded-circle" alt="...">
                                                </span>
                                            </th>
                                            <td> <span> <?= ((!empty($history['activity_type'])) ? ucfirst($history['activity_type']) : '') ?> </span> </td>
                                            <td> <span> <?= ((!empty($history['task_name'])) ? ucfirst($history['task_name']) : '') ?> </span> </td>
                                            <td> <span class=""> <?= date("d/m/Y", strtotime($task_date)) ?> </span> </td>
                                        </tr>
                                    <?php endforeach ?>
                                  <?php endif ?>
                              </tbody>
                          </table>
                      </div>
                  </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<form action="">
  <input type="hidden" id="labels_data" name="labels_data" value='<?= $sales_labels ?>'>
  <input type="hidden" id="sales_data" name="sales_data" value='<?= $sales_data ?>'>
  <input type="hidden" id="order_data" name="order_data" value='<?= $order_data ?>'>
</form>
