<?php
require('get_recent_tweets.php');

//$users is array (or string with users deliminated by commas) of users you want to get the latest tweet from
//e.g. $users = ('ladygagasucks', 'justinbieberisgay', 'kimkardashianisannoying', 'chrisbrowncandance', 'slayerrules')

//replace $users with your users here:
$users = array('');

//this is only line needed to output all the tweets
$tweets->get_tweets($users);
?>

