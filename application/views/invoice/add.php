<style>
    #invoice-header {
        display: none;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Invoice</h1>
        <a href="<?php echo base_url() . "invoice/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <?php if ($message != "") { ?>
            <?php echo $message; ?>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <?php echo form_open($action, array('name' => 'frm_invoice')); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo form_dropdown('client', $dropdown_client['options'], $dropdown_client['default'], array('class' => 'form-control', 'onchange' => 'loadRO(this)')); ?>
                        </div>
                        <div id="release_orders"></div>
                    </div>
                    <div id="invoice-header" class="col-md-6">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr><th class="text-center info">PAN No.</th><th class="text-center">APIPK1234F</th></tr>
                                <tr><th class="text-center info">Bill No.</th><th class="text-center">-- auto generated --</th></tr>
                                <tr><th class="text-center info">PO No.</th><th class="text-center"></th></tr>
                                <tr><th class="text-center info">Date</th><th class="text-center"><?php echo date('d-M-y', time()); ?></th></tr>
                                <tr><th class="text-center info">Mail</th><th class="text-center"><?php echo 'accounts@spoorthiads.com'; ?></th></tr>
                            </thead>
                        </table>
                        <div class="form-group">
                            <?php echo form_label('Hue'); ?>
                            <?php echo form_input($input_hue,'',array('class' => 'form-control')); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="order-items" class="col-md-12"></div>
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