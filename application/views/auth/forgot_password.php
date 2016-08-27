<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo lang('forgot_password_heading'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php if ($message) { ?>
                        <?php echo alert_message($message, 'error'); ?>
                    <?php } ?>
                    <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
                    <?php echo form_open("auth/forgot_password"); ?>
                    <fieldset>
                        <div class="form-group">
                            <?php echo form_input($identity, '', array('autofocus' => '', 'class' => 'form-control', 'placeholder' => (($type == 'email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label)))); ?>
                        </div>
                        <?php echo form_submit('submit', lang('forgot_password_submit_btn'), array('class' => 'btn btn-lg btn-success btn-block')); ?>
                        <?php echo anchor(base_url(), "<i class='fa fa-chevron-left'></i>&nbsp; Back", array('class' => 'btn btn-block')); ?>
                    </fieldset>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>