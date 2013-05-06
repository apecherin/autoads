<?php $this->load->view('header');?>
<div id="content">
    <div id="search">
        <?php echo form_open('ads/main', array('name' => 'search', 'id' => 'search', 'method' => 'get')); ?>
            <?php echo form_label('Search:', 'search-box'); ?>
                <?php echo form_input(array('name' => 'q', 'id' => 'search-box', 'autocomplete' => 'off' /*,'value' => $search_terms*/)); ?>
            <?php echo form_submit('search', 'Search'); ?>
        <?php echo form_close(); ?>
    </div>
	<div id="ads">
            <?php foreach($ads as $ad):?>
		<div id="ad">
                    <div id="post"><?php echo "Posted: <br />".$ad->date ?></div>
                    <div id="img"><a href="<?php echo site_url('/ads/showAd/'.$ad->id) ?>"><?php echo '<img src="http://zahar-test.com/autoads/images/uploads/min/'.$ad->name.'" width="125" height="90">';?></a></div>
                    <div id="title"><a href="<?php echo site_url('/ads/showAd/'.$ad->id) ?>"><?php echo $ad->title ?></a></div><br /><br />
                    <div id="price"><?php echo "Price- $".$ad->price?></div><br /><br />
                    <div id="search"><a href="http://lmgtfy.com/?q=<?php echo $ad->title; ?>+<?php echo $ad->year; ?>" target="_blank">Look for more information on this type of car on the Internet</a></div>
		</div>	
            <?php endforeach;?>
            <ul class="pagination">
                            <?php 
                                echo $pager; 
                            ?>
                    
                        </ul> 
	</div>
</div>
<?php $this->load->view('footer');?>