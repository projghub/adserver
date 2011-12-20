<?php 
	header("content-type: application/x-javascript");

	$token = sha1(time());

	$ads[0]['link'] = 'http://www.bgbng.com/';
	$ads[0]['image'] = 'http://173.203.243.140/images/text/bgbng.gif';
	$ads[0]['title'] = 'Increase Customer Revenue';
	$ads[0]['description'] = 'Keep customers longer with our new Retention Reporting..';

	$ads[1]['link'] = 'http://www.griffinhillconsulting.com/';
	$ads[1]['image'] = 'http://173.203.243.140/images/text/anxiety.jpg';
	$ads[1]['title'] = '1 Way To Feel Happy';
	$ads[1]['description'] = 'Researchers have discovered a simple secret to happier living...';

	$ads[2]['link'] = 'http://www.bgbng.com/';
	$ads[2]['image'] = 'http://173.203.243.140/images/text/home.png';
	$ads[2]['title'] = 'Secret of a Home Business';
	$ads[2]['description'] = 'Find out how moms can make extra money from the comfort of their home..';

	shuffle($ads);

	echo 'document.write(\'<style type="text/css">#container'.$token.' { height: 250px; width: 300px; background-color: #FFF; border: 0px solid #0F0; padding: 0px 0px 1px 0px; margin: 0px 0px 0px 0px; } #container'.$token.' a { padding: 0px; margin: 0px; text-decoration: none; } #container'.$token.' a:hover { text-decoration: none; } #ad'.$token.' { background-color: #FFF; height: 83px; width: 300px; padding: 1px 0px 0px 0px; margin: 0px 0px 0px 0px; } #ad'.$token.':hover { background-image: url("images/button_bg.gif"); } #image'.$token.' { height: 82px; width: 100px; position:relative; float: left; padding: 2px 0px 0px 0px; margin: 0px 3px 0px 3px; } #content'.$token.' { height: 82px; width: 194px; position:relative; float: right; padding: 0px; margin: 0px; text-align: left; } #content'.$token.' .title'.$token.' { width: 194px; color: #1122CC; font-family: Arial; font-size: 14px; font-weight: bold; text-decoration: underline; } #content'.$token.' .description'.$token.' { width: 190px; color: #000; font-family: Arial; font-size: 13px; padding: 2px; } </style><div id="container'.$token.'"><a href="'.$ads[0]['link'].'"><div id="ad'.$token.'"><div id="image'.$token.'"><img src="'.$ads[0]['image'].'" width="100" height="75" border="0" /></div><div id="content'.$token.'"><span class="title'.$token.'">'.$ads[0]['title'].'</span><br /><span class="description'.$token.'">'.$ads[0]['description'].'</span></div></div></a><a href="'.$ads[1]['link'].'"><div id="ad'.$token.'"><div id="image'.$token.'"><img src="'.$ads[1]['image'].'" width="100" height="75" border="0" /></div><div id="content'.$token.'"><span class="title'.$token.'">'.$ads[1]['title'].'</span><br /><span class="description'.$token.'">'.$ads[1]['description'].'</span></div></div></a><a href="'.$ads[2]['link'].'"><div id="ad'.$token.'"><div id="image'.$token.'"><img src="'.$ads[2]['image'].'" width="100" height="75" border="0" /></div><div id="content'.$token.'"><span class="title'.$token.'">'.$ads[2]['title'].'</span><br /><span class="description'.$token.'">'.$ads[2]['description'].'</span></div></div></a></div>\');';
