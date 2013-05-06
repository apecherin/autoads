<?php $this->load->view('header');?>
<div id="content">
<?php
$attributes = array('class' => 'form', 'id' => 'auth'); 
echo form_open('authorization/authUser', $attributes); 
?>
	<label>Nick:</label>
    <br /> 
    <?php    
        $data = array( 
        'name' => 'name', 
        'size' => '12', 
        'value' => set_value('name'),
        ); 
        echo form_input($data);    
        echo form_error('name', '<div class="error">', '</div>'); 
    ?>

    <br /><br />
	<label>Password:</label>
	<br />
    <?php 
        $data1 = array( 
        'name' => 'password', 
        'size' => '12', 
        ); 
        echo form_password($data1);        
        echo form_error('password', '<div class="error">', '</div>'); 
    ?><br /><br />
        <?php
            echo form_submit('ok', 'Authorization'); 
        ?>
        <br /><br />
        <?php
            echo anchor('registrate/addUser', 'Registrate');
        ?>
        
        <?php
            echo form_close();
        ?>
</div>
<?php $this->load->view('footer');?>