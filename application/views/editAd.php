<?php $this->load->view('header');?>
<div id="content">
    <form action="<?php echo site_url('ads/editAd/'.$ads->id) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo !empty($ads) ? $ads->id : ''?>">
        <div class="error"><?php echo validation_errors()?></div>
        <div>
            <label>Change title for your ad:</label>
            <input type="text" name="title" value="<?php echo set_value('title', !empty($ads) ? $ads->title : '')?>">
       </div>
       <div>
            <label>Change price for your ad:</label>
            <input type="text" name="price" value="<?php echo set_value('price', !empty($ads) ? $ads->price : '')?>">
       </div>
       <div>
            <label>Change year for your ad:</label>
            <input type="text" name="year" value="<?php echo set_value('year', !empty($ads) ? $ads->year : '')?>"/>
       </div>
       <div>
            <label>Change text for your ad:</label><br>
            <textarea name="text" id="message" rows="5" cols="45"><?php echo set_value('text', !empty($ads) ? $ads->text : '')?></textarea>
       </div>
       <input type="submit" value="Change your ad!">
    </form>
    <br /><br />
    <div id="fotos">
        <?php if(!empty($fotos)):?>
                 <?php foreach($fotos as $foto):?>
                    <?php echo '<img src="http://zahar-test.com/autoads/images/uploads/min/'.$foto->name.'" alt="'.$foto->name.'" width="158" height="100" aling="center">';?>
                    <?php echo (($foto->id == 11) || ($fotos[0]==$foto))? '' : anchor('ads/deleteFoto/'.$foto->id.'/'.$ads->id, 'delete');?>
                <?php endforeach;?>
            <?php else:?>
            <?php echo '<img src="http://zahar-test.com/autoads/images/uploads/min/empty.jpg" alt="empty.jpg" width="158" height="100" aling="center">';?>
        <?php endif;?>
        <?php echo form_open_multipart('ads/uploadFoto_costl/'.$ads->id);?>
            <input type="file" name="userfile" size="20" />
            <br /><br />
            <input type="submit" value="upload a new foto" />
        </form>
        <?php if($upl_succes=='yes'):?>
            <h3 style= "color:red">
                Your file was successfully uploaded!<br />
                <a href="<?php echo site_url('ads/showAd/'.$ads->id) ?>">Show an ad with a new foto</a>
            </h3>
        <?php endif;?> 
    </div> 

</div>
<?php $this->load->view('footer');?>	