<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">User Report</h1>
        <a href="<?php echo base_url() . "invoice/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <?php /* if ($message != "") { ?>
          <?php echo $message; ?>
          <?php } */ ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="input-sm form-control" name="start" />
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control" name="end" />
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit" />
                </div>
            </div><!-- /.col-md-6 -->
        </div><!-- /.row -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->