<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Vendor</h1>
        <a href="<?php echo base_url() . "vendor/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <?php if (isset($message) && $message != "") { ?>
            <?php echo $message; ?>
        <?php } ?>
        <div class="row">
            <?php $hidden_fields['parent_id'] = 0; ?>
            <?php
            if (isset($vendor_id)) {
                $hidden_fields['parent_id'] = 0;
            }
            ?>
            <?php echo form_open($action, '', $hidden_fields); ?>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo form_label('Company Name', 'company_name'); ?>
                    <?php echo form_input($input_company_name, '', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Company Phone', 'company_phone'); ?>
                    <?php echo form_input($input_company_phone, '', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Commission', 'commission'); ?>
                    <?php echo form_input($input_commission, '', array('class' => 'form-control')); ?>
                </div>

                <div class="form-group">
                    <?php echo form_label('Address', 'address'); ?>
                    <?php echo form_textarea($input_address, '', array('class' => 'form-control')); ?>
                </div>
            </div><!-- /.col-md-6 -->
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo form_label('Select Publications', 'publications[]'); ?>
                    <?php echo form_multiselect('publications[]', $dropdown_publication['options'], $dropdown_publication['default'], array('class' => 'form-control', 'size' => 10)); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Vendor Type', 'vendor_type'); ?>
                    <?php echo form_dropdown('vendor_type', $dropdown_vendor_type['options'], $dropdown_vendor_type['default'], array('class' => 'form-control')); ?>
                </div>
            </div><!-- /.col-md-6 -->
            <?php if (!isset($vendor_id)) { ?>
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Coordinator Details
                        </div>
                        <div class="panel-body" style="padding: 0;">
                            <div class="table-responsive">
                                <table class="table table-hover " style="margin: 0;">
                                    <thead>
                                        <tr>
                                            <th><?php echo form_label('Fullname', 'fullname'); ?></th>
                                            <th><?php echo form_label('Phone', 'phone'); ?></th>
                                            <th><?php echo form_label('Email', 'email'); ?></th>
                                            <th><?php echo form_label('Designation', 'designation'); ?></th>
                                            <th><label>Action</label></th>
                                        </tr>
                                    </thead>
                                    <tbody class="form_coordinator">
                                        <tr>
                                            <td><?php echo form_input($input_fullname, '', array('class' => 'form-control')); ?></td>
                                            <td><?php echo form_input($input_phone, '', array('class' => 'form-control')); ?></td>
                                            <td><?php echo form_input($input_email, '', array('class' => 'form-control')); ?></td>
                                            <td><?php echo form_input($input_designation, '', array('class' => 'form-control')); ?></td>
                                            <td class="text-center"><a class="btn btn-danger btn-sm disabled"><i class="fa fa-remove"></i></a></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr><td colspan="6">
                                                <a id="btn_add_vendor_coordinator" class="btn btn-success btn-mini pull-right">More <i class="fa fa-plus"></i></a>
                                            </td></tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col-md-12 -->
            <?php } ?>
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo form_reset('btn_reset', 'Clear', array('class' => 'btn btn-default')); ?>
                    &nbsp;
                    <?php echo form_submit('btn_submit', 'Save', array('class' => 'btn btn-primary')); ?>
                </div>
            </div><!-- /.col-md-12 -->
            <?php echo form_close(); ?>
        </div><!-- /.row -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php if (!isset($vendor_id)) { ?>
    <script type="text/javascript">
        var vendor_form_coordinator_fullname = '<?php echo form_input($input_fullname, '', array('class' => 'form-control')); ?>';
        var vendor_form_coordinator_phone = '<?php echo form_input($input_phone, '', array('class' => 'form-control')); ?>';
        var vendor_form_coordinator_email = '<?php echo form_input($input_email, '', array('class' => 'form-control')); ?>';
        var vendor_form_coordinator_designation = '<?php echo form_input($input_designation, '', array('class' => 'form-control')); ?>';
    </script>
<?php
}