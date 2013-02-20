<?php

    require('db.php');

    /**
     * Determine the HTTP-verb-derived method to call
     **/
    function callMethod()
    {
        $method = ucFirst(strtolower($_SERVER['REQUEST_METHOD']));
        call_user_func('do' . $method);
    }

    /**
     * Obtain the user sent data
     **/
    function getUserData()
    {
        switch ($_SERVER['REQUEST_METHOD'])
        {
            case 'GET':
                return $_GET;
            case 'POST':
                return $_POST;
            case 'PUT':
            case 'DELETE':
                parse_str(file_get_contents("php://input"), $putVars);
                return $putVars;
        }

        return array();
    }

    /**
     * Are all required elements present.
     **/
    function checkRequired($required, $available)
    {
        $providedParams = array_keys($available);
        $missingParams = array_diff($required, $providedParams);

        if ($missingParams)
        {
            endRequest(
                400,
                'Missing params: ' . implode(', ', $missingParams)
            );
        }
    }

    /**
     * Send an array, JSONized back to the user
     **/
    function sendData($data, $params)
    {
        $jsonp = false;
        if(isset($params['callback']))
        {
            $params['callback'] = strip_tags($params['callback']);
            $jsonp = true;
            $pre = $params['callback'] . '(';
            $post = ');';
        }
        $json = json_encode($data);

        echo $jsonp ? $pre . $json . $post : $json;
    }

    /**
     * End request due to errors
     **/
    function endRequest($code, $msg)
    {
        $header = 'HTTP/1.0 ';
        switch($code)
        {
            case 400:
                $header .= '400 Bad request';
                break;
            default:
                $header .= '400 Bad request';
                break;
        }

        header($header);
        die($msg . '.');
    }

    /**
     * Get tags for a single user
     **/
    function getUserTags($userId)
    {
        $sql = "SELECT t.name, t.id, ut.score FROM `user_tags` ut JOIN `tags` t on ut.tag_id = t.id WHERE vdna_user_id = '$userId' ORDER BY score DESC";
        getDb();
        $rs = mysql_query($sql);

        $tags = array();
        while ($row = mysql_fetch_assoc($rs))
        {
            $tags[$row['name']] = $row;
        }

        return $tags;
    }

    /**
     * Check if a user already has the tag
     **/
    function doesUserTagExists($userId, $tag)
    {
        $existingTags = getUserTagInfo($userId, $tag);

        if ($existingTags) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get tag ID by name
     **/
    function getTagIdByName($tagName)
    {
        $sql = "SELECT * from `tags` WHERE name = '$tagName'";
        getDb();
        $rs = mysql_query($sql);

        if ($row = mysql_fetch_assoc($rs))
        {
            return $row['id'];
        }

        return FALSE;
    }

    /**
     * Add a new tag to the DB
     **/
    function addTagToDb($tag)
    {
        $sql = "INSERT INTO `tags` (name, cats) VALUES ('$tag', '2')";
        getDb();
        $rs = mysql_query($sql);
    }

    /**
     * Get user tag info
     **/
    function getUserTagInfo($userId, $tag)
    {
        $sql = "SELECT t.name, t.id, ut.score FROM `user_tags` ut JOIN `tags` t on ut.tag_id = t.id WHERE vdna_user_id = '$userId' and t.name = '$tag'";
        getDb();
        $rs = mysql_query($sql);

        if ($row = mysql_fetch_assoc($rs))
        {
            return $row;
        }
    }

    /**
     * Add tag for the user
     **/
    function addTagForUser($userId, $tag)
    {
        //Check if the tag already exists for the given user
        if (doesUserTagExists($userId, $tag))
        {
            endRequest(
                400,
                'This tag already exists for this user'
            );
        }

        //Next, check if the tag exists in the DB, if not add it
        $id = getTagIdByName($tag);
        if (!(bool)$id)
        {
            addTagToDb($tag);
            $id = getTagIdByName($tag);
        }

        //Add the tag for this particular user
        $sql = "INSERT INTO `user_tags` (tag_id, vdna_user_id, score) VALUES ($id,'$userId',0.1)";
        getDb();
        mysql_query($sql);

        //Send the recently added info back
        return getUserTagInfo($userId, $tag);
    }

    /**
     * Delete the tag for the given user
     **/
    function deleteUserTag($userId, $tag)
    {
        //Check if the yser has this tag
        if (!doesUserTagExists($userId, $tag))
        {
            endRequest(
                400,
                'This tag does not exists for this user'
            );
        }

        //Get the tag ID
        $id = getTagIdByName($tag);

        //Delete the tag
        $sql = "DELETE FROM `user_tags` WHERE tag_id = $id AND vdna_user_id = '$userId'";
        getDb();
        mysql_query($sql);
    }

?>