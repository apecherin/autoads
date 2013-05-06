<?php $this->load->view('header');?>
<div id="content">
    <?php if(!empty($error)):?>
    <div class="error_succ">
	<?php 
		echo $error; 
	?>
    </div>
    <?php else : ?>
    <div id="afterReg">
        <?php 
            echo $success; 
        ?>
    </div>
    <?php endif;?>
    <p><?php 
            echo $link; 
	?>
    </p>
</div>
<?php $this->load->view('footer');?>