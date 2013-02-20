<?php


    /**
     * Get the readable article
     **/
    function getReadableArticle($url, $title)
    {
        //Clean up content
        $r = getContentFromurl($url);
        $r->convertLinksToFootnotes = true;
        $content = $r->getContent()->innerHTML;

        // Clean up with Tidy
        if (function_exists('tidy_parse_string')) {
            $tidy = tidy_parse_string(
                $content,
                array(
                    'indent'=>true,
                    'show-body-only'=>true
                ),
                'UTF8'
            );
            $tidy->cleanRepair();
            $content = $tidy->value;
        }

        return array(
            'title' => $title,
            'link' => $url,
            'content' => $content
        );
    }


?>