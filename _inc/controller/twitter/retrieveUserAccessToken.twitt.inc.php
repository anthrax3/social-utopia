<?php
use Abraham\TwitterOAuth\TwitterOAuth;
//Debugging
    //echo '<pre>'; print_r ($_SESSION); echo '</pre>'; 
// Check to see if user is logged in already to his twitter for the selected fb page
if ( !isset( $_SESSION['userInformation']->$managingUserPageId->twitter ) ) {
	// Check response to make user user authorized the access
	if ( !isset( $_GET ['denied'] ) ) {
    // Create new Twitter API Connection with new user credentials
	$this->twitterConnection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_GET['oauth_token'], $_GET['oauth_verifier']);
        
        //Debugging
    //echo '<pre>'; print_r ($_SESSION); echo '</pre>'; 
        
	// Retrieve final user access token
	//$this->access_token = $_SESSION['twitterLoggedInUserToken'] = $this->twitterConnection->oauth("oauth/access_token", [ "oauth_verifier" => $_GET['oauth_verifier'] ]);
	$this->access_token = $this->twitterConnection->oauth("oauth/access_token", [ "oauth_verifier" => $_GET['oauth_verifier'] ]);
        ;
	// Set Twitter Logged In for user to true
	//$_SESSION['twitterLoggedIn'] = true;

    // Save twitter tokens in user session
	$managingUserPageId = $_SESSION['lastFbPageToManage'];
	$_SESSION['userInformation']->$managingUserPageId->twitter = new stdClass();
    // Store twitter information under facebook page id for connection
	$_SESSION['userInformation']->$managingUserPageId->twitter = $this->access_token;
	
    //Debugging
   // echo '<pre>'; print_r ($_SESSION); echo '</pre>';     
	
    // Redirect User To App
	header('Location: ' . APP_URL . '?twitterLoggedIn=true');
    } else {
	// If user did not authorize access to his account then throw error
    echo '<h1>Authorization Error</h1>';
	exit();
    }
}