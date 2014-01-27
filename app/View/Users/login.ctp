<?php $this->layout = 'naoLogado'; ?>

<br><br>
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>

<?php
echo $this->Form->input('username', array ('id' => 'userName'));
echo $this->Form->input('password');
?>

<?php echo $this->Form->end(__('Logar')); ?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#userName').focus();
    });
</script>


<?php echo $this->Js->writeBuffer(); ?>
