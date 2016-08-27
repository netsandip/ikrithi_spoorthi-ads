<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Add Publication</h4>
</div>
<div class="modal-body">
    <?php echo form_open('publication/create'); ?>
    <div class="form-group">
        <?php echo form_label('Firstname', 'firstname'); ?>
        <?php echo form_input($input_firstname, '', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
        <?php echo form_label('Lastname', 'lastname'); ?>
        <?php echo form_input($input_lastname, '', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
        <?php echo form_label('Phone', 'phone'); ?>
        <?php echo form_input($input_phone, '', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
        <?php echo form_label('Email', 'email'); ?>
        <?php echo form_input($input_email, '', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
        <?php echo form_label('Address', 'address'); ?>
        <?php echo form_textarea($input_address, '', array('class' => 'form-control')); ?>
    </div>
    <?php echo form_input($input_parent_id, '', array('class' => 'form-control')); ?>
    <?php echo form_close(); ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save</button>
</div>