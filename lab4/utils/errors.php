<?php
require_once("utils/functions.php");//include file with functions
function api_responce_error($message)
{
	api_response(array(STR_ERROR_MESSAGE=>$message));
}
function api_responce_error_user($message)
{
	api_response(array(STR_SESSION=>null,STR_ERROR_MESSAGE=>$message));
}

?>