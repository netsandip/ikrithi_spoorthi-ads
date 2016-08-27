<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Invoices</h1>
        <!--<a href="<?php // echo base_url() . "client/quick_add"; ?>" class="btn btn-primary pull-right btn-top-right" data-toggle="modal" data-target="#myModal" data-backdrop="static">Add Client</a>-->
        <a href="<?php echo base_url() . "invoice/add"; ?>" class="btn btn-primary pull-right btn-top-right">Add</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Button trigger modal -->
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTableInvoices">
                <colgroup>
                    <col style="width:20%" />
                    <col style="width:20%" />
                    <col style="width:20%" />
                    <col style="width:15%" />
                    <col style="width:15%" />
                    <col style="width:10%" />
                </colgroup>
                <thead>
                    <tr>
                        <!--<th><?php // echo form_checkbox('select_all','',FALSE,array('id' => 'select_all','title' => 'Select All')); ?></th>-->
                        <th>Client Name</th>
                        <th>Vendor</th>
                        <th>Vendor Type</th>
                        <th>Ad Type</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Test Client 1</td><td>Test Vendor 1</td><td>Newspaper</td><td>Classified</td><td>4850</td><td><a class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a></td></tr>
                    <tr><td>Test Client 1</td><td>Test Vendor 1</td><td>Newspaper</td><td>Classified</td><td>4850</td><td><a class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a></td></tr>
                    <tr><td>Test Client 1</td><td>Test Vendor 1</td><td>Newspaper</td><td>Classified</td><td>4850</td><td><a class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a></td></tr>
                    <tr><td>Test Client 1</td><td>Test Vendor 1</td><td>Newspaper</td><td>Classified</td><td>4850</td><td><a class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a></td></tr>
                    <tr><td>Test Client 1</td><td>Test Vendor 1</td><td>Newspaper</td><td>Classified</td><td>4850</td><td><a class='btn btn-xs btn-success'><i class='fa fa-edit'></i></a></td></tr>
                </tbody>
<!--                <tfoot>
                    <tr>
                        <th colspan="3"><button id="btn_delete" class="btn btn-danger pull-left">Delete</button></th>
                    </tr>
                </tfoot>-->
            </table>
        </div>
        <!-- /.table-responsive -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->