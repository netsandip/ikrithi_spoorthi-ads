<?php
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'saveRole':
            $strSQL = sprintf("REPLACE INTO `acl_roles` SET `id` = %u, `role_name` = '%s'", $_POST['roleID'], $_POST['roleName']);
            $this->db->query($strSQL);
            if ($this->db->affected_rows() > 1) {
                $roleID = $_POST['roleID'];
            } else {
                $roleID = $this->db->insert_id();
            }
            foreach ($_POST as $k => $v) {
                if (substr($k, 0, 5) == "perm_") {
                    $permID = str_replace("perm_", "", $k);
                    if ($v == 'X') {
                        $strSQL = sprintf("DELETE FROM `acl_role_perms` WHERE `role_id` = %u AND `perm_id` = %u", $roleID, $permID);
                        $this->db->query($strSQL);
                        continue;
                    }
                    $strSQL = sprintf("REPLACE INTO `acl_role_perms` SET `role_id` = %u, `perm_id` = %u, `value` = %u, `add_date` = '%s'", $roleID, $permID, $v, date("Y-m-d H:i:s"));
                    $this->db->query($strSQL);
                }
            }
            header("location: " . base_url('acl/roles'));
            break;
        case 'delRole':
            $strSQL = sprintf("DELETE FROM `acl_roles` WHERE `ID` = %u LIMIT 1", $_POST['roleID']);
            $this->db->query($strSQL);
            $strSQL = sprintf("DELETE FROM `acl_user_roles` WHERE `roleID` = %u", $_POST['roleID']);
            $this->db->query($strSQL);
            $strSQL = sprintf("DELETE FROM `acl_role_perms` WHERE `roleID` = %u", $_POST['roleID']);
            $this->db->query($strSQL);
            header("location: " . base_url('acl/roles'));
            break;
    }
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Select a Role to Manage:</h1>
                <!--<a href="<?php // echo base_url() . "ad_type/add";        ?>" class="btn btn-primary pull-right btn-top-right">Add</a>-->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">

    <div class="col-lg-6">
        <?php
        $roles = $this->my_acl->getAllRoles('full');
        if (count($roles) < 1) {
            echo "No roles yet.<br/ >";
        } else {
            echo '<ul class="list-unstyled">';
            foreach ($roles as $k => $v) {
                echo "<li>";
                echo "<p>";
                echo "<a href=\"?action=role&roleID=" . $v['id'] . "\">" . $v['name'] . "</a><br/ >";
                echo "</p>";
                echo "</li>";
            }
            echo "</ul>";
        }
        ?>
        <input class="btn btn-primary" type="button" name="New" value="New Role" onclick="window.location = '?action=role&roleID='" />
    </div>
    <div class="col-lg-6">
        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'role') {
            if (!isset($_GET['roleID']) || $_GET['roleID'] == '') {
                ?>
                <p class="lead">New Role:</p>
            <?php } else { ?>
                <p class="lead">Manage Role: (<?php echo $this->my_acl->getRoleNameFromID($_GET['roleID']); ?>)</p>
            <?php } ?>
            <form class="form-horizontal" action="<?php echo base_url('acl/roles'); ?>" method="post">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="roleName">Name</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="roleName" id="roleName" value="<?php echo $this->my_acl->getRoleNameFromID($_GET['roleID']); ?>" />
                    </div>
                </div>
                <table class="table table-condensed table-hover">
                    <tr><th>Permission</th><th>Allow</th><th>Deny</th><th>Ignore</th></tr>
                    <?php
                    $rPerms = $this->my_acl->getRolePerms($_GET['roleID']);
                    $aPerms = $this->my_acl->getAllPerms('full');
                    foreach ($aPerms as $k => $v) {
                        echo "<tr><td><label>" . $v['name'] . "</label></td>";
                        echo "<td><input type=\"radio\" name=\"perm_" . $v['id'] . "\" id=\"perm_" . $v['id'] . "_1\" value=\"1\"";
                        if (isset($rPerms[$v['key']]) && $rPerms[$v['key']]['value'] === true && $_GET['roleID'] != '') {
                            echo " checked=\"checked\"";
                        }
                        echo " /></td>";
                        echo "<td><input type=\"radio\" name=\"perm_" . $v['id'] . "\" id=\"perm_" . $v['id'] . "_0\" value=\"0\"";
                        if (isset($rPerms[$v['key']]) && $rPerms[$v['key']]['value'] != true && $_GET['roleID'] != '') {
                            echo " checked=\"checked\"";
                        }
                        echo " /></td>";
                        echo "<td><input type=\"radio\" name=\"perm_" . $v['id'] . "\" id=\"perm_" . $v['id'] . "_X\" value=\"X\"";
                        if ($_GET['roleID'] == '' || !array_key_exists($v['key'], $rPerms)) {
                            echo " checked=\"checked\"";
                        }
                        echo " /></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <input type="hidden" name="action" value="saveRole" />
                <input type="hidden" name="roleID" value="<?php echo $_GET['roleID']; ?>" />
                <input class="btn btn-primary" type="submit" name="Submit" value="Submit" />
                <a class="btn btn-default" href="<?php echo base_url('acl/roles'); ?>">Cancel</a>
            </form>
            <form class="form-horizontal pull-right" action="<?php echo base_url('acl/roles'); ?>" method="post">
                <input type="hidden" name="action" value="delRole" />
                <input type="hidden" name="roleID" value="<?php echo $_GET['roleID']; ?>" />
                <input class="btn btn-danger" type="submit" name="Delete" value="Delete" />
            </form>
        <?php } ?>
    </div>
</div>