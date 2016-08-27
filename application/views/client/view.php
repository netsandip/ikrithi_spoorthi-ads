<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Clients</h1>
        <!--<a href="<?php // echo base_url() . "client/quick_add"; ?>" class="btn btn-primary pull-right btn-top-right" data-toggle="modal" data-target="#myModal" data-backdrop="static">Add Client</a>-->
        <a href="<?php echo base_url() . "client/add"; ?>" class="btn btn-primary pull-right btn-top-right">Add Client</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- Button trigger modal -->
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTableClients">
                <colgroup>
                    <col style="width:6%" />
                    <col style="width:40%" />
                    <col style="width:25%" />
                    <col style="width:14%" />
                    <col style="width:10%" />
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php /* <tbody>
                    <?php $index = 1; ?>
                    <?php foreach($clients as $client) { ?>
                    <tr class="gradeX">
                        <td><?php echo $index++; ?></td>
                        <td><?php echo $client->firstname; ?></td>
                        <td><?php echo $client->email; ?></td>
                        <td><?php echo $client->phone; ?></td>
                        <td></td>
                    </tr>
                    <?php } ?>
                </tbody> */ ?>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->