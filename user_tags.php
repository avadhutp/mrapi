<?php
    require_once('lib/common.php');
    require_once('lib/user_tags_lib.php');

    callMethod();

    /**
     * Handle the GET request.
     * Provide a weighted JSON of all array tags of the given user.
     **/
    function doGet()
    {
        //Params required for GET processing
        $required = array(
            'vdna_user_id'
        );

        $availParams = getUserData();

        //Check if all the required params are available
        checkRequired($required, $availParams);

        //Get the tags for a single user
        $data = getUserTags($availParams['vdna_user_id']);

        //Send the data to the user
        sendData($data, $availParams);
    }

    /**
     * Handle the PUT request
     * Adds a tag to the user's set
     **/
    function doPut()
    {
        //Params required for PUT processing
        $required = array(
            'vdna_user_id',
            'tag'
        );

        $availParams = getUserData();

        //Check if all the required params are available
        checkRequired($required, $availParams);

        //Add the tag
        $addTagReturn = addTagForUser($availParams['vdna_user_id'], $availParams['tag']);

        //Send data
        sendData($addTagReturn, $availParams);
    }

    /**
     * Handle the DELETE request
     * Remove a tag from the user's set
     **/
    function doDelete()
    {
        //Params required for DELETE processing
        $required = array(
            'vdna_user_id',
            'tag'
        );

        $availParams = getUserData();

        //Check if all the required params are available
        checkRequired($required, $availParams);

        //Delete the user-tag
        deleteUserTag($availParams['vdna_user_id'], $availParams['tag']);
    }
?>