<style type="text/css">
div#container
{  
	width: 300px;  
	left: 0;  
	font-family: sans-serif;  
	position: relative;  
	display: inline-block;  
	float: none;  
	color: #000;  
	max-height: 250px;  
	text-align: left;  
	padding: 0;  
	max-width: 300px;  
	line-height: normal;  
	letter-spacing: normal;  
	height: 2500px;  
	font-size: medium;  
	white-space: normal;  
	top: 0;  
	margin: 0;  
	word-spacing: normal; 
}

div#container #format
{  
	max-height: 250px;
	width: 300px;
	left: 0;
	padding: 0;
	max-width: 300px;
	position: absolute;
	clear: both;
	height: 250px;
	border: 0px none #A9A9A9;
	top: 0;
	border-radius: 0;
	background-color: #FFF;
	margin: 0;
	overflow: hidden;
	border-color: #A9A9A9; 
} 

div#container #format a 
{
	color: inherit !important;
	text-decoration: none;
}

div#container .ad
{
	width: auto;
	padding-bottom: 2px;
	padding: 0 0.5em;
	cursor: pointer !important;
	line-height: 15px;
	height: 80px;
	padding-top: 2px;
	padding-left: 2px;
	margin: 0;
	overflow:visible;
} 

div#container .ad-image 
{
	text-align: left;
	width: 100px;
	float: left;
	height: 75px;
	margin-right: 5px;
	border: 0px solid #FF0000;
}

div#container .ad-title 
{
	color: #393;
	max-height: 22px;  
	cursor: pointer !important;
	font-weight: bold;
	font-family: Arial, Verdana, Serif;
	font-style: normal;
	padding-top: 3px;
	font-size: 12px;
	border: 0px solid #660066;	
}

div#container #format a:hover .ad-title 
{
	text-decoration: underline;
}

div#container .ad-desc
{
	color: #000;
	max-height: 35px;
	cursor: pointer !important;
	font-family: Arial, Verdana, Serif;
	font-weight: normal;
	font-style: normal;
	padding-top: 0px;
	font-size: 12px;
	border: 0px solid #FF0000;	
}

div#container .ad-link
{  
	color: #666;
	max-height: 18px;  
	font-family: Arial, Verdana, Serif;
	font-weight: normal;
	font-style: normal;
	font-size: 12px;
	border: 0px solid #FF9900;
}

div#container span 
{
	display: block;
}



</style>

<div id="container">
	<div id="format">
		<div id="ad-list">
		
			<a href="http://localhost/adserver/click.php" target="_blank" onclick="window.open(\'http://localhost/adserver/click.php\');return false;">
				<span class="ad">
					<span class="ad-image">
						<img src="http://localhost/adserver/images/text/<?php echo $ads[0][3] ?>" class="ad-image" />
					</span>
					<span class="ad-title"><?php echo $ads[0][1] ?></span>
					<span class="ad-desc"><?php echo $ads[0][2] ?>&#133;&nbsp;</span>
					<span class="ad-link"><?php echo $ads[0][4] ?></span>
				</span>
			</a>
			
			<a href="http://localhost/adserver/click.php" target="_blank" onclick="window.open(\'http://localhost/adserver/click.php\');return false;">
				<span class="ad">
					<span class="ad-image">
						<img src="http://localhost/adserver/images/text/<?php echo $ads[1][3] ?>" class="ad-image" />
					</span>
					<span class="ad-title"><?php echo $ads[1][1] ?></span>
					<span class="ad-desc"><?php echo $ads[1][2] ?>&#133;&nbsp;</span>
					<span class="ad-link"><?php echo $ads[1][4] ?></span>
				</span>
			</a>
			
			<a href="http://localhost/adserver/click.php" target="_blank" onclick="window.open(\'http://localhost/adserver/click.php\');return false;">
				<span class="ad">
					<span class="ad-image">
						<img src="http://localhost/adserver/images/text/<?php echo $ads[2][3] ?>" class="ad-image" />
					</span>
					<span class="ad-title"><?php echo $ads[2][1] ?></span>
					<span class="ad-desc"><?php echo $ads[2][2] ?>&#133;&nbsp;</span>
					<span class="ad-link"><?php echo $ads[2][4] ?></span>
				</span>
			</a>
			
	</div>
</div>