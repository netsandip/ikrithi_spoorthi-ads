<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo lang('index_heading'); ?></h1>
        <a href="<?php echo base_url() . "invoice/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">

        <div id="infoMessage"><?php echo $message; ?></div>

        <table class="table" cellpadding=0 cellspacing=10>
            <tr>
                <th><?php echo lang('index_fname_th'); ?></th>
                <th><?php echo lang('index_lname_th'); ?></th>
                <th><?php echo lang('index_email_th'); ?></th>
                <!--<th><?php // echo lang('index_groups_th');   ?></th>-->
                <th><?php echo 'Role'; ?></th>
                <th><?php echo lang('index_status_th'); ?></th>
                <th><?php echo lang('index_action_th'); ?></th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($user->lastname, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                    <!--<td>-->
                    <?php /* foreach ($user->groups as $group): ?>
                      <?php echo anchor("auth/edit_group/" . $group->id, htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')); ?><br />
                      <?php endforeach */ ?>
                    <!--</td>-->
                    <td>
                        <?php
                        $userACL = new My_Acl(array('user_id' => $user->id));
                        $user_roles = $userACL->getUserRoles();
                        if (!empty($user_roles)) {
                            echo $this->my_acl->getRoleNameFromID($user_roles[0]);
                        } else {
                            echo 'No Role Assigned';
                        }
                        ?>
                    </td>
                    <td><?php echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); ?></td>
                    <td><?php echo anchor("auth/edit_user/" . $user->id, 'Edit'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <p><?php echo anchor('auth/create_user', lang('index_create_user_link')) ?></p>
        <!--<p><?php // echo anchor('auth/create_user', lang('index_create_user_link')) ?> | <?php // echo anchor('auth/create_group', lang('index_create_group_link')) ?></p>-->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->