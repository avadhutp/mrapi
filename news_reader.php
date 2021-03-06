<?php

    require_once('lib/common.php');
    require_once('lib/news_reader_lib.php');

    callMethod();

    /**
     * Handle the POST request.
     * Provide a JSON feed of news items as per supplied tags.
     **/
    function doGet()
    {
        //Params required for POST processing
        $required = array(
            'tags',
            'offset',
            'num',
            'newsSession'
        );

        $availParams = getUserData();

        //Check if all required params are available
        checkRequired($required, $availParams);

        //Get the news items
        $news = getNewsForTags($availParams['tags'], $availParams['num'], $availParams['offset']);

        //Send the news
        sendData($news);
    }

?>