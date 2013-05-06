<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="icon" type="image/x-icon" href="http://zahar-test.com/autoads/images/favicon(2).ico" />
		<link rel="shortcut icon" type="image/x-icon" href="http://zahar-test.com/autoads/images/favicon(2).ico" />
		<link rel="stylesheet" type="text/css" media="all" href="http://zahar-test.com/autoads/css/mystyle.css">
                <link rel="stylesheet" type="text/css" href="http://zahar-test.com/autoads/css/prettyPhoto.css">    
                <link rel="stylesheet" type="text/css" href="http://zahar-test.com/autoads/css/jquery.autocomplete.css"/>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
                <script type="text/javascript" src="http://zahar-test.com/autoads/js/jquery-1.3.2.min.js"></script>
                <script type="text/javascript" src="http://zahar-test.com/autoads/js/jquery.autocomplete.pack.js"></script>
                <script type="text/javascript" src="http://zahar-test.com/autoads/js/search.js"></script>
                <script type="text/javascript" src="http://zahar-test.com/autoads/js/jquery.prettyPhoto.js"></script>

		<title>Autoads</title>
	</head>
	<body>
		<div id="header">
                    <div id="ReqAuth">
                        <ul>
                            <li><a href="<?php echo base_url()?>registrate/addUser/"><b>Registration</b></a></li>
                            <?php if (check_user_authorization() == 0) :?>
                                <li><a href="<?php echo base_url()?>authorization/authUser/"><b>Authorization</b></a></li>
                            <?php else :?>    
                                <li><a href="<?php echo base_url()?>authorization/logoff/"><b>Logoff</b></a></li>
                            <?php endif;?>
			</ul>
                    </div>
                    <h1><a href="<?php echo base_url()?>">AutoAds</a></h1>
                    <h2>Ads about secondhand cars for sale</h2>
		</div>
		<div id="menu">
                    <?php if ((check_user_authorization() == 0) && !(check_administrator())) :?>
                        <ul>
                            <li class ="black_min"></li>
                            <li><a href="<?php echo base_url()?>">Show ads</a></li>
                            <li><a href="<?php echo base_url()?>ads/addNewAd/">Add new ad</a></li>
                            <li><a href="<?php echo base_url()?>authorization/authUser/"><b>Authorization</b></a></li>
                            <li><a href="<?php echo base_url()?>registrate/addUser/">Registration</a></li>
                            <li><a href="<?php echo base_url()?>admin/contact/">Contact us</a></li>
                            <li><a href="<?php echo base_url()?>admin/about/">About</a></li>
                            <li class ="black_min"></li>
			</ul>
                    <?php elseif (check_administrator()==TRUE) :?>
                        <ul>
                            <li><a href="<?php echo base_url()?>">Show ads</a></li>
                            <li><a href="<?php echo base_url()?>ads/addNewAd/">Add new ad</a></li>
                            <li><a href="<?php echo base_url()?>registrate/addUser/">Registration</a></li>
                            <?php if (check_user_authorization() == 0) :?>
                                <li><a href="<?php echo base_url()?>authorization/authUser/"><b>Authorization</b></a></li>
                            <?php else :?>    
                                <li><a href="<?php echo base_url()?>authorization/logoff/"><b>Logoff</b></a></li>
                            <?php endif;?>
                            <li><a href="<?php echo base_url()?>admin/contact/">Contact us</a></li>
                            <li><a href="<?php echo base_url()?>admin/about/">About</a></li>
                            <li><a href="<?php echo base_url()?>admin/main/">AdminPage</a></li>
			</ul>
                    <?php else :?>
                        <ul>
                            <li class ="black"></li>
                            <li><a href="<?php echo base_url()?>">Show ads</a></li>
                            <li><a href="<?php echo base_url()?>ads/addNewAd/">Add new ad</a></li>    
                            <li><a href="<?php echo base_url()?>authorization/logoff/"><b>Logoff</b></a></li>
                            <li><a href="<?php echo base_url()?>admin/contact/">Contact us</a></li>
                            <li><a href="<?php echo base_url()?>admin/about/">About</a></li>
                            <li class ="black"></li>
			</ul>
                    <?php endif;?>
		</div>