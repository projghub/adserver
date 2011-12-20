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

div#container .ad-image 
{
	text-align: left;
	width: 104px;
	float: left;
	background: url(http://localhost/adserver/images/templates/toggle-drop-shadow.png) no-repeat top left;
	height: 80px;
	margin-right: 9px;
}

div#container .ad-link
{  
	max-height: 25px;  
	height: 20px;  
	display: none;  
	min-height: 25px; 
}

div#container a:hover .ad 
{
	background: url(http://localhost/adserver/images/templates/mockup_toggle_hybrid_highlight.png) no-repeat top left;
}

div#container span 
{
	display: block;
}

div#container .copy-ad-title 
{
	text-align: center;
	color: #393;
	cursor: pointer !important;
	font-weight: normal;
	font-family: Trebuchet, Trebuchet MS, Helvetica, Sans-Serif;
	font-style: normal;
	padding-top: 15px;
	font-size: 17px;
}

div#container #format a:hover .copy-ad-title 
{
	text-decoration: underline;
}

div#container .copy-ad-link
{
	text-align: center;
	text-decoration: underline;
	cursor: pointer !important;
	font-family: Arial, Verdana, Serif;
	font-weight: normal;
	padding-top: 5px;
	font-size: 11px;
	color: #393;
	font-style: normal;
}

div#container .ad-desc
{
	max-height: 55px;
	height: 55px;
	display: none;
	min-height: 55px;
}

div#container #format a 
{
	color: inherit !important;
	text-decoration: none;
}

div#container .copy-ad-image 
{  width:   100px;  float:   left;  cursor:   pointer !important;  margin-top:   2px;  height:   75px;  display:   inline;  border:   none; } 


div#container #format {  max-height:   250px;  width:   300px;  left:   0;  padding:   0;  max-width:   300px;  position:   absolute;  clear:   both;  height:   250px;  border:   0px none #A9A9A9;  top:   0;  border-radius:   0;  background-color:   #FFF;  margin:   0;  overflow:   hidden;  border-color:   #A9A9A9; } 

div#container .ad {  width:   auto;  padding-bottom:   2px;  padding:   0 0.5em;  cursor:   pointer !important;  line-height:   15px;  height:   80px;  padding-top:   2px;  padding-left:   2px;  margin:   0;  overflow:   visible; } 

div#container .copy-ad-desc {  text-align:   center;  color:   #000;  cursor:   pointer !important;  font-family:   Arial, Verdana, Serif;  font-weight:   normal;  font-style:   normal;  padding-top:   8px;  font-size:   11px; } 

</style>

<script type="text/javascript">
function toggle_title_to_desc ( ad ) { ad.children[1].style.display="none"; ad.children[2].style.display="block"; ad.children[3].style.display="block"; }
function toggle_desc_to_title ( ad, offset ) { ad.children[1].style.display="block"; ad.children[2].style.display="none"; ad.children[3].style.display="none"; }
</script>

<div id="container">
	<div id="format">
		<div id="ad-list">
			<img src="http://localhost/adserver/p?var=foo" alt="" style="display:none;" />

			<a href="http://localhost/adserver/click.php" target="_blank" onclick="window.open(\'http://localhost/adserver/click.php\');return false;">
				<span class="ad" onmouseover="toggle_title_to_desc(this)" onmouseout="toggle_desc_to_title(this)">
					<span class="ad-image">
						<img src="http://localhost/adserver/images/text/<?php echo $ads[0][3] ?>" class="copy-ad-image" />
					</span>
					<span class="ad-title">
						<span class="copy-ad-title"><?php echo $ads[0][1] ?></span>
					</span>
					<span class="ad-desc">
						<span class="copy-ad-desc"><?php echo $ads[0][2] ?>&#133;&nbsp;</span>
					</span>
					<span class="ad-link">
						<span class="copy-ad-link">Explore Now...</span>
					</span>
				</span>
			</a>

			<a href="http://localhost/adserver/click.php" target="_blank" onclick="window.open(\'http://localhost/adserver/click.php\');return false;">
				<span class="ad" onmouseover="toggle_title_to_desc(this)" onmouseout="toggle_desc_to_title(this)">
					<span class="ad-image">
						<img src="http://localhost/adserver/images/text/<?php echo $ads[1][3] ?>" class="copy-ad-image" />
					</span>
					<span class="ad-title">
						<span class="copy-ad-title"><?php echo $ads[1][1] ?></span>
					</span>
					<span class="ad-desc">
						<span class="copy-ad-desc"><?php echo $ads[1][2] ?>&#133;&nbsp;</span>
					</span>
					<span class="ad-link">
						<span class="copy-ad-link">Explore Now...</span>
					</span>
				</span>
			</a>
			
			<a href="http://localhost/adserver/click.php" target="_blank" onclick="window.open(\'http://localhost/adserver/click.php\');return false;">
				<span class="ad" onmouseover="toggle_title_to_desc(this)" onmouseout="toggle_desc_to_title(this)">
					<span class="ad-image">
						<img src="http://localhost/adserver/images/text/<?php echo $ads[2][3] ?>" class="copy-ad-image" />
					</span>
					<span class="ad-title">
						<span class="copy-ad-title"><?php echo $ads[2][1] ?></span>
					</span>
					<span class="ad-desc">
						<span class="copy-ad-desc"><?php echo $ads[2][2] ?>&#133;&nbsp;</span>
					</span>
					<span class="ad-link">
						<span class="copy-ad-link">Explore Now...</span>
					</span>
				</span>
			</a>
	</div>
</div>