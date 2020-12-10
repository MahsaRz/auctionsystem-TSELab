<?php if($data['states']==false){ ?>
    <option value="Select">Select Country</option>
<?php }
else{ ?>
<option value="Select">Select</option>
<?php } ?>
<option value="Select"><?php echo $data['state'] ?></option>
<?php foreach($data['states'] as $state) { ?>
    <option value="<?php echo $state->state ?>"  <?php if($data['state']==$state->state): ?> selected="selected" <?php endif; ?>><?php echo $state->state ?></option>
<?php } ?>