<form id="passResetForm" class="form col-12" action="index.html" method="post">
  <br>
  <hr>

  <div id="message_err" class="message"></div>
  <!-- <label for="contact">User information</label> -->
  <div class="form-row/ align-items-center">
    <div class="col-auto/">
      <small style="padding-left: 15px;">Username</small>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text text-default-cstm"> <i class="fa fa-user input_color"></i> </div>
        </div>
        <input type="text" class="form-control" id="reset_username" name="reset_username" value="<?= ((isset($user['email'])) ? $user['email'] : '') ?>" placeholder="Username" disabled>
      </div>
    </div>

  </div>
  <div class="form-row/ align-items-center">
    <div class="col-auto/">
      <small style="padding-left: 15px;"><?= $new_pass ?></small>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text text-default-cstm"> <i class="fa fa-unlock-alt" aria-hidden="true"></i> </div>
        </div>
        <input type="password" class="form-control mb-2/" id="pass_reset" name="pass_reset" value="" placeholder="<?= $new_pass ?>">
      </div>
    </div>
  </div>
  <div class="form-row/ align-items-center">
    <div class="col-auto/">
      <small style="padding-left: 15px;"><?= $con_pass ?></small>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text text-default-cstm"> <i class="fa fa-unlock-alt" aria-hidden="true"></i> </div>
        </div>
        <input type="password" class="form-control mb-2/" id="pass_confirm" name="pass_confirm" value="" placeholder="<?= $con_pass ?>">
      </div>
    </div>
  </div>
  <input id="reset_token" type="hidden" name="reset_key" value="<?= ((isset($token)) ? $token : null) ?>">
  &nbsp;
  <br>
  <input id="submitPassResetForm" type="button" class="btn btn-sm btn-default-teel btn-success col-12" onclick="postCheck('message_err', {'reset_username': $('#username').val(), 'pass_reset': $('#pass_reset').val(), 'pass_confirm': $('#pass_confirm').val(), 'reset_token': $('#reset_token').val()});" style="border-radius: 35px;" value="Submit" />

</form>