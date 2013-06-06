<?php
	
	// First Check for user, if exists, login if doesn't create one and login.

	if(!$user)
	{
		exit();
	}

	function createSession($oauthid, $userid)
	{
		$_SESSION['oauthid'] = $oauthid;
		$_SESSION['userid'] = $userid;
	}

	require_once('db.php');
	$query = $dbc->prepare("SELECT * FROM users WHERE oauth_provider='facebook' AND oauth_uid=?");
	$query->execute(array($user['id']));
	if($query->rowCount() == 1)
	{
		// user exists. Create session
		while($data = $query->fetch())
		{
			createSession($data['oauth_uid'], $data['id']);
		}
		header('Location:/home.php');
	}
	else
	{
		// user doesn't exist. Create one.
		$create = $dbc->prepare("INSERT INTO users(oauth_provider,oauth_uid,fullname,fb_username,gender) VALUES(?,?,?,?,?)");
		$create->execute(array('facebook',$user['id'],$user['name'],$user['username'],$user['gender']));

		/* Add whatever you want to add. For the full permission list, check Facebook Developer Docs. */

		$query = $dbc->prepare("SELECT * FROM users WHERE oauth_provider='facebook' AND oauth_uid=?");
		$query->execute(array($user['id']));
		while($data = $query->fetch())
		{
			createSession($data['oauth_uid'], $data['id']);
		}

		/*
		Redirecting to a thank you page.
		You can also redirect to a new page, and ask for additional information, like Email Address, Username, etc. */
		header('Location:/thanks.php');
	}

?>