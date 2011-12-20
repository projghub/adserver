<?
	define( 'MY_CIPHER', MCRYPT_RC2, false );
	define( 'MY_MODE', MCRYPT_MODE_ECB, false );
	define( 'MY_SOURCE', MCRYPT_RAND, false );

	class standard
	{
		var $site;
		var $contactEmail;
		var	$categoryFolder;
		var	$imagesFolder;
		var $headerFile;
		var $footerFile;
		var	$PROMOTIONS;
		var $MAILCONTACTREQUEST;
		var $AUTOREPLYCONTACTREQUEST;
		var $MAILORDERNOTIFY;

		var $LIVE_SERVER;
		
		var $title;
		var $keywords;
		var $description;

		var	$BASEURL;			
		var	$ADMINURL;			
		var	$SECUREURL;			
		var	$BASEPATH;
					
		var	$DBUSER;			
		var	$DB_PASSWORD;			
		var	$DB_NAME;			
		var	$DB_HOST;
					
		var	$TESTREQUEST;			
		var	$AUTHORIZE;			
		var	$ANLOGIN;			
		var	$ANTRANSKEY;			

		var	$DEBUGGING_MODE;
		var	$HANDLE_ERRORS;
		var	$SHOW_ERRORS;
		var	$MAIL_ERRORS;		
		var $REDIRECT_PAGE;
		
		var	$ERROR_LIST;
		var	$ERRORTYPE;
		var	$ERROR_EMAIL;
		var	$ERROR_LOG;
		var	$ERROR_FILE;

		var	$LOG_ERRORS;
		var	$LOG_WARNINGS;
		var	$LOG_NOTICES;
		var	$LOG_UNKNOWN;
		//var	$MAIL_ERRORS;		
		var	$MAIL_WARNINGS;
		var	$MAIL_NOTICES;
		var	$MAIL_UNKNOWN;

		function standard()
		{
			$this->SERVER_USER				= "adserver";
			$this->DOMAIN_NAME				= "localhost/adserver/";
			$this->SITE 					= "site name";
			$this->COMPANY					= "comanyname";
			$this->SERVERNAME				= "www.{$this->DOMAIN_NAME}.com";
			$this->STOREID					= "0";
			$this->LIVE_SERVER				= true;

			$this->ADDRESS 					= "address";
			$this->CITY 					= "city";
			$this->STATE 					= "state";
			$this->ZIP 						= "zip";

			$this->IMAGESFOLDER				= "images";
			$this->BGIMAGE					= "bg_repeat.gif";
			$this->BUTTONIMAGE				= "button.gif";
			$this->BGCOLOR					= "#FFFFFF";
			$this->IMAGESPREFIX1			= "image_";
			$this->IMAGESPREFIX2			= "image2_";
			
			$this->contactEmail 			= "support@{$this->DOMAIN_NAME}.com";
			$this->TOLLFREE		 			= "tollfree";
			$this->PROMOTIONS 				= true;
			$this->MAILCONTACTREQUEST 		= true;
			$this->AUTOREPLYCONTACTREQUEST 	= true;
			$this->MAILORDERNOTIFY	 		= true;

			//Admin Colors
			$this->ADMIN_BGCOLOR			= "#660000";
			$this->ADMIN_ROWCOLOR			= "#FFFFCC";
			
			//default meta tags
			$this->title 					= "title of the site";
			$this->keywords 				= "keywords";
			$this->description				= "Description";

			//default path/urls
			$this->BASEURL 					= "http://{$this->DOMAIN_NAME}";
			$this->ADMINURL					= "http://{$this->DOMAIN_NAME}";
			$this->SECUREURL				= "http://{$this->DOMAIN_NAME}";
			$this->BASEPATH					= "/usr/local/www/data/";
						
			//Database Information
			$this->DB_USER					= "adserving";
			$this->DB_PASSWORD				= "adservingPa44";
			$this->DB_NAME					= "adserving";
			$this->DB_HOST					= "localhost";

			//Authorize.net
			$this->TESTREQUEST				= "FALSE"; //true == send a test request to authorize, false means process it
			$this->AUTHORIZE				= false;  //false == manual, true means use authorize.net
			$this->ANLOGIN					= "";
			$this->ANTRANSKEY				= "";
			
			//DEBUGGING/ERROR information
			$this->DEBUGGING_MODE			= true;
			$this->HANDLE_ERRORS			= false;
			$this->SHOW_ERRORS				= false;
			$this->MAIL_ERRORS				= false;
			$this->REDIRECT_PAGE			= false;

			if($this->DEBUGGING_MODE)
				error_reporting(E_ALL ^ E_NOTICE);
			else
				error_reporting(0);
			
			if($this->HANDLE_ERRORS)
			{
				$this->ERROR_LIST		= array();
				$this->ERROR_EMAIL		= "jon@reenev.com";
				$this->ERROR_LOG		= "/path/to/log/file";
				$this->ERROR_FILE		= "error.php";
				
				//notify, warning, error, fatal
				//CURRENTLY JUST USING EVERYTHING AS ONE, NOT REALLY USING ALL OF THESE YET
				//THIS IS JUST FOR AN IDEA
				$this->LOG_ERRORS		= true;
				$this->LOG_WARNINGS		= true;
				$this->LOG_NOTICES		= true;
				$this->LOG_UNKNOWN		= true;
				//$this->MAIL_ERRORS		= true;  //using this up above
				$this->MAIL_WARNINGS	= true;
				$this->MAIL_NOTICES		= true;
				$this->MAIL_UNKNOWN		= true;
				
				set_error_handler( array( &$this, 'triggerError'));
				register_shutdown_function( array( &$this, '_standard'));
				
				//define error types
				$this->ERRORTYPE = array (
					1		=> "PHP Error",
					2		=> "PHP Warning",
					4		=> "Parsing Error",
					8		=> "PHP Notice",
					16		=> "Core Error",
					32		=> "Core Warning",
					64		=> "Compile Error",
					128		=> "Compile Warning",
					256		=> "PHP User Error",
					512		=> "PHP User Warning",
					1024	=> "PHP User Notice" );
			}
		}

		function _standard()
		{
			//restores the error handler to the default error handler
			restore_error_handler();
			
			return;
		}
		
		//clean up the variable that is passed in
		function cleanUp($variable)
		{
			if( is_array($variable) )
			{
				foreach( $variable as $key=>$val )
				{
					$variable[$key]	= trim(stripslashes(htmlspecialchars(strip_tags($val), ENT_QUOTES)));
				}
			}
			else
			{
				$variable	= trim(stripslashes(htmlspecialchars(strip_tags($variable), ENT_QUOTES)));
			}
			return $variable;
		}
		
		//add note in the admin
		//userId is admin user id, user_id is account user id
		function addNote(&$db, $autonote = 0, $userId = 0, $type, $comment, $user_id = 0)
		{
			$db->query("INSERT INTO note SET 
						autonote	= '$autonote',
						userId 		= '$userId',
						customerId	= '$user_id',
						type		= '$type',
						comment		= '$comment',
						deleted 	= 0,
						date 		= NOW() ");
			
			return ($db->insert_id > 0) ? true : false; //trim(stripslashes(htmlspecialchars(strip_tags($variable), ENT_QUOTES)));
		}
		
		function logPageView(&$db, $user_id, $URL, $sessionId, $serverReferrer, $serverPort, $ipAddress, $platform, $browser)
		{
			if($ipAddress == "66.7.124.35") return;
			
			$db->query("INSERT INTO pageview SET
						user_id 		= '$user_id',
						URL 			= '$URL',
						sessionId 		= '$sessionId',
						serverReferrer 	= '$serverReferrer',
						serverPort 		= '$serverPort',
						ipAddress 		= '$ipAddress',
						platform 		= '$platform',
						browser 		= '$browser',
						date			= NOW()");

			return $db->insert_id;
		}
				
		//overriding error handler with this one
		function triggerError($errorNo, $errorMessage, $errorFile, $errorLine, $context)
		{			
			$myErrorMessage = $this->ERRORTYPE[$errorNo].": ".$errorMessage." on line ".$errorLine.". FILE: ".$errorFile;

			switch($errorNo)
			{
				case E_ERROR:
				case E_USER_ERROR:
					$this->ERROR_LIST[] = array( "type" => "FATAL", "message" => $myErrorMessage);
					break;
				case E_WARNING:
				case E_USER_WARNING:
					$this->ERROR_LIST[] = array( "type" => "WARNING", "message" => $myErrorMessage);
					break;
				case E_NOTICE:
				case E_USER_NOTICE:
					$this->ERROR_LIST[] = array( "type" => "NOTICE", "message" => $myErrorMessage);
					break;
				default:
					$this->ERROR_LIST[] = array( "type" => "UNKNOWN", "message" => $myErrorMessage);
					break;
			}
		}
		
		//check to see if errors have happened on the page and act accordingly
		function checkErrors()
		{
			//check to see if errors have happened.  If they have, log and mail them, and if it
			//was a fatal error, send them to the correct page.
			if(count($this->ERROR_LIST) > 0)
			{
				$body = "";
				
				foreach($this->ERROR_LIST as $myError)
				{
					$body .= "Type: ".$myError["type"]."\r\n";
					$body .= "message: ".$myError["message"]."\r\n\r\n";
				
					if($this->SHOW_ERRORS)
					{
						//print_r($this->ERROR_LIST);			
						echo "<strong>Type:</strong> ".$myError["type"]."<br>";
						echo "<strong>Message:</strong> ".$myError["message"]."<br><br>";
					}
					
					if($myError["type"] == "FATAL")
						$this->REDIRECT_PAGE = true;
				}
				
				$headers  = "From: ".$this->site."\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
				$subject  = "Error Report";
				
				if($this->MAIL_ERRORS)
					mail($this->ERROR_EMAIL, $subject, $body, $headers);

				if($this->REDIRECT_PAGE)
				{
					header("location: ".$this->BASEURL.$this->ERROR_FILE);
					exit;
				}
			}
		}
		
		// do a mod 10 check on a string(credit card)
		function mod10Check($str=null)
		{
			$total	= 0;
			$count	= 0;
			// start from the end of the string
			for( $i=strlen($str)-1; $i>-1; $i-- )
			{
				$add	= $str[$i];
				// if it is 2nd, 4th, 6th, etc, multiply it by 2
				if( $count % 2 == 1 )
				{
					$add	= $add * 2;
					// if there are 2 digits, add them together. i.e. 13 = 1 + 3 = 4
					if( $add > 9 )
					{
						$add	= $add[0] + $add[1];
					}
				}
				// add the appropriate number
				$total	+= $add;
				$count++;
			}
			
			// return true if the total is a multiple of 10, false otherwise
			return ($total % 10 == 0);
		}
		
		// verify that the expiration date is in the future
		function verifyExpDate($ccMonth='01', $ccYear='01')
		{
			if( strtotime(date('Y-m-d')) > strtotime(date("20$ccYear-$ccMonth-t")) )
			{
				return false;
			}
			return true;
		}
		
		// encrypt a string
		function encrypt($str=null)
		{
			$cipher		= MY_CIPHER;
			$mode		= MY_MODE;
			$source		= MY_SOURCE;
			$key		= 'G8 $2^ l6oP W3! fbE8& wRiWsc34h ';
			$iv_size	= mcrypt_get_iv_size($cipher,  $mode);
			$iv			= mcrypt_create_iv($iv_size, $source);
			
			return mcrypt_encrypt($cipher, $key, $str, $mode, $iv);
		}
		
		// decrypt a string
		function decrypt($str=null)
		{
			$cipher		= MY_CIPHER;
			$mode		= MY_MODE;
			$source		= MY_SOURCE;
			$key		= 'G8 $2^ l6oP W3! fbE8& wRiWsc34h ';
			$iv_size	= mcrypt_get_iv_size($cipher,  $mode);
			$iv			= mcrypt_create_iv($iv_size, $source);
			
			return mcrypt_decrypt($cipher, $key, $str, $mode, $iv);
		}
	}	
	
	$myStandard = &new standard();
?>
