<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Vendors</h1>
        <!--<a href="<?php // echo base_url() . "client/quick_add"; ?>" class="btn btn-primary pull-right btn-top-right" data-toggle="modal" data-target="#myModal" data-backdrop="static">Add Client</a>-->
        <a href="<?php echo base_url() . "vendor/add"; ?>" class="btn btn-primary pull-right btn-top-right">Add Vendor</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Button trigger modal -->
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTableVendors">
                <colgroup>
                    <col style="width:6%" />
                    <col style="width:20%" />
                    <col style="width:20%" />
                    <col style="width:25%" />
                    <col style="width:14%" />
                    <col style="width:10%" />
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>Company Phone</th>
                        <th>Commission</th>
                        <th>Vendor Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->