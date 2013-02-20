<?php

    define('RSS_TO_JSON_URL', 'http://ajax.googleapis.com/ajax/services/feed/load');
    define('NEWS_URL', 'http://news.google.com/news/feeds');
    define('BOILER_PIPE', 'http://boilerpipe-web.appspot.com/extract');

    function getNewsForTags($tags, $num, $offset)
    {
        //Get the plain news URL
        $query = array(
            'num' => $num,
            'start' => $offset,
            'q' => implode(' OR ', $tags),
            'output' => 'rss'
        );

        $newsUrl = NEWS_URL
            . '?'
            . urldecode(http_build_query($query));

        //Now, get the JSON feed url
        $query = array(
            'v' => '1.0',
            'num' => $num,
            'q' => urlencode($newsUrl)
        );

        $feedUrl = RSS_TO_JSON_URL
            . '?'
            . urldecode(http_build_query($query));

        //Get the news
        $data = json_decode(file_get_contents($feedUrl));

        //Unset the unnecessary content
        $data = $data->responseData->feed;

        $items = array();
        foreach($data->entries as $item)
        {
            //Get all the basic info
            $url = follow_redirect($item->link);
            $source = parse_url($url, PHP_URL_HOST);

            //Assemble the piece
            $items[] = array(
                'title' => $item->title,
                'url' => $url,
                'timestamp' => $item->publishedDate
            );
        }

        return $items;
    }

    /**
     * Follow redirects and get the exact URL
     **/
    function follow_redirect($url){
        $redirect_url = null;

        if(function_exists("curl_init")){
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        else{
            $url_parts = parse_url($url);
            $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80));
            $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n";
            $request .= 'Host: ' . $url_parts['host'] . "\r\n";
            $request .= "Connection: Close\r\n\r\n";
            fwrite($sock, $request);
            $response = fread($sock, 2048);
            fclose($sock);
        }

        $header = "Location: ";
        $pos = strpos($response, $header);
        if($pos === false){
            return false;
        } else
        {
            $pos += strlen($header);
            $redirect_url = substr($response, $pos, strpos($response, "\r\n", $pos)-$pos);
            return $redirect_url;
        }
    }

    /**
     * Get title from URL
     **/
    function getTitleFromUrl($url){
        $str = file_get_contents($url);
        if(strlen($str)>0){
            preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
            return $title[1];
        }
    }

?>