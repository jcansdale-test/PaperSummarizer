<?php
class WordCloud
{
    function get_string_between($string, $start, $end)
    {
        $string = " " . $string;
        $ini    = strpos($string, $start);
        if ($ini == 0)
            return "";
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
	
	//tested
    function getPapersIDByKeyword($_keyword, $_topX, $_url)
    {
        $topX = $_topX;
        $url  = $_url;
        global $papers;
        $papersID = array();
        $keyword  = $_keyword;
        if (strcmp($url, "http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?querytext=") == 0) {
            $xml = simplexml_load_string(file_get_contents($url . $keyword . "&hc=" . $topX . "&rs=1"));
        } else {
            $xml = simplexml_load_string(file_get_contents($url));
        }
        foreach ($xml->document as $document) {
            $papers[]   = $document->title;
            $papersID[] = $document->arnumber;
        }
        
        return $papersID;
        
    }
	
	//tested
    function getPapersNameByKeyword($_keyword, $_topX, $_url)
    {
        $topX = $_topX;
        $url  = $_url;
        global $papers;
        $papersID = array();
        $keyword  = $_keyword;
        if (strcmp($url, "http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?querytext=") == 0) {
            $xml = simplexml_load_string(file_get_contents($url . $keyword . "&hc=" . $topX . "&rs=1"));
        } else {
            $xml = simplexml_load_string(file_get_contents($url));
        }
        foreach ($xml->document as $document) {
            $papers[]   = trim($document->title);
            $papersID[] = $document->arnumber;
        }
        
        return $papers;
    }
	
	//tested
    function getWordsByPapers($papersID, $url)
    {
        include_once('simple_html_dom.php');
        $textForWordCloud = "";
        for ($i = 0; $i < count($papersID); $i++) {
            $link = $url . $papersID[$i];
            if (strcmp($url, "test/article") == 0) {
                $link .= ".xml";
            }
            $xml = simplexml_load_string(file_get_contents($link));
            foreach ($xml->document as $document) {
                $textForWordCloud = $textForWordCloud . trim($document->abstract) . " ";
            }
            
        }
        return $textForWordCloud;
    }
    function getArticlesByWord($word, $papersID, $_authorName, $_publisherName, $_thePaperID, $_frequency)
    {
        include_once('simple_html_dom.php');
        $articlesWithWord = array();
        global $authorName;
        $authorName = $_authorName;
        global $publisherName;
        $publisherName = $_publisherName;
        global $thePaperID;
        $thePaperID = $_thePaperID;
        global $frequency;
        $frequency = $_frequency;
        $url = "http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?an=";
        for ($i = 0; $i < count($papersID); $i++) {
            $link = $url . $papersID[$i];
            if (strcmp($url, "test/testArticle") == 0) {
                $link .= ".html";
            }
            $xml = simplexml_load_string(file_get_contents($link));
            foreach ($xml->document as $document) {
                $textForWordCloud = $document->abstract . " ";
                if (strpos(strtolower($textForWordCloud), strtolower($word)) !== false) {
                    $articlesWithWord[] = $document->title;
                    $authorName[] = $document->authors;
                    $str = $document->pubtitle;
                    $str = str_replace("]", "", $str);
                    $publisherName[] = $str;
                    $thePaperID[] = $document->arnumber;
                    $frequency[] = substr_count(strtolower($textForWordCloud), strtolower($word));
                }
            }
        }
        
        return $articlesWithWord;
    }
}

?>