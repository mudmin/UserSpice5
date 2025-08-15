<?php 
//if you're having issues with passwordless logins, these variables can help you debug

//set this to true to log debug info to the logs table. Look for topics of "Passwordless Debug" and "Passwordless Debug UA"
$passwordlessDebug = false;

//set this to true to prevent the vericode from expiring when used. Note that this will allow the vericode to be used multiple times.
//This is useful for debugging, but should not be used in production.  The point of this is to capture which user agents are visiting
//your links in antivirus and security software and triggering their expiration.  Once you capture that, you can actually kill the link
//and prevent the user agent from visiting it again while still allowing your own users to login.

//note that links will still expire after 15 minutes, so the window for this is small.
$do_not_auto_expire = false;

//set this to true to show an error message if the email is not found in the database.  This is useful for debugging, but should not be used in production unless you want to give away which emails are in your database.  If your users are having trouble logging in, you can set this to true to see if the email is being found in the database. This is great when you first setup and your users are having trouble logging in.
$showEmailNotFound = false;

//put any custom logic you want to add in here. This file is included at the top of both the passwordless login and verify pages. Since it is used in both places, you want to have your code wrapped in an if statement.
if(currentPage() == 'passwordless.php'){
    //this is the passwordless login page
    //you can put any custom logic here that you want to run on the passwordless login page
}

if(currentPage() == 'verify.php'){
    //this is the verify page
    //you can put any custom logic here that you want to run on the verify page
}


//do not close the php tag because updates may add additional options to the bottom of this file.