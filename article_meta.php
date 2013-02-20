<?php

    require_once('lib/common.php');
    require_once('lib/article_meta_lib.php');

    callMethod();

    /**
     * Handle the POST request.
     * Provide a JSON feed of news items as per supplied tags.
     **/
    function doGet()
    {
        //Params required for POST processing
        $required = array(
            'url'
        );

        $availParams = getUserData();

        //Check if all required params are available
        checkRequired($required, $availParams);

        //Get the data
        $meta = getArticleMeta($availParams['url']);

        sendData($meta, $availParams);
    }

?>