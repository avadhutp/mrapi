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

        header('Content-type: application/json');
        echo $json;
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

?>