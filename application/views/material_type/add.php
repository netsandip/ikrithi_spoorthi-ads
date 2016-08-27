<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Material Type</h1>
        <a href="<?php echo base_url() . "material_type/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>
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
                    <?php echo form_reset('btn_reset', 'Clear', array('class' => 'btn btn-default')); ?>
                    &nbsp;
                    <?php echo form_submit('btn_submit', 'Save', array('class' => 'btn btn-primary')); ?>
                </div>
                <?php echo form_close(); ?>
            </div><!-- /.col-md-6 -->
        </div><!-- /.row -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->