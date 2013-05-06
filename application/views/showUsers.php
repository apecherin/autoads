<?php $this->load->view('header');?>
<div id="content">
        <?php if (!isset($users)) :?>
        <label>This page only for admins.</br></br></label>
        <?php echo $link;
        else :?>
            <div id="users">
                <?php foreach($users as $user):?>
                    <div id="user">
                        <div id="user_info">
                            <?php echo 'Username- '.$user->name ?><br><br>
                            <?php echo 'Email- '.$user->email ?><br><br>
                            <?php echo ($user->status) == 1 ? 'Account activated' : '<label style="color:#ff0000">Account still not activate</label>' ?><br><br>
                            <?php echo ($user->td_block) > date('Y-m-d H:i:s') ? '<label style="color:#ff0000">Account blocked untill '.$user->td_block.'</label>' : 'Account not blocked' ?><br><br>
                            <?php if (check_admin_additional($user->id)) :?>
                                <label style="color:#ff0000">This user admin.</label>
                            <?php endif;?>
                        </div>
                        <div id="user_status">
                            <a href="<?php echo site_url('/admin/deleteUser/'.$user->id) ?>">delete this user</a><br /><br />
                            <label>Block user(ban on add new ads): </label></br>
                            <div id="blocks">
                                <a href="<?php echo site_url('/admin/blockUser/'.$user->id.'/1') ?>">one hour</a><br>
                                <a href="<?php echo site_url('/admin/blockUser/'.$user->id.'/12') ?>">12 hours</a><br>
                                <a href="<?php echo site_url('/admin/blockUser/'.$user->id.'/24') ?>">24 hours</a><br>
                                <a href="<?php echo site_url('/admin/blockUser/'.$user->id.'/168') ?>">one week</a><br>
                            </div>
                        </div>    
                        <div id="user_ads">
                            <label>This user have next ads:</label><br />
                            <?php foreach($ads as $ad):?>
                                <?php if ($ad->nick_id == $user->id):?>
                                  <a href="<?php echo site_url('/ads/showAd/'.$ad->id) ?>" target="_blank"><?php echo $ad->title; ?></a><br>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>    
                    </div>     
                <?php endforeach;?>
            </div>
        <?php endif;?>
</div>
<?php $this->load->view('footer');?>