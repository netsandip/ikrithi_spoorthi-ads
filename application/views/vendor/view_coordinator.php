<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Coordinators</h1>
        <!--<a href="<?php // echo base_url() . "client/quick_add";          ?>" class="btn btn-primary pull-right btn-top-right" data-toggle="modal" data-target="#myModal" data-backdrop="static">Add Client</a>-->
        <a href="<?php echo base_url() . "vendor/manage_coordinator/" . $vendor_id; ?>" class="btn btn-primary pull-right btn-top-right">Create New</a>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-<?php echo ($form_title === "Add") ? "default" : "green"; ?>">
            <div class="panel-heading">
                <?php echo $form_title; ?>
            </div>
            <div class="panel-body">
                <?php if (isset($message) && $message != "") { ?>
                    <?php echo $message; ?>
                <?php } ?>
                <?php echo form_open($action); ?>
                <div class="form-group">
                    <?php echo form_label('Name'); ?>
                    <?php echo form_input($input_fullname, '', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Phone'); ?>
                    <?php echo form_input($input_phone, '', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Email'); ?>
                    <?php echo form_input($input_email, '', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_label('Designation'); ?>
                    <?php echo form_input($input_designation, '', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo form_submit('save', 'Save', array('class' => 'btn btn-primary')); ?>
                    &nbsp;
                    <?php echo form_reset('clear', 'Clear', array('class' => 'btn btn-default')); ?>
                </div>
                <?php echo form_close(); ?>
            </div>
            <!--<div class="panel-footer"></div>-->
        </div>
    </div>
    <div class="col-md-8">
        <!-- Button trigger modal -->
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover">
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
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; ?>
                    <?php if ($coordinators) { ?>
                        <?php foreach ($coordinators as $coordinator) { ?>
                            <tr>
                                <td class="text-center"><?php echo $index++; ?></td>
                                <td><?php echo $coordinator->name; ?></td>
                                <td><?php echo $coordinator->phone; ?></td>
                                <td><?php echo $coordinator->email; ?></td>
                                <td><?php echo $coordinator->designation; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-xs btn-success" href="<?php echo base_url('vendor/edit_coordinator/' . $vendor_id . '/' . $coordinator->id); ?>" ><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6">
                                No records found
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->