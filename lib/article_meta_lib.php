<?php

    require_once('OpenCalais.php');
    require_once('Readability.php');

    define('OPEN_CALAIS_KEY', 'ss96wtgy37a6c5ut2dta5th3');

    function getArticleMeta($url)
    {
        $contents = getContentFromUrl($url);

        return array(
            'image' => getImageFromHtml($contents),
            'tags' => getTagsFromText($contents)
        );
    }

    /**
     * Get content from URL
     **/
    function getContentFromUrl($url, $format = 'json')
    {
        //Get content and clean it up
        $html = file_get_contents($url);
        if (function_exists('tidy_parse_string')) {
            $tidy = tidy_parse_string($html, array(), 'UTF8');
            $tidy->cleanRepair();
            $html = $tidy->value;
        }

        //Let Readability do the talking
        $r = new Readability($html, $url);
        $r->init();
        return $r->getContent()->innerHTML;

    }

    /**
     * Extract image from HTML
     **/
    function getImageFromHtml($html)
    {
        $dom = new domDocument;
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $image) {
            return $image->getAttribute('src');
        }
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