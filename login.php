<?php

	session_start();

	require("sdk/facebook.php");

	$facebook = new Facebook(array(
			'appId' => 'YourAppID',
			'secret' => 'YourSecretKey',
			'cookie' => true
		));

	$session = $facebook->getUser();

	if(!empty($session))
	{
		// facebook session is active
		try
		{
			$uid = $facebook->getUser();
			$user = $facebook->api('/me');
		}
		catch(Exception $e){}

		if(!empty($user))
		{
			// including the script containing queries to check and insert new user rows.
			require("queries.php");
		}
		else
		{
			// problem.
			die("An Error occured. Please try again later.");
		}
	}
	else
	{
		// no active facebook session
		$login_url = $facebook->getLoginUrl();
		header("Location: " . $login_url);
	}

?>