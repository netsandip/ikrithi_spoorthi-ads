<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Ad Type</h1>
        <a href="<?php echo base_url() . "ad_type/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <?php if ($message != "") { ?>
            <?php echo $message; ?>
        <?php } ?>
        <div class="row">
            <div class="col-md-6">
                <?php echo form_open($action); ?>
                <div class="form-group">
                    <?php echo form_label('Name', 'name'); ?>
                    <?php echo form_input($input_name, '', array('class' => 'form-control','autofocus' => 'autofocus')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Vendor Type', 'vendor_type'); ?>
                    <?php echo form_dropdown('vendor_type',$vendor_type['options'], $vendor_type['default'], array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Size', 'size'); ?>
                    <?php echo form_dropdown('size',$sizes['options'], $sizes['default'], array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_reset('btn_reset', 'Clear', array('class' => 'btn btn-default')); ?>
                    &nbsp;
                    <?php echo form_submit('btn_submit', 'Save', array('class' => 'btn btn-primary')); ?>
                </div>
                <?php echo form_close(); ?>
            </div><!-- /.col-md-6 -->
        </div><!-- /.row -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->