<div class="row">    <div class="col-lg-12">        <h1 class="page-header">Advertisement Release Order</h1>        <a href="<?php echo base_url() . "release_order/"; ?>" class="btn btn-primary pull-right btn-top-right">View</a>    </div><!-- /.col-lg-12 --></div><!-- /.row --><div class="row">    <div class="col-lg-12">        <?php if ($message != "") { ?>            <?php echo $message; ?>        <?php } ?>        <div class="row">            <div class="col-md-12">                <div class="row">                    <div class="col-md-6">                        <div class="form-group">                            <?php echo form_label("To, ") . "<br>"; ?>                            <?php echo trim($dropdown_vendor['options'][$dropdown_vendor['default']]," ") . "<br>"; ?>                            <?php echo trim($dropdown_coordinatorName['default']," "). "<br>"  ?>                            <?php echo $dropdown_VendorcompanyPhone['default'] . "<br>"  ?>                            <?php echo $dropdown_VendorcompanyAddress['defaultA'] . "<br>" ?>                            <?php // echo form_dropdown('vendor', $dropdown_vendor['options'], $dropdown_vendor['default'], array('class' => 'form-control', 'id' => 'vendor', 'onchange' => 'loadPublications(this,\'.publications\');resetEditions();')); ?>                        </div>                    </div>                    <div class="col-md-6">                        <table class="table table-bordered table-condensed">                            <thead>                                <tr>                                    <th class="text-center info">RO No.</th>                                    <th class="text-center"><?php echo $release_order_no; ?></th>                                    <th class="text-center info">DATE</th>                                    <th class="text-center"><?php echo date('d-M-y', time()); ?></th>                                </tr>                            </thead>                        </table>                        <table class="table table-condensed table-bordered">                            <tr>                                <td><?php echo 'Client Name'; ?></td>                                <td><?php echo $dropdown_client['options'][$dropdown_client['default']]; ?></td>                            </tr>                            <tr>                                <td><?php echo 'Enter Caption'; ?></td>                                <td><?php echo $release_order->caption; ?></td>                            </tr>                            <tr>                                <td><?php echo 'Advertisement Type'; ?></td>                                <td><?php echo $ad_type->name; ?></td>                            </tr>                        </table>                    </div>                </div>                <table class="table table-bordered table-condensed table-hover">                    <colgroup>                        <col style="width: 20%" />                        <col style="width: 10%" />                        <col style="width: 10%" />                        <col style="width: 10%" />                        <col style="width: 10%" />                        <col style="width: 10%" />                        <col style="width: 10%" />                        <!--<col style="width: 1%" />-->                    </colgroup>                    <thead>                        <tr class="info">                            <th><strong>Publication Name</strong></th>                            <th><strong>Insertion Date</strong></th>                            <th><strong>Edition</strong></th>                            <th><strong>Page</strong></th>                            <th class="text-center"><strong>Size <span id="ad_type_size_label"></span></strong></th>                            <th class="text-center"><strong>Package</strong></th>                            <th><strong>Base Rate</strong></th>                            <!--<th></th>-->                        </tr>                    </thead>                    <tbody id="order_content">                        <?php $index = 1; ?>                        <?php if ($order_items) { ?>                            <?php foreach ($order_items as $order_item) { ?>                                <?php                                $insertion_dates = $this->release_order_model->get_insertion_dates($order_item->id);                                foreach ($insertion_dates as $insertion_date) {                                    $insertion_date_arr[] = date('d/m/Y', strtotime($insertion_date->date));                                }                                $insertion_date_str = implode(", ", $insertion_date_arr);                                $input_base_rate = array('name' => 'base_rate[]', 'value' => $order_item->base_rate);                                // load publications                                $publications = $this->vendor_model->get_publications($vendor_id);                                $publication_html = "<option value=''>Select Publication</option>";                                $selected_publication_id = '';                                foreach ($publications as $publication) {                                    $selected = '';                                    if ($publication->publication_name == $order_item->publication) {                                        $selected_publication_id = $publication->publication_id;                                        $selected = 'selected="selected"';                                    }                                    $publication_html .= "<option " . $selected . " data-id='" . html_escape($publication->publication_id) . "' value='" . html_escape($publication->publication_name) . "'>";                                    $publication_html .= $publication->publication_name;                                    $publication_html .= "</option>";                                }                                // load editions                                $editions = $this->publication_model->get_editions($selected_publication_id);                                if ($editions) {                                    foreach ($editions as $edition) {                                        $dropdown_edition['options'][$edition->edition_name] = $edition->edition_name;                                    }                                } else {                                    $dropdown_edition['options'][''] = 'No Editions Found';                                }                                $dropdown_edition['default'] = $order_item->edition;                                // size                                $size_arr = explode("_", $order_item->size);                                $input_size = "";                                if (isset($size_arr[1])) {//                                    $input_size .= '<div class="row">';////                                    $input_size .= '<div class=" col-md-6" style="padding-right: 3px;">';//                                    $input_size .= form_input('size_width[]', $size_arr[0], 'class="form-control"'); //'<input name="size_width[]" class="form-control" />';                                    $input_size .= $size_arr[0];                                    $input_size .= ' x ';//                                    $input_size .= '</div>';////                                    $input_size .= '<div class=" col-md-6" style="padding-left: 3px;">';//                                    $input_size .= form_input('size_height[]', $size_arr[1], 'class="form-control"'); //'<input name="size_height[]" class="form-control" />';                                    $input_size .= $size_arr[1];//                                    $input_size .= '</div>';////                                    $input_size .= '</div>';                                } else {                                    $input_size .= $size_arr[0]; //'<input name="size[]" class="form-control" />';//                                    $input_size .= form_input('size[]', $size_arr[0], 'class="form-control"'); //'<input name="size[]" class="form-control" />';                                }                                // packages                                $packages = $this->publication_model->get_packages($selected_publication_id, $ad_type_id);                                $dropdown_package['options'] = array();                                if ($packages) {                                    $dropdown_package['options'][''] = 'Remove Package';                                    foreach ($packages as $package) {                                        $dropdown_package['options'][$package->package_id] = $package->package_name;                                    }                                } else {                                    $dropdown_package['options'][0] = 'No Package Selected';                                }                                $dropdown_package['default'] = $order_item->package_id;                                ?>                                <tr>                                    <td>                <!--                                        <select name="publication[]" onchange="loadEditions(this, 'edition<?php echo $index; ?>');                                                                        loadPackages(this, 'package<?php echo $index; ?>')" class="form-control publications">                                        <?php // echo $publication_html;  ?>                                                        </select>-->                                        <?php echo $order_item->publication; ?>                                        <?php // echo form_dropdown('publication[]', $dropdown_publication['options'], $dropdown_publication['default'], array('id' => 'publication' . $index, 'class' => 'form-control publications', 'onclick' => 'loadEditions(this, \'edition' . $index . '\');loadPackages(this, \'package' . $index . '\')'));   ?>                                    </td>                                    <td>                                        <div class="input-group">                                                            <!--<input name="insertion_date[]" onclick="showDatepicker(this)" class="form-control ro_form_insertion_date" type="text" value="<?php // echo $insertion_date_str;   ?>" />-->                                            <?php echo $insertion_date_str; ?>                                        </div>                                    </td>                                    <td>                                        <?php // echo form_dropdown('edition[]', $dropdown_edition['options'], $dropdown_edition['default'], array('id' => 'edition' . $index, 'class' => 'form-control editions'));  ?>                                        <?php echo $order_item->edition; ?>                                    </td>                                    <td>                                        <?php // echo form_dropdown('page_type[]', $dropdown_page_type['options'], $order_item->page, array('class' => 'form-control'));  ?>                                        <?php echo $order_item->page; ?>                                    </td>                                    <td class="ad_type_size text-center"><?php echo $input_size; ?></td>                                    <td>                                        <?php // echo form_dropdown('package[]', $dropdown_package['options'], $dropdown_package['default'], array('id' => 'package' . $index, 'class' => 'form-control packages'));  ?>                                        <?php echo $dropdown_package['options'][$order_item->package_id]; ?>                                    </td>                                    <td>                                        <?php // echo form_input($input_base_rate, $order_item->base_rate, array('class' => 'form-control small'));  ?>                                        <?php echo $order_item->base_rate; ?>                                    </td>                <!--                                    <td>                                                        <a onclick="removeOrderItem(this)" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>                                                    </td>-->                                </tr>                                <?php $index++; ?>                            <?php } ?>                        <?php } ?>                        <?php /* <tr>                          <td>                          <?php // echo form_dropdown('publication', $dropdown_publication['options'], $dropdown_publication['default'], array('class' => 'form-control publications', 'onchange' => 'loadEditions(this,\'edition1\')'));   ?>                          <select name="publication[]" onchange="loadEditions(this, 'edition1');                          loadPackages(this, 'package1')" class="form-control publications">                          <option value="">Select Publication</option>                          </select>                          </td>                          <td>                          <div class="input-group">                          <input name="insertion_date[]" onclick="showDatepicker(this)" class="form-control ro_form_insertion_date" type="text" />                          <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>                          </div>                          </td>                          <td>                          <select name="edition[]" id="edition1" class="form-control editions">                          <option value="">Select Edition</option>                          </select>                          </td>                          <td>                          <?php echo form_dropdown('page_type[]', $dropdown_page_type['options'], $dropdown_page_type['default'], array('class' => 'form-control')); ?>                          </td>                          <td class="ad_type_size">                          <!--                                <div class="row">                          <div class=" col-md-6" style="padding-right: 3px;">                          <input name="size_width[]" class="form-control" />                          </div>                          <div class=" col-md-6" style="padding-left: 3px;">                          <input name="size_height[]" class="form-control" />                          </div>                          </div>-->                          </td>                          <td>                          <select name="package[]" id="package1" class="form-control packages">                          <option value="">Select Package</option>                          </select>                          </td>                          <td>                          <input name="base_rate[]" class="form-control small" />                          </td>                          <td>                          <a class="btn btn-danger disabled"><i class="glyphicon glyphicon-remove"></i></a>                          </td>                          </tr> */ ?>                    </tbody><!--                    <tfoot>                        <tr>                            <td colspan="8">                                <a class="btn btn-success pull-right" onclick="addOrderItem()">Add +</a>                            </td>                        </tr>                    </tfoot>-->                </table>                <div class="row">                    <div class="col-md-3">                        <div class="form-group">                            <?php // echo form_dropdown('material_type', $dropdown_material_type['options'], $dropdown_material_type['default'], array('class' => 'form-control'));  ?>                            <?php echo "Material Type : "; ?>                            <?php echo $release_order->material_type; ?>                        </div>                        <div class="form-group">                            <?php echo 'Material Status : '; ?>                            <?php echo $release_order->material_status; ?>                            <?php // echo form_input($input_material_status, '', array('class' => 'form-control'));  ?>                        </div>                    </div>                </div>                <div class="form-group">                    <a class="btn btn-primary">Print</a>                    <a href="<?php echo base_url('release_order'); ?>" class="btn btn-default">Back</a>                </div>            </div><!-- /.col-md-6 -->        </div><!-- /.row -->    </div><!-- /.col-lg-12 --></div><!-- /.row --><script type="text/javascript">    var index = 2;    function addOrderItem() {        var ad_type = document.getElementById('ad_type');        var ad_type_size = ad_type.options[ad_type.options.selectedIndex].getAttribute('data-size');        var element = document.getElementById('order_content');        var table_row = document.createElement('tr');        var row_release_order_item = '<td>';//        row_release_order_item += '<?php // echo form_dropdown('publication', $dropdown_publication['options'], $dropdown_publication['default'], array('class' => 'form-control'));                         ?>';        row_release_order_item += '<select id="publication' + index + '" name="publication[]" onchange="loadEditions(this,\'edition' + index + '\');loadPackages(this, \'package' + index + '\')" class="form-control publications">';        row_release_order_item += '<option value="">Select Publication</option>';        row_release_order_item += '</select>';        row_release_order_item += '</td>';        row_release_order_item += '<td>';        row_release_order_item += '<div class="input-group">';        row_release_order_item += '<input name="insertion_date[]" class="form-control ro_form_insertion_date" type="text" />';        row_release_order_item += '<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>';        row_release_order_item += '</div>';        row_release_order_item += '</td>';        row_release_order_item += '<td>';        row_release_order_item += '<select name="edition[]" id="edition' + index + '" class="form-control editions">';        row_release_order_item += '<option value="">Select Edition</option>';        row_release_order_item += '</select>';        row_release_order_item += '</td>';        row_release_order_item += '<td>';        row_release_order_item += '<?php echo form_dropdown('page_type[]', $dropdown_page_type['options'], $dropdown_page_type['default'], array('class' => 'form-control')); ?>';        row_release_order_item += '</td>';        if (ad_type_size == "width_height") {            row_release_order_item += '<td class="ad_type_size">';            row_release_order_item += '<div class="row">';            row_release_order_item += '<div class=" col-md-6" style="padding-right: 3px;">';            row_release_order_item += '<input name="size_width[]" class="form-control" />';            row_release_order_item += '</div>';            row_release_order_item += '<div class=" col-md-6" style="padding-left: 3px;">';            row_release_order_item += '<input name="size_height[]" class="form-control" />';            row_release_order_item += '</div>';            row_release_order_item += '</div>';            row_release_order_item += '</td>';        } else {            row_release_order_item += '<td class="ad_type_size">';            row_release_order_item += '<input name="size[]" class="form-control" />';            row_release_order_item += '</td>';        }        row_release_order_item += '<td>';        row_release_order_item += '<select name="package[]" id="package' + index + '" class="form-control packages">';        row_release_order_item += '<option value="">Select Package</option>';        row_release_order_item += '</select>';        row_release_order_item += '</td>';        row_release_order_item += '<td>';        row_release_order_item += '<input name="base_rate[]" class="form-control small" />';        row_release_order_item += '</td>';        row_release_order_item += '<td>';        row_release_order_item += '<a onclick="removeOrderItem(this)" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>';        row_release_order_item += '</td>';        table_row.innerHTML = row_release_order_item;        element.appendChild(table_row);        // Fetch and populate publications dropdown        loadPublications(document.getElementById('vendor'), '#publication' + index);        index++;    }    function removeOrderItem(obj) {        var row_tr = obj.parentNode.parentNode;        row_tr.parentNode.removeChild(row_tr);    }    function setSize() {        var ad_type = document.getElementById('ad_type');        var ad_type_size = ad_type.options[ad_type.options.selectedIndex].getAttribute('data-size');        var html = "";        if (ad_type_size == "width_height") {            document.getElementById('ad_type_size_label').innerHTML = "( W x H )";            html += '<td class="ad_type_size">';            html += '<div class="row">';            html += '<div class=" col-md-6" style="padding-right: 3px;">';            html += '<input name="size_width[]" class="form-control" />';            html += '</div>';            html += '<div class=" col-md-6" style="padding-left: 3px;">';            html += '<input name="size_height[]" class="form-control" />';            html += '</div>';            html += '</div>';            html += '</td>';        } else {            if (ad_type_size == "word") {                document.getElementById('ad_type_size_label').innerHTML = "( Words )";            } else if (ad_type_size == "linage") {                document.getElementById('ad_type_size_label').innerHTML = "( Lines )";            }            html += '<td class="ad_type_size">';            html += '<input name="size[]" class="form-control" />';            html += '</td>';        }        var td_size = document.getElementsByClassName('ad_type_size');        console.log(td_size);        for (var i in td_size) {            td_size[i].innerHTML = html;        }    }</script>