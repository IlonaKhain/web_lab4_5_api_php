<?php
function avaible_users ()
{
	$count=0;
	$dir = "data/";
	$files=scandir($dir);
	foreach($files as $user_file)
	{
		$path = "data/$user_file";
		//echo "username: ";
		$username_file = basename($user_file, ".txt");
		//echo $username_file."<br>";
		if (file_exists($path)&& substr($path, -4)===".txt") {
   		$password =file_get_contents($path);
			$password_arr=preg_split("/(?<=\w)\b\s*[!?.=,\s\b]*/", $password);
			/*echo '<pre>';
			print_r($password_arr);
			echo '</pre>';*/
			$db_avaible_users[$count][0]=$username_file;
			$db_avaible_users[$count][1]=$password_arr[1];
		}
		else{
			
		};
		
		$count++;
	}
	return $db_avaible_users;
}
function check_user($user, $pass)
{
	$db_avaible_users=avaible_users ();
	foreach ($db_avaible_users as $row ) {
		if ($row[0]==$user && $row[1]==$pass){
			
			return true;
		}
	}
	return false;
}
function create_session_file($user){
	$newname = bin2hex(openssl_random_pseudo_bytes(4));
	$myfile = fopen("internal/sessions/$newname.txt", "w");
	$txt = "username=$user";
	fwrite($myfile, $txt);
	fclose($myfile);
	return $newname;
}
?>