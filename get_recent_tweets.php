<?php

class Twitter {

    //pass array of users to twitter api to retreive json data
    function get_json_data($users) { 

        //test $users to see if array or string
        if (is_array($users)) {
            $users = implode(',', $users);
        } elseif (is_string($users)) {
        } else {
            echo 'ERROR: $users must be either an array or string with users deliminated by commas';
        }


        $twitter_url = 'http://api.twitter.com/1/users/lookup.json?screen_name=';
        $response = file_get_contents($twitter_url .$users);


        //decode into json object (change false to true in json_decode arg to return as string instead)
        if ($response) { 
            $twitter_data = json_decode($response,false);
            $results = count($twitter_data);
        } else { 
            echo 'error: data could not be loaded from twitter';
        }


        //iterate through retreived data and assign to new array
        $i = 0;
        foreach ($twitter_data as $user) { 
            if (isset($user->status)) { 
                $get_tweets[$i]['name'] = $user->name;
                $get_tweets[$i]['status'] = $user->status->text;
                $get_tweets[$i]['unixtime'] = strtotime($user->status->created_at); //this value is used to sort
                $get_tweets[$i]['time'] = date('g:i a \o\n D F d Y', $get_tweets[$i]['unixtime']); //make date more readable from default twitter date format 
                $i++;
            }
        }

        //sort by most recent date
        function cmp($a, $b) { return strcmp($a['unixtime'], $b['unixtime']); } 
        usort($get_tweets, "cmp");
    
        //return the sorted tweets, end of get_json_data call
        return array_reverse($get_tweets);
    }	

    //output tweets - you will want to style this to your liking
    function get_tweets($users) {
        $latest_tweets = $this->get_json_data($users);
        for ($i = 0; $i < count($latest_tweets); $i++) { 
            echo $latest_tweets[$i]['name'];
            echo "<br />";
            echo $latest_tweets[$i]['status'];
            echo "<br />";
            echo "sent at " . $latest_tweets[$i]['time'];
            echo "<br />";
            echo "<br />";
        }
    }
}

$tweets = new Twitter;
?>
