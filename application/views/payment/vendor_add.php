<style>    .hide_block{        display: none;    }</style><div class="row">    <div class="col-lg-12">        <h1 class="page-header">Vendor Payment</h1>        <a href="<?php echo base_url() . "payment/vendor"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>    </div><!-- /.col-lg-12 --></div><!-- /.row --><div class="row">    <div class="col-lg-12">        <?php if ($message != "") { ?>            <?php echo $message; ?>        <?php } ?>        <div class="row">            <div class="col-md-12">                <?php echo form_open($action, array('name' => 'frm_invoice')); ?>                <div class="row">                    <div class="col-md-6">                        <div class="form-group">                            <?php echo form_dropdown('vendor', $dropdown_vendor['options'], $dropdown_vendor['default'], array('class' => 'form-control', 'onchange' => 'loadRO(this)')); ?>                        </div>                        <div id="release_orders"></div>                    </div>                    <div class="col-md-12">                        <div id="release_order_details"></div>                    </div>                    <div class="col-md-6">                        <div class="hide_block">                            <div class="form-group">                                <?php                                echo form_label('Vendor Receipt Number');                                echo form_input('vendor_receipt_no', set_value('vendor_receipt_no'), array('class' => 'form-control'));                                ?>                            </div>                            <div class="form-group"><?phpecho form_label('Enter Amount');echo form_input('amount', set_value('amount'), array('class' => 'form-control'));?>                            </div>                            <div class="form-group"><?php//                                echo form_label('Enter Amount');$payment_mode_dd = array(    '' => 'Select mode of payment',    'cash' => 'Cash',    'cheque' => 'Cheque',);echo form_dropdown('payment_mode', $payment_mode_dd, set_value('payment_mode'), array('class' => 'form-control', 'onchange' => 'paymentMode(this.value)'));?>                            </div>                            <div class="form-group">                                <?php                                echo form_label('Reference Number');                                echo form_input('ref_no', set_value('ref_no'), array('class' => 'form-control', 'disabled' => 'disabled'));                                ?>                            </div>                        </div>                    </div>                </div>                <div class="form-group">                                <?php echo form_reset('btn_reset', 'Clear', array('class' => 'btn btn-default')); ?>                    &nbsp;<?php echo form_submit('btn_submit', 'Save', array('class' => 'btn btn-primary')); ?>                </div><?php echo form_close(); ?>            </div><!-- /.col-md-6 -->        </div><!-- /.row -->    </div><!-- /.col-lg-12 --></div><!-- /.row -->