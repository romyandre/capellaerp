<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"[]>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
        <!--
        Created by Artisteer v3.0.0.39952
        Base template (without user's data) checked by http://validator.w3.org : "This page is valid XHTML 1.0 Transitional"
        -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo CHtml::encode(Yii::app()->name); ?></title>

        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" type="text/css" media="screen, projection" />
		
        <!-- <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" type="text/css" media="screen, projection" /> -->
        <!--[if IE 6]><link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.ie6.css" type="text/css" media="screen" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.ie7.css" type="text/css" media="screen" /><![endif]-->

        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/css/script.js"></script>
    </head>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"[]>
    <body>
	
		<div id="art-page-background-glare-wrapper">
			<div id="art-page-background-glare"></div>
		</div>
		
        <div id="art-main">
                <div class="cleared reset-box"></div>
					<div class="art-bar art-nav">
						<div class="art-nav-outer">
							<div class="art-nav-wrapper">
								<div class="art-nav-inner">
									<?php
										$this->widget('application.components.ArtMenu', array(
											'cls' => 'art-hmenu',
											'prelinklabel' => '<span class="l"></span><span class="r"></span><span class="t">',
											'postlinklabel' => '</span>',
											'items' => array(
												array('label' => 'Home', 'url' => array('/site/index')),
												array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
												array('label' => 'Contact', 'url' => array('/site/contact')),
												array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
												array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
											),
										));
									?>
								</div>
							</div>
						</div>
					</div>
            <div class="cleared reset-box"></div>
			
            <div class="art-header">
                <div class="art-header-position">
                <div class="art-header-wrapper">
					<div class="cleared reset-box"></div>
                    <div class="art-header-inner">
                        <div class="art-headerobject"></div>
                        <div class="art-logo">
                            <h1 class="art-logo-name"><a href="#"><?php echo isset(Yii::app()->params['art-logo-name']) ? Yii::app()->params['art-logo-name'] : Yii::app()->name; ?></a></h1>
                            <h2 class="art-logo-text"><?php echo Yii::app()->params['art-logo-text']; ?></h2>
                        </div>
                    </div>
                </div>
				</div>
			</div>
            <div class="cleared reset-box"></div>
			
			<div class="art-box art-sheet">
				<div class="art-box-body art-sheet-body">
					<div class="art-layout-wrapper">
						<div class="art-content-layout">
							<div class="art-content-layout-row">
								<!-- removed sidebar HTML and set aside -->
								<!-- goes before ..."art-layout-cell art-content" in page.html original -->
								<!-- Main content goes here -->
								<?php echo $content; ?>
							</div>
							<div class="cleared"></div>
						</div> <div class="cleared"></div>
							
						<div class="art-footer">
							<div class="art-footer-body">
								<div class="art-footer-text">
									<ul>
										<li style="float:left;width:200px;">
											<p style="font: 18px 'Trebuchet MS'; color: #808080;">Information</p><br />
											<ul>
												<li><a href="#">Welcome</a></li>
												<li><a href="#">Organization</a></li>
												<li><a href="#">Schedule</a></li>
												<li><a href="#">People</a></li>
												<li><a href="#">Management</a></li>
											</ul>
										</li>

										<li style="float:left;width:200px;">
											<p style="font: 18px 'Trebuchet MS'; color: #808080;">Location</p><br />
											<ul>
												<li><a href="#">Area Map</a></li>
												<li><a href="#">Address</a></li>
												<li><a href="#">Contact Us</a></li>
											</ul>
										</li>
											
										<li style="float:left;margin-right:30px;width:200px;">
											<p style="font: 18px 'Trebuchet MS'; color: #808080;">Company</p><br />
											<ul>
												<li><a href="#">About Us</a></li>
												<li><a href="#">Terms</a></li>
											</ul>
										</li>
									</ul>
									<br />
									
									<p style="text-align: right;"><a href="#"><img width="32" height="32" alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/css/images/rss_32-2.png" style="margin-right:10px;" /></a><a href="#"><img width="32" height="32" alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/css/images/twitter_32-2.png" style="margin-right: 10px; cursor: text;" /></a><a href="#"><img width="32" height="32" alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/css/images/facebook_32-2.png" /></a></p><br />
									<br />
									<p style="text-align: right;">Copyright © 2011 All Rights Reserved.</p>
									<p style="text-align:right;">Icons by <a href="http://www.IconEden.com">IconEden</a></p>
								</div> <div class="cleared"></div>
							</div>
						</div> <div class="cleared"></div>
                    </div>
				</div>
			</div> <div class="cleared"></div>
			<p class="art-page-footer"><a href="http://www.artisteer.com/?p=website_templates" target="_blank">Website Template</a> created with Artisteer.</p>
			<div class="cleared"></div>
		</div>
    </body>
</html>
