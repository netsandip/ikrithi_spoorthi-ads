<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Vendor Report</h1>
        <!--<a href="<?php echo base_url() . "invoice/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>-->
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
                    <div class="input-daterange input-group" id="datepicker">
                        <?php echo form_input('start', set_value('start'), array('class' => 'input-sm form-control', 'placeholder' => 'From')) ?>
                        <span class="input-group-addon">to</span>
                        <?php echo form_input('end', set_value('end'), array('class' => 'input-sm form-control', 'placeholder' => 'To')) ?>
<!--                        <input type="text" class="input-sm form-control" name="start" />
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control" name="end" />-->
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit" />
                </div>
                <?php echo form_close(); ?>
            </div><!-- /.col-md-6 -->
            <?php if (isset($records) && $records !== FALSE) { ?>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <colgroup>
                                <col style="width:40%" />
                                <col style="width:30%" />
                                <col style="width:20%" />
                                <col style="width:10%" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>Client</th>
                                    <th>RO No</th>
                                    <th>Ad Type</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $grand_total = 0;
                                foreach ($records as $record) {
                                    $order_items = $this->release_order_model->get_release_order_items($record->id);
                                    $order_amount = 0;
                                    foreach ($order_items as $order_item) {
                                        $size_arr = explode("_", $order_item->size);
                                        if (isset($size_arr[1])) {
                                            $size = $size_arr[0] * $size_arr[1];
                                        } else {
                                            $size = $size_arr[0];
                                        }
                                        $order_amount += $size * $order_item->base_rate;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $record->client_name; ?></td>
                                        <td><?php echo $record->vendor_name; ?></td>
                                        <td><?php echo $record->release_order_no; ?></td>
                                        <td><?php echo $record->advertisement_name; ?></td>
                                        <td class="text-center"><?php echo date('d/m/Y', strtotime($record->created)); ?></td>
                                        <td class="text-right"><?php echo number_format($order_amount,2); ?></td>
                                    </tr>
                                    <?php
                                    $grand_total += $order_amount;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="5"><strong>TOTAL</strong></td>
                                    <td class="text-right info"><strong><?php echo number_format($grand_total,2); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div><!-- /.col-md-12 -->
            <?php } ?>
        </div><!-- /.row -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->