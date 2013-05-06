<?php $this->load->view('header');?>
<div id="content">
<?php $attributes = array('class' => 'form', 'id' => 'reg'); 
echo form_open('registrate/addUser', $attributes); 
?>
	<label>Name:</label>
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
	<label>Email:</label>
    <br />
	<?php 
        $data = array( 
        'name' => 'email', 
        'size' => '12', 
        'value' => set_value('email'),
        ); 
        echo form_input($data);            
        echo form_error('email', '<div class="error">', '</div>'); 
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
    ?>

    <br /><br />
	<label>Repeat password:</label>
	<br />
    <?php 
        $data2 = array( 
        'name' => 'repassword', 
        'size' => '12', 
        ); 
        echo form_password($data2);        
        echo form_error('repassword', '<div class="error">', '</div>'); 
    ?>

    <br /><br />
    <?php echo $image;?>
    <br />
    <input type="text" name="captcha" value="" />
    <?php echo form_error('captcha', '<div class="error">', '</div>');?>
    <br /><br />
    <?php
         echo form_submit('ok', 'Registrate'); 
    ?>
<?php    
     echo form_close();
?>
    <p>Please enter your name(nickname), your email and password.</p>
    <p>Choose a nick for at least 4 and not more than 12 characters.</p> 
    <p>Choose a password for at least 6 and not more than 12 characters.</p>
</div>
<?php $this->load->view('footer');?>	