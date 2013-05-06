<?php $this->load->view('header');?>
<div id="content">
    <?php if (check_user_authorization() == 0) :?>
        <label>Only registered users can add new ads.</br></br></label>
        <?php echo $link;?>
    <?php elseif(!empty($user)):?>
        <?php echo 'Dear '.$user->name.',</br>your account nas been blocked untill '.$user->td_block.', fox fix reason - please contact to administrator.';?></br>
        <?php echo $link;?>
    <?php else :?>
        <form action="<?php echo site_url('ads/addNewAd') ?>" method="post" enctype="multipart/form-data">
            <div class="error"><?php echo validation_errors()?></div>
            <div>
		<label>Enter title for new ad:</label>
		<input type="text" name="title" value="<?php echo set_value('title', !empty($ad) ? $ad->title : '')?>">
            </div>
            <div>
		<label>Enter price for your auto:</label>
		<input type="text" name="price" value="<?php echo set_value('price', !empty($ad) ? $ad->price : '')?>">
            </div>
            <div>
		<label>Enter year for your ad:</label>
		<input type="text" name="year" value="<?php echo set_value('year', !empty($ad) ? $ad->year : '')?>"/>
            </div>
            <div>
		<label>Enter text for your ad:</label><br>
                <textarea name="text" id="message" rows="5" cols="45"><?php echo set_value('text', !empty($ad) ? $ad->text : '')?></textarea>
            </div>
            <input type="submit" value="Add new ad!">
            </form>
</div>
<?php endif;?>
<?php $this->load->view('footer');?>	