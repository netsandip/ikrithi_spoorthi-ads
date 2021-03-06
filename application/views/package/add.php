<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Package</h1>
        <a href="<?php echo base_url() . "package/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>
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
                    <?php echo form_input($input_name, '', array('class' => 'form-control', 'autofocus' => 'autofocus')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Publication', 'publication'); ?>
                    <?php echo form_dropdown('publication', $dropdown_publication['options'], $dropdown_publication['default'], array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Ad Type', 'ad_type'); ?>
                    <?php echo form_dropdown('ad_type', $dropdown_ad_type['options'], $dropdown_ad_type['default'], array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Paid', 'paid'); ?>
                    <?php echo form_input($input_paid, '', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Free', 'free'); ?>
                    <?php echo form_input($input_free, '', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Description', 'description'); ?>
                    <?php echo form_textarea($textarea_description, '', array('class' => 'form-control')); ?>
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