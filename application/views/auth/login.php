<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo lang('login_heading'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php if ($message) { ?>
                        <?php echo alert_message($message, 'error'); ?>
                    <?php } ?>
                    <?php echo form_open("auth/login"); ?>
                    <fieldset>
                        <div class="form-group">
                            <!--<input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>-->
                            <?php echo form_input($identity, '', array('autofocus' => '', 'class' => 'form-control', 'placeholder' => lang('login_identity_label'))); ?>
                        </div>
                        <div class="form-group">
                            <!--<input class="form-control" placeholder="Password" name="password" type="password" value="">-->
                            <?php echo form_input($password, '', array('class' => 'form-control', 'placeholder' => lang('login_password_label'))); ?>
                        </div>
                        <div class="checkbox">
                            <label>
                                <!--<input name="remember" type="checkbox" value="Remember Me">Remember Me-->
                                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                                <?php echo lang('login_remember_label'); ?>
                            </label>
                            <a class="pull-right" href="forgot_password"><?php echo lang('login_forgot_password'); ?></a>
                        </div>
                        <!-- Change this to a button or input when using this as a form -->
                        <!--<a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>-->
                        <?php echo form_submit('submit', lang('login_submit_btn'), array('class' => 'btn btn-lg btn-success btn-block')); ?>
                    </fieldset>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>