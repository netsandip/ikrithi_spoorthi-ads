<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Editions</h1>
        <!--<a href="<?php // echo base_url() . "client/quick_add"; ?>" class="btn btn-primary pull-right btn-top-right" data-toggle="modal" data-target="#myModal" data-backdrop="static">Add Client</a>-->
        <a href="<?php echo base_url() . "edition/add"; ?>" class="btn btn-primary pull-right btn-top-right">Add</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Button trigger modal -->
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTableEditions">
                <colgroup>
                    <col style="width:6%" />
                    <col style="width:90%" />
                    <col style="width:4%" />
                </colgroup>
                <thead>
                    <tr>
                        <th><?php echo form_checkbox('select_all','',FALSE,array('id' => 'select_all','title' => 'Select All')); ?></th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="3"><button id="btn_delete" class="btn btn-danger pull-left">Delete</button></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->