<?php 
	$ads[0]['link'] = 'http://www.bgbng.com/';
	$ads[0]['image'] = 'images/1.png';
	$ads[0]['title'] = 'Text Ad 1';
	$ads[0]['description'] = 'Lorem ipsum dolor sit amet, ipsum dolor sit conse ctetuer...';

	$ads[1]['link'] = 'http://www.bgbng.com/';
	$ads[1]['image'] = 'images/2.png';
	$ads[1]['title'] = 'Text Ad 2';
	$ads[1]['description'] = 'Lorem ipsum dolor sit amet, ipsum dolor sit conse ctetuer...';

	$ads[2]['link'] = 'http://www.bgbng.com/';
	$ads[2]['image'] = 'images/3.png';
	$ads[2]['title'] = 'Text Ad 3';
	$ads[2]['description'] = 'Lorem ipsum dolor sit amet, ipsum dolor sit conse ctetuer...';

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style>
			body { margin: 0px; padding: 0px; }
			#container { height: 250px; width: 300px; background-color: #FFF; border: 0px solid #0F0; padding: 0px 0px 1px 0px; margin: 0px 0px 0px 0px; }
			#container a { padding: 0px; margin: 0px; text-decoration: none; }
			#container a:hover { text-decoration: none;  }
			#ad { background-color: #FFF; height: 83px; width: 300px; padding: 1px 0px 0px 0px; margin: 0px 0px 0px 0px; }
			#ad:hover { background-image: url('images/button_bg.gif'); }
			#image { height: 82px; width: 100px; position:relative; float: left; padding: 2px 0px 0px 0px; margin: 0px 3px 0px 3px; }
			#content { height: 82px; width: 194px; position:relative; float: right; padding: 0px; margin: 0px; text-align: left; }
			#content .title { width: 194px; color: #1122CC; font-family: Arial; font-size: 14px; font-weight: bold; text-decoration: underline; }
			#content .description { width: 190px; color: #000; font-family: Arial; font-size: 13px; padding: 2px; }
		</style>
	</head>
	<body>
		<div id="container">
			<a href="<?php echo $ads[0]['link']; ?>">
			<div id="ad">
				<div id="image"><img src="<?php echo $ads[0]['image']; ?>" width="100" height="75" border="0" /></div>
				<div id="content">
					<span class="title"><?php echo $ads[0]['title']; ?></span><br />
					<span class="description"><?php echo $ads[0]['description']; ?></span>
				</div>
			</div>
			</a>
			<a href="<?php echo $ads[1]['link']; ?>">
			<div id="ad">
				<div id="image"><img src="<?php echo $ads[1]['image']; ?>" width="100" height="75" border="0" /></div>
				<div id="content">
					<span class="title"><?php echo $ads[1]['title']; ?></span><br />
					<span class="description"><?php echo $ads[1]['description']; ?></span>
				</div>
			</div>
			</a>
			<a href="<?php echo $ads[2]['link']; ?>">
			<div id="ad">
				<div id="image"><img src="<?php echo $ads[2]['image']; ?>" width="100" height="75" border="0" /></div>
				<div id="content">
					<span class="title"><?php echo $ads[2]['title']; ?></span><br />
					<span class="description"><?php echo $ads[2]['description']; ?></span>
				</div>
			</div>
			</a>
		</div>
	</body>
</html>
