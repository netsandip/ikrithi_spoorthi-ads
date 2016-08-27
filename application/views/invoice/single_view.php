<style>    #invoice-header {        display: none;    }</style><div class="row">    <div class="col-lg-12">        <h1 class="page-header">Invoice</h1>        <a href="<?php echo base_url() . "invoice/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>    </div><!-- /.col-lg-12 --></div><!-- /.row --><div class="row">    <div class="col-lg-12">        <?php if ($message != "") { ?>            <?php echo $message; ?>        <?php } ?>        <div class="row">            <div class="col-md-12">                <div class="row">                    <div class="col-md-6">                        <table class="table table-bordered table-condensed">                            <thead>                                <tr><th class="info">Client Name</th><th class="text-center"><?php echo $invoice->client_name; ?></th></tr>                                <tr><th class="info">Caption</th><th class="text-center"><?php echo $invoice_orders[0]->caption; ?></th></tr>                                <tr><th class="info">Type</th><th class="text-center"><?php echo $invoice_orders[0]->advertisement_type; ?></th></tr>                                <tr>                                    <th class="info" style="vertical-align:top;">Release Orders</th>                                    <th class="text-center" id="release_orders">                                        <?php//                                        echo form_multiselect('release_order[]', $dropdown_release_order['options'], $dropdown_release_order['default'], array('class' => 'form-control', 'disabled' => 'disabled'));                                        foreach ($dropdown_release_order['options'] as $release_order) {                                            echo $release_order . " ";                                        }                                        ?>                                    </th>                                </tr>                                <tr>                                    <th class="info" style="vertical-align:top;">Hue</th>                                    <th class="text-center" id="release_orders">                                        <?php echo $invoice->hue; ?>                                    </th>                                </tr>                            </thead>                        </table>                    </div>                    <div class="col-md-6">                        <table class="table table-bordered table-condensed">                            <thead>                                <tr><th class="text-center info">PAN No.</th><th class="text-center">APIPK1234F</th></tr>                                <tr><th class="text-center info">Bill No.</th><th class="text-center"><?php echo $invoice->invoice_no; ?></th></tr>                                <tr><th class="text-center info">PO No.</th><th class="text-center"></th></tr>                                <tr><th class="text-center info">Date</th><th class="text-center"><?php echo date('d-M-y', time()); ?></th></tr>                                <tr><th class="text-center info">Mail</th><th class="text-center"><?php echo 'accounts@spoorthiads.com'; ?></th></tr>                            </thead>                        </table>                    </div>                </div>                <div class="row">                    <div id="order-items" class="col-md-12">                        <table class="table table-bordered table-condensed">                            <colgroup>                                <col style="width:5%">                                <col style="width:20%">                                <col style="width:10%">                                <col style="width:10%">                                <col style="width:10%">                                <col style="width:10%">                                <col style="width:15%">                                <col style="width:10%">                                <col style="width:10%">                            </colgroup>                            <thead>                                <tr>                                    <th>#</th>                                    <th>RO No</th>                                    <th>Publication</th>                                    <th>Edition</th>                                    <th>Size</th>                                    <th>Date</th>                                    <th>Page</th>                                    <th class="text-right">Base Rate</th>                                    <th class="text-right">Amount</th>                                </tr>                            </thead>                            <tbody>                                <?php                                $index = 1;                                $total_base_rate = 0;                                $total_amount = 0;                                ?>                                <?php foreach ($invoice_order_items as $invoice_order_item) { ?>                                    <?php                                    $release_order_item_id = $index;                                    ?>                                    <?php//                                    print_r($invoice_order_item);                                    $size_arr = explode("_", $invoice_order_item->size);                                    if (isset($size_arr[1])) {                                        $size = $size_arr[0] * $size_arr[1];                                        $size_str = $size_arr[0] . ' x ' . $size_arr[1];                                    } else {                                        $size = $size_arr[0];                                        $size_str = $size_arr[0];                                    }                                    $amount = $invoice_order_item->base_rate * $size;                                    $total_base_rate += $invoice_order_item->base_rate;                                    $total_amount += $amount;                                    ?>                                    <tr>                                        <td><?php echo $index; ?></td>                                        <td><?php echo $invoice_order_item->release_order_no; ?></td>                                        <td><?php echo $invoice_order_item->publication; ?></td>                                        <td><?php echo $invoice_order_item->edition; ?></td>                                        <td><?php echo $size_str; ?></td>                                        <td><?php echo date('d/m/Y', strtotime($invoice_order_item->insertion_date)); ?></td>                                        <td><?php echo $invoice_order_item->page; ?></td>                                        <?php                                        if ($invoice_order_item->package == "") {                                            $html = '<td class="text-right">';//                                            $html .= form_input('base_rate[' . $release_order_item_id . ']', $invoice_order_item->base_rate, array('class' => 'form-control base_rate', 'onkeyup' => 'updateAmount(this.value,\'' . $invoice_order_item->size . '\',\'amount' . $index . '\')'));                                            $html .= $invoice_order_item->base_rate;                                            $html .= '</td>';                                        } else {                                            $hidden_input_base_rate = array(                                                'type' => 'hidden',                                                'name' => 'base_rate[' . $release_order_item_id . ']',                                                'value' => $invoice_order_item->base_rate,                                                'class' => 'base_rate'                                            );                                            $html = form_input($hidden_input_base_rate);                                            $html .= '<td>' . $invoice_order_item->package . '</td>';                                        }                                        echo $html;                                        ?>                                                            <!--<td class="text-right"><?php // echo $invoice_order_item->base_rate;  ?></td>-->                                        <td class="text-right amount" id="amount<?php echo $index; ?>"><?php echo number_format($amount, 2, '.', ''); ?></td>                                    </tr>                                    <?php $index++; ?>                                <?php } ?>                            </tbody>                            <tfoot>                                <tr>                                    <th colspan="7" class="text-right"><strong>TOTAL</strong></th>                                    <th class="text-right"><strong id="total_base_rate"><?php echo number_format($total_base_rate, 2, '.', ''); ?></strong></th>                                    <th class="text-right"><strong id="total_amount"><?php echo number_format($total_amount, 2, '.', ''); ?></strong></th>                                </tr>                            </tfoot>                        </table>                    </div>                </div>                <div class="form-group">                    <a class="btn btn-primary">Print</a>                    <a href="<?php echo base_url('invoice'); ?>" class="btn btn-default">Back</a>                </div>            </div><!-- /.col-md-6 -->        </div><!-- /.row -->    </div><!-- /.col-lg-12 --></div><!-- /.row -->