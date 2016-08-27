<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Publication</h1>
        <a href="<?php echo base_url() . "publication/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>
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
                    <label>Select Edition</label>
                    <div class="checkbox-list">
                        <?php foreach ($checkbox_edition as $key => $edition) { ?>
                            <div class="checkbox-item">
                                <?php echo form_checkbox($edition); ?>
                                <?php echo form_label($key, $edition['id']); ?>
                            </div>
                        <?php } ?>
                    </div>
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