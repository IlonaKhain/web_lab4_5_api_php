<?php
const STR_USER ="user"; //initialize const
const STR_SESSION ="sessionid";
const STR_ERROR_MESSAGE ="errormessage";
const STR_LOGOUT_MESSAGE="logoutmessage";
const STR_TEXT ="text";
function login($user,$pass, $sessionid){
	api_response(array(STR_SESSION=>$sessionid, STR_ERROR_MESSAGE=>null));
}
// create such errors:
//user doesn't exist - get error for login
// check pass to avaible users
function api_response($value)
{
	echo json_encode($value);
	exit();
}

function logout($_session){
	//session_start();
	//unset($_session);
	//session_destroy();
	unlink("internal/sessions/$_session.txt");
	api_response(array(STR_LOGOUT_MESSAGE=>"logout is successfuly done"));
}
function get($_path){
	$sessionid_content =file_get_contents($_path);
	$sessionid_content_arr=preg_split("/(?<=\w)\b\s*[!?.=,\s\b]*/", $sessionid_content); //To separate by spaces/tabs/newlines/equals:
	json_encode($sessionid_content_arr);
	$username=$sessionid_content_arr[1];
	
					if (file_exists("data/$username.txt") )
					{	
						 if($_GET["isFull"]==1)	{
						 	$text = file_get_contents("data/$username.txt", NULL, NULL, strlen(file("data/$username.txt")[0]));
						 	api_response(array(STR_TEXT=>$text,STR_ERROR_MESSAGE=>null));
						 }	
						 elseif ($_GET["isFull"]==0)	
						 {
						 	$offset=$_GET["offset"];
						 	$text = file_get_contents("data/$username.txt", NULL, NULL, strlen(file("data/$username.txt")[0])+$offset,20);
						 	api_response(array(STR_TEXT=>$text,STR_ERROR_MESSAGE=>null));
						 }
						else{
							api_responce_error_user("error argument for text length ");
						}							
			  		}
					else {
		    			api_responce_error_user("such sessionid doesn't have suitable username ");		    		
					}

}
function set($text, $sessionid)
{
	$sessionid_content =file_get_contents("internal/sessions/$sessionid.txt");
	$sessionid_content_arr=preg_split("/(?<=\w)\b\s*[!?.=,\s]*/", $sessionid_content); //To separate by spaces/tabs/newlines/equals:
	 json_encode($sessionid_content_arr);
	/*echo '<pre>';
	print_r($sessionid_content_arr);
	echo '</pre>';*/
	$username=$sessionid_content_arr[1];
					if (file_exists("data/$username.txt") )
					{
						file_put_contents("data/$username.txt", $text, FILE_APPEND | LOCK_EX);
		  			}
					else {
		    			api_responce_error_user("such sessionid doesn't have suitable username");
					}
	
api_response(array(STR_LOGOUT_MESSAGE=>"set is successfuly done"));
}
?>