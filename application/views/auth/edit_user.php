<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo lang('edit_user_heading'); ?></h1>
        <p><?php echo lang('edit_user_subheading'); ?></p>
    </div>
</div>

<div id="infoMessage"><?php echo $message; ?></div>

<?php echo form_open(uri_string()); ?>

<p>
    <?php echo lang('edit_user_fname_label', 'first_name'); ?> <br />
    <?php echo form_input($first_name); ?>
</p>

<p>
    <?php echo lang('edit_user_lname_label', 'last_name'); ?> <br />
    <?php echo form_input($last_name); ?>
</p>

<!--      <p>
<?php // echo lang('edit_user_company_label', 'company');?> <br />
<?php // echo form_input($company);?>
      </p>-->

<p>
    <?php echo lang('edit_user_phone_label', 'phone'); ?> <br />
    <?php echo form_input($phone); ?>
</p>

<p>
    <?php echo lang('edit_user_password_label', 'password'); ?> <br />
    <?php echo form_input($password); ?>
</p>

<p>
    <?php echo lang('edit_user_password_confirm_label', 'password_confirm'); ?><br />
    <?php echo form_input($password_confirm); ?>
</p>

<p>
    <?php echo form_label('Role'); ?><br />
    <?php
    $userACL = new My_Acl(array('user_id' => $user->id));
    $user_roles = $userACL->getUserRoles();
    $roles = $this->my_acl->getAllRoles();
    $dropdown_roles = array();
    $dropdown_roles['options'][''] = 'Select Role';
    foreach ($roles as $k => $v) {
        $dropdown_roles['options'][$v] = $this->my_acl->getRoleNameFromID($v);
    }
    if (!empty($user_roles)) {
        $dropdown_roles['default'] = $user_roles[0];
    } else {
        $dropdown_roles['default'] = set_value('role');
    }
    echo form_dropdown('role', $dropdown_roles['options'], $dropdown_roles['default']);
    ?>
</p>

<?php /* if ($this->ion_auth->is_admin()): ?>

  <h3><?php echo lang('edit_user_groups_heading');?></h3>
  <?php foreach ($groups as $group):?>
  <label class="checkbox">
  <?php
  $gID=$group['id'];
  $checked = null;
  $item = null;
  foreach($currentGroups as $grp) {
  if ($gID == $grp->id) {
  $checked= ' checked="checked"';
  break;
  }
  }
  ?>
  <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
  <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
  </label>
  <?php endforeach?>

  <?php endif */ ?>

<?php echo form_hidden('id', $user->id); ?>
<?php echo form_hidden($csrf); ?>

<p><?php echo form_submit('submit', lang('edit_user_submit_btn')); ?></p>

<?php echo form_close(); ?>
