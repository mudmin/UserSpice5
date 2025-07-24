<?php 
//do not edit this script! Please copy it and edit the copy. Updates may overwrite this file.

//you can send whatever other data and instructions you want back to the client here.  

    //this section will automatically add other columns from the users table and send them back to the client
    $other_columns = ['language', 'created', 'email_verified'];
    //we are ignoring id,  username and email for security on the info update
        foreach ($other_columns as $col) {
            $col = trim($col);
            if (isset($user->data()->$col)) {
                $response['userdata'][$col] = $user->data()->$col;
            }
        }

        //this section will automatically add tags from the tags_matches table and send them back to the client
        $response['tags'] = [];
        if ($oauthSettings->include_tags == 1) {
            $tags = $db->query("SELECT * FROM plg_tags_matches WHERE user_id = ?", [$user->data()->id])->results(true);
            foreach ($tags as $tag) {
                $response['tags'][] = $tag;
            }
        }

        //you can add any other data you want to send back to the client here. The example tags are handled automatically.
        $instructions = [
            'updateUserData' => true, //
            'updateTags' => true,
            'createTagIfNeeded'=> true,
            'removeTagIfNotSpecified'=>true,
        ];

        //you can add as many other sections to your response that you want.  Just know that you need a parser script on the other side to process this information.
        $response['instructions'] = $instructions;