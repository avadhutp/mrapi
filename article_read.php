<?php

    require_once('lib/common.php');
    require_once('lib/article_read_lib.php');

    callMethod();

    /**
     * Handle the GET request.
     * Provide a JSON feed of news items as per supplied tags.
     **/
    function doGet()
    {
        //Params required for POST processing
        $required = array(
            'url',
            'title'
        );

        $availParams = getUserData();

        //Check if all required params are available
        checkRequired($required, $availParams);

        //Get the data
        $readable = getReadableArticle($availParams['url'], $availParams['title']);

        sendData($readable, $availParams);
    }

?>