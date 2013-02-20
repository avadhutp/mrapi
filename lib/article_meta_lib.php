<?php

    require_once('OpenCalais.php');

    define('OPEN_CALAIS_KEY', 'ss96wtgy37a6c5ut2dta5th3');
    define('GOOGLE_IMAGE_API_URL', 'https://ajax.googleapis.com/ajax/services/search/images?v=1.0');

    function getArticleMeta($url, $title)
    {
        $r = getContentFromUrl($url);
        $contents = $r->getContent()->innerHTML;

        return array(
            'image' => getImageFromHtml($contents, $title),
            'tags' => getTagsFromText($contents)
        );
    }

    /**
     * Extract image from HTML
     **/
    function getImageFromHtml($html, $title)
    {
        //Check if the content holds the image
        $dom = new domDocument;
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;
        $images = $dom->getElementsByTagName('img');
        if ($images)
        {
            foreach ($images as $image) {
                return $image->getAttribute('src');
            }
        }

        //If not, give one from Google
        $imageSearchUrl = GOOGLE_IMAGE_API_URL
            . '&q='
            . urlencode($title);

        $feed = json_decode(file_get_contents($imageSearchUrl));
        return $feed->responseData->results[0]->unescapedUrl;
    }

    /**
     * Get tags from content
     **/
    function getTagsFromText($text)
    {
        $calais = new OpenCalais(OPEN_CALAIS_KEY);
        $calais->get($text);

        return array_keys($calais->getSocialTags());
    }

?>