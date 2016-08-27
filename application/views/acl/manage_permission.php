<?php
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'savePerm':
            $strSQL = sprintf("REPLACE INTO `acl_permissions` SET `id` = %u, `perm_name` = '%s', `perm_key` = '%s'", $_POST['permID'], $_POST['permName'], $_POST['permKey']);
            $this->db->query($strSQL);
            break;
        case 'delPerm':
            $strSQL = sprintf("DELETE FROM `acl_permissions` WHERE `id` = %u LIMIT 1", $_POST['permID']);
            $this->db->query($strSQL);
            break;
    }
    header("location: " . base_url('acl/permissions'));
}
?>
<?php if (!isset($_GET['action']) || $_GET['action'] == '') { ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Select a Permission to Manage:</h1>
        </div>
    </div>
    <?php
    $roles = $this->my_acl->getAllPerms('full');
    if (count($roles) < 1) {
        echo "No permissions yet.<br />";
    } else {
        echo '<ul class="list-unstyled">';
        foreach ($roles as $k => $v) {
            echo "<li>";
            echo "<p>";
            echo "<a href=\"?action=perm&permID=" . $v['id'] . "\">" . $v['name'] . "</a><br />";
            echo "</p>";
            echo "</li>";
        }
        echo "</ul>";
    }
    ?>
    <input class="btn btn-primary" type="button" name="New" value="New Permission" onclick="window.location = '?action=perm&permID='" />
<?php } ?>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'perm') {
    if (!isset($_GET['permID']) || $_GET['permID'] == '') {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">New Permission:</h1>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Permission: (<?php echo $this->my_acl->getPermNameFromID($_GET['permID']); ?>)</h1>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-lg-6">
            <form class="form-horizontal" action="<?php echo base_url('acl/permissions'); ?>" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="permName">Name:</label>
                    <div class="col-sm-10">
                        <input autofocus="true" class="form-control" type="text" name="permName" id="permName" value="<?php echo $this->my_acl->getPermNameFromID($_GET['permID']); ?>" maxlength="30" /><br />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="permKey">Key:</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="permKey" id="permKey" value="<?php echo $this->my_acl->getPermKeyFromID($_GET['permID']); ?>" maxlength="30" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="action" value="savePerm" />
                        <input type="hidden" name="permID" value="<?php echo $_GET['permID']; ?>" />
                        <input class="btn btn-primary" type="submit" name="Submit" value="Submit" />
                        <a class="btn btn-default" href="<?php echo base_url('acl/permissions'); ?>">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if (!empty($_GET['permID'])) { ?>
        <form action="<?php echo base_url('acl/permissions'); ?>" method="post">
            <input type="hidden" name="action" value="delPerm" />
            <input type="hidden" name="permID" value="<?php echo $_GET['permID']; ?>" />
            <input class="btn btn-danger" type="submit" name="Delete" value="Delete" />
        </form>
    <?php } ?>
<?php } ?>