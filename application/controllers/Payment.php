<?phpdefined('BASEPATH') OR die('No access');class Payment extends MY_Controller {    public function __construct() {        parent::__construct();        $this->load->helper(array('form'));        $this->load->library(array('form_validation'));        $this->load->model('payment_model');    }    public function vendor() {        $this->data['rows'] = $this->payment_model->get_vendor_payments();        $this->data['subview'] = $this->load->view('payment/vendor_view', $this->data, TRUE);        $this->load->view('layout/header');        $this->load->view('layout/_main', $this->data);        $this->load->view('layout/footer');    }    public function client() {        $this->data['rows'] = $this->payment_model->get_client_payments();        $this->data['subview'] = $this->load->view('payment/client_view', $this->data, TRUE);        $this->load->view('layout/header');        $this->load->view('layout/_main', $this->data);        $this->load->view('layout/footer');    }    public function vendor_add() {        $this->load->model('vendor_model');        $this->data['scripts'][] = base_url('assets/dist/js/payment-vendor.js');        $this->data['action'] = 'payment/vendor_add';        /*         * Validation rules         */        $rules_add_invoice = array(            array(                'field' => 'vendor',                'label' => 'Vendor',                'rules' => 'required'            ),            array(                'field' => 'vendor_receipt_no',                'label' => 'Receipt Number',                'rules' => 'required'            ),            array(                'field' => 'amount',                'label' => 'Amount',                'rules' => 'required'            ),            array(                'field' => 'payment_mode',                'label' => 'mode of payment',                'rules' => 'required'            )        );        $this->form_validation->set_rules($rules_add_invoice);        if ($this->form_validation->run() === FALSE) {            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');        } else {            $this->payment_model->create_vendor_payment();            $this->session->set_flashdata('message', alert_message('Payment added successfully', 'success'));            redirect('payment/vendor_add', 'refresh');        }        /*         * Form inputs         */        // Fetch clients        $vendors = $this->vendor_model->find_all();        $this->data['dropdown_vendor']['options'] = array();        $this->data['dropdown_vendor']['options'][''] = 'Select Vendor';        foreach ($vendors as $vendor) {            $this->data['dropdown_vendor']['options'][$vendor->id] = $vendor->company_name;        }        $this->data['dropdown_vendor']['default'] = set_value('vendor');        $this->data['subview'] = $this->load->view('payment/vendor_add', $this->data, TRUE);        $this->load->view('layout/header');        $this->load->view('layout/_main', $this->data);        $this->load->view('layout/footer');    }    public function client_add() {        $this->load->model('client_model');        $this->data['scripts'][] = base_url('assets/dist/js/payment-vendor.js');        $this->data['action'] = 'payment/client_add';        /*         * Validation rules         */        $rules_add_invoice = array(            array(                'field' => 'client',                'label' => 'Client',                'rules' => 'required'            ),            array(                'field' => 'amount',                'label' => 'Amount',                'rules' => 'required'            ),            array(                'field' => 'payment_mode',                'label' => 'mode of payment',                'rules' => 'required'            )        );        $this->form_validation->set_rules($rules_add_invoice);        if ($this->form_validation->run() === FALSE) {            $this->data['message'] = (validation_errors() == '') ? $this->session->flashdata('message') : alert_message(validation_errors(), 'error');        } else {            $this->payment_model->create_client_payment();            $this->session->set_flashdata('message', alert_message('Payment added successfully', 'success'));            redirect('payment/client_add', 'refresh');        }        /*         * Form inputs         */        // Fetch clients        $clients = $this->client_model->find_all();        $this->data['dropdown_client']['options'] = array();        $this->data['dropdown_client']['options'][''] = 'Select Client';        foreach ($clients as $client) {            $this->data['dropdown_client']['options'][$client->id] = $client->name;        }        $this->data['dropdown_client']['default'] = set_value('vendor');        $this->data['subview'] = $this->load->view('payment/client_add', $this->data, TRUE);        $this->load->view('layout/header');        $this->load->view('layout/_main', $this->data);        $this->load->view('layout/footer');    }    public function get_invoice_details_html($invoice_id = NULL) {        $html = "";        if (!isset($invoice_id) || empty($invoice_id) || $invoice_id === NULL) {            $html = "0";            $this->output->set_output($html);            return;        }        $this->load->model('invoice_model');        $invoice = $this->invoice_model->get_invoice($invoice_id);        $invoice_orders = $this->invoice_model->get_invoice_orders($invoice_id);        $this->data['invoice'] = $invoice;        $this->data['invoice_orders'] = $invoice_orders;        $release_order_items = $this->invoice_model->get_invoice_order_items($invoice_id);        $html .= '<table class="table table-bordered table-condensed">';        $html .= '<colgroup>';        $html .= '<col style="width:5%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:20%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:15%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:10%">';        $html .= '</colgroup>';        $html .= '<thead>';        $html .= '<tr>';        $html .= '<th class="text-center info" colspan="9"><strong>INVOICE DETAILS</strong></th>';        $html .= '</tr>';        $html .= '<tr>';        $html .= '<th>#</th>';        $html .= '<th>RO No</th>';        $html .= '<th>Publication Name</th>';        $html .= '<th>Edition</th>';        $html .= '<th>Size</th>';        $html .= '<th>Date</th>';        $html .= '<th>Page</th>';        $html .= '<th class="text-right">Base Rate</th>';        $html .= '<th class="text-right">Amount</th>';        $html .= '</tr>';        $html .= '</thead>';        $html .= '<tbody>';        $index = 1;        $total_base_rate = 0;        $total_amount = 0;        foreach ($release_order_items as $release_order_item) {            $release_order_item_id = $index;            $size_arr = explode("_", $release_order_item->size);//            if (isset($size_arr[1])) {//                $hidden_fields['size_width[' . $release_order_item_id . ']'] = $size_arr[0];//                $hidden_fields['size_height[' . $release_order_item_id . ']'] = $size_arr[1];//            } else {//                $hidden_fields['size[' . $release_order_item_id . ']'] = $size_arr[0];//            }            if (isset($size_arr[1])) {                $size = $size_arr[0] * $size_arr[1];                $size_str = $size_arr[0] . ' x ' . $size_arr[1];            } else {                $size = $size_arr[0];                $size_str = $size_arr[0];            }            $amount = $size * $release_order_item->base_rate;            $total_base_rate += $release_order_item->base_rate;            $total_amount += $amount;            $html .= '<tr>';            $html .= '<td>' . $index . '</td>';            $html .= '<td>' . $release_order_item->release_order_no . '</td>';            $html .= '<td>' . $release_order_item->publication . '</td>';            $html .= '<td>' . $release_order_item->edition . '</td>';            $html .= '<td>' . $size_str . '</td>';            $html .= '<td>' . date('d/m/Y', strtotime($release_order_item->insertion_date)) . '</td>';            $html .= '<td>' . $release_order_item->page . '</td>';            if ($release_order_item->package == '') {                $html .= '<td class="text-right">' . $release_order_item->base_rate . '</td>';            } else {                $hidden_input_base_rate = array(                    'type' => 'hidden',                    'name' => 'base_rate[' . $release_order_item_id . ']',                    'value' => $release_order_item->base_rate,                    'class' => 'base_rate'                );                $html .= form_input($hidden_input_base_rate);                $html .= '<td>' . html_escape($release_order_item->package) . '</td>';            }            $html .= '<td class="text-right">' . number_format($amount, 2, '.', '') . '</td>';            $html .= '</tr>';            $index++;        }        $html .= '</tbody>';        $html .= '<tfoot>';        $html .= '<tr>';        $html .= '<th colspan="7" class="text-right"><strong>TOTAL</strong></th>';        $html .= '<th class="text-right"><strong id="total_base_rate">' . number_format($total_base_rate, 2, '.', '') . '</strong></th>';        $html .= '<th class="text-right"><strong id="total_amount">' . number_format($total_amount, 2, '.', '') . '</strong></th>';        $html .= '</tr>';        $html .= '</tfoot>';        $html .= '</table>';        // BEGIN : Payment details        $transactions = $this->payment_model->get_client_payments($invoice_id);        $html .= '<table class="table table-bordered table-condensed">';        $html .= '<colgroup>';        $html .= '<col style = "width:10%" />';        $html .= '<col style="width:15%" />';        $html .= '<col style="width:20%" />';        $html .= '<col style="width:20%" />';        $html .= '</colgroup>';        $html .= '<thead>';        $html .= '<tr>';        $html .= '<th class="text-center info" colspan="6"><strong>PAYMENT DETAILS</strong></th>';        $html .= '</tr>';        $html .= '<tr>';        $html .= '<th>No</th>';        $html .= '<th>Date</th>';        $html .= '<th>Receipt No</th>';        $html .= '<th>Mode of Payment</th>';        $html .= '<th>Transaction Ref</th>';        $html .= '<th class="text-right">Amount Paid</th>';        $html .= '</tr>';        $html .= '</thead>';        $html .= '<tbody>';        if ($transactions) {            $transaction_amount_total = 0;            $count =1;            foreach ($transactions as $transaction) {                $html .= '<tr>';                $html .= '<td>' . $count++ . '</td>';                $html .= '<td>' . $transaction->receipt_date . '</td>';                $html .= '<td>' . $transaction->receipt_no . '</td>';                $html .= '<td>' . ucfirst($transaction->payment_mode) . '</td>';                $html .= '<td>' . $transaction->ref_no . '</td>';                $html .= '<td class="text-right">' . $transaction->amount . '</td>';                $html .= '</tr>';                $transaction_amount_total += $transaction->amount;            }            $balance_amount = $total_amount - $transaction_amount_total;            $html .= '<tr><td colspan="6">&nbsp;</td></tr>';            $html .= '<tr><td class="text-right" colspan="5">Amount Received</td><td class="text-right success"><strong>' . number_format($transaction_amount_total, 2) . '</strong></td></tr>';            $html .= '<tr><td class="text-right" colspan="5">Balance</td><td class="text-right danger"><strong>' . number_format($balance_amount, 2) . '</strong></td></tr>';        } else {            $html .= '<td colspan="4" class="danger text-center"><strong>No Payments Received</strong></td>';        }        $html .= '</tbody>';        $html .= '</table>';        // END : Payment details        if (isset($balance_amount) && $balance_amount <= 0) {            // No pending payments            $html = '1';        }        $this->output->set_output($html);    }    public function get_release_order_details_html($release_order_id = NULL) {        $html = "";        if (!isset($release_order_id) || empty($release_order_id) || $release_order_id === NULL) {            $html = "0";            $this->output->set_output($html);            return;        }        $this->load->model('release_order_model');        $release_order = $this->release_order_model->get_release_order($release_order_id);        $this->data['release_order'] = $release_order;        $release_order_items = $this->release_order_model->get_release_order_items($release_order_id);        $html .= '<table class="table table-bordered table-condensed">';        $html .= '<colgroup>';        $html .= '<col style="width:5%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:20%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:15%">';        $html .= '<col style="width:10%">';        $html .= '<col style="width:10%">';        $html .= '</colgroup>';        $html .= '<thead>';        $html .= '<tr>';        $html .= '<th class="text-center info" colspan="9"><strong>RELEASE ORDER DETAILS</strong></th>';        $html .= '</tr>';        $html .= '<tr>';        $html .= '<th>#</th>';        $html .= '<th>RO No</th>';        $html .= '<th>Publication Name</th>';        $html .= '<th>Edition</th>';        $html .= '<th>Size</th>';        $html .= '<th>Order Date</th>';        $html .= '<th>Page</th>';        $html .= '<th class="text-right">Base Rate</th>';        $html .= '<th class="text-right">Amount</th>';        $html .= '</tr>';        $html .= '</thead>';        $html .= '<tbody>';        $index = 1;        $total_base_rate = 0;        $total_amount = 0;        foreach ($release_order_items as $release_order_item) {            $release_order_item_id = $index;            $size_arr = explode("_", $release_order_item->size);//            if (isset($size_arr[1])) {//                $hidden_fields['size_width[' . $release_order_item_id . ']'] = $size_arr[0];//                $hidden_fields['size_height[' . $release_order_item_id . ']'] = $size_arr[1];//            } else {//                $hidden_fields['size[' . $release_order_item_id . ']'] = $size_arr[0];//            }            if (isset($size_arr[1])) {                $size = $size_arr[0] * $size_arr[1];                $size_str = $size_arr[0] . ' x ' . $size_arr[1];            } else {                $size = $size_arr[0];                $size_str = $size_arr[0];            }            $amount = $size * $release_order_item->base_rate;            $total_base_rate += $release_order_item->base_rate;            $total_amount += $amount;            $html .= '<tr>';            $html .= '<td>' . $index . '</td>';            $html .= '<td>' . $release_order->release_order_no . '</td>';            $html .= '<td>' . $release_order_item->publication . '</td>';            $html .= '<td>' . $release_order_item->edition . '</td>';            $html .= '<td>' . $size_str . '</td>';//            $html .= '<td>' . date('d/m/Y', strtotime($release_order_item->insertion_date)) . '</td>';            $html .= '<td>' . date('d/m/Y', strtotime($release_order_item->order_date)) . '</td>';            $html .= '<td>' . $release_order_item->page . '</td>';            if ($release_order_item->package_id == 0) {                $html .= '<td class="text-right">' . $release_order_item->base_rate . '</td>';            } else {                $hidden_input_base_rate = array(                    'type' => 'hidden',                    'name' => 'base_rate[' . $release_order_item_id . ']',                    'value' => $release_order_item->base_rate,                    'class' => 'base_rate'                );                $html .= form_input($hidden_input_base_rate);                $html .= '<td>' . html_escape($release_order_item->package) . '</td>';            }            $html .= '<td class="text-right">' . number_format($amount, 2, '.', '') . '</td>';            $html .= '</tr>';            $index++;        }        $html .= '</tbody>';        $html .= '<tfoot>';        $html .= '<tr>';        $html .= '<th colspan="7" class="text-right"><strong>TOTAL</strong></th>';        $html .= '<th class="text-right"><strong id="total_base_rate">' . number_format($total_base_rate, 2, '.', '') . '</strong></th>';        $html .= '<th class="text-right"><strong id="total_amount">' . number_format($total_amount, 2, '.', '') . '</strong></th>';        $html .= '</tr>';        $html .= '</tfoot>';        $html .= '</table>';        // BEGIN : Payment details        $transactions = $this->payment_model->get_vendor_payments($release_order_id);        $html .= '<table class="table table-bordered table-condensed">';        $html .= '<colgroup>';        $html .= '<col style = "width:10%" />';        $html .= '<col style="width:15%" />';        $html .= '<col style="width:20%" />';        $html .= '<col style="width:20%" />';        $html .= '</colgroup>';        $html .= '<thead>';        $html .= '<tr>';        $html .= '<th class="text-center info" colspan="6"><strong>PAYMENT DETAILS</strong></th>';        $html .= '</tr>';        $html .= '<tr>';        $html .= '<th>No</th>';        $html .= '<th>Date</th>';        $html .= '<th>Vendor Receipt No</th>';        $html .= '<th>Mode of Payment</th>';        $html .= '<th>Transaction Ref</th>';        $html .= '<th class="text-right">Amount Paid</th>';        $html .= '</tr>';        $html .= '</thead>';        $html .= '<tbody>';        if ($transactions) {            $transaction_amount_total = 0;            $count =1;            foreach ($transactions as $transaction) {                $html .= '<tr>';                $html .= '<td>' . $count++ . '</td>';                $html .= '<td>' . $transaction->vendor_receipt_date . '</td>';                $html .= '<td>' . $transaction->vendor_receipt_no . '</td>';                $html .= '<td>' . ucfirst($transaction->payment_mode) . '</td>';                $html .= '<td>' . $transaction->ref_no . '</td>';                $html .= '<td class="text-right">' . $transaction->amount . '</td>';                $html .= '</tr>';                $transaction_amount_total += $transaction->amount;            }            $balance_amount = $total_amount - $transaction_amount_total;            $html .= '<tr><td colspan="6">&nbsp;</td></tr>';            $html .= '<tr><td class="text-right" colspan="5">Amount Received</td><td class="text-right success"><strong>' . number_format($transaction_amount_total, 2) . '</strong></td></tr>';            $html .= '<tr><td class="text-right" colspan="5">Balance</td><td class="text-right danger"><strong>' . number_format($balance_amount, 2) . '</strong></td></tr>';        } else {            $html .= '<td colspan="4" class="danger text-center"><strong>No Payments Received</strong></td>';        }        $html .= '</tbody>';        $html .= '</table>';        // END : Payment details        if (isset($balance_amount) && $balance_amount <= 0) {            // No pending payments            $html = '1';        }        $this->output->set_output($html);    }}