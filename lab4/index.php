<?php
require_once("utils/functions.php");//include file with functions
require_once("utils/errors.php");
require_once("internal/avaible-users.php");


switch($_GET["action"])
{
	case "user":
		{
			switch($_GET["method"])
			{
				case "login":
				{
					/*echo '<pre>';
					print_r(avaible_users ());
					echo '</pre>';
				*/
					$filename = $_GET["username"];			
					if (file_exists("data/$filename.txt") )
					{
						if (check_user($filename ,$_GET["password"])==true)
						{
							$session=create_session_file($filename);
							login($filename , $_GET["password"],$session );
						}
						else {api_responce_error_user("such user doesn't exist, login is unavaible");}
						
		  			}
					else {
		    			api_responce_error_user("such username doesn't exist");
					}
					break;
				}
				case "logout":
				{
					$filename = $_GET["sessionid"];
							
					if (file_exists("internal/sessions/$filename.txt") )
					{
						logout($_GET[STR_SESSION]);
		  			}
					else {
		    			api_responce_error("such sessionid doesn't exist");
					}
					break;					
				}
				default:
				{
					api_responce_error("such method doesn't exist");
					break;
				}
			}	
		break;	
		}
	case "data":
		{
			switch ($_GET["method"])
			{
				case "set":
				{
					$text=$_GET["text"];
					$sessionid=$_GET["sessionid"];
					if (file_exists("internal/sessions/$sessionid.txt") )
					{
						set($text, $sessionid);
					}
					else {
		    			api_responce_error_user("such sessionid doesn't exist");
						}
					
					break;
				}
				case "get":
				{
					$filename = $_GET["sessionid"];							
					if (file_exists("internal/sessions/$filename.txt") )
					{
						get("internal/sessions/$filename.txt");
					}
					else {
		    			api_responce_error_user("such sessionid doesn't exist");
						}
					break;
				}
				default:
				{
					api_responce_error("such method doesn't exist");
				break;
				}
			}
			break;
		}
	default:
		{api_responce_error("such action doesn't exist");
	break;
}
}

?>