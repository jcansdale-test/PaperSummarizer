<?php
class WordCloud
{
	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}
    
    function getPapersByKeyword($_keyword, $_topX, $_url){
        $topX = $_topX;
		$url = $_url;
        $papers = array();
        $papersID = array();
        $keyword = $_keyword;
		if(strcmp($url, "http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?querytext=") == 0) {
			$xml = simplexml_load_string(file_get_contents($url . $keyword . "&hc=" . $topX . "&rs=1"));
		}
		else {
			$xml = simplexml_load_string(file_get_contents($url));
		}
        
        foreach($xml->document as $document){
           # echo $document->title . "   " . $document ->arnumber .  "<br/>";
            $papers[] = $document ->title;
            $papersID[] = $document ->arnumber;
        }
		
        return $papersID;
    }
    function getWordsByPapers($papersID, $url){
        include_once('simple_html_dom.php');
        $textForWordCloud = "";
        for($i=0; $i<count($papersID); $i++){
			//"http://ieeexplore.ieee.org/xpl/articleDetails.jsp?tp=&arnumber="
			$link = $url . $papersID[$i];
			
			if(strcmp($url, "test/testArticle") == 0) {
				$link .= ".html";
			}
			
            $html = file_get_html($link);
            foreach ($html->find('body') as $ul) {
                foreach ($ul->find('div[id=LayoutWrapper]') as $li) {
                    foreach ($li->find('div[id=article-page]') as $li2) {
                        foreach ($li2->find('div[id=article-page-layout]') as $li3) {
                            foreach ($li3->find('div[id=article-page-bdy-wrap]') as $li4) {
                                foreach ($li4->find('div[id=article-page-bdy]') as $li5) {
                                    foreach ($li5->find('div[id=tabs-main]') as $li6) {
                                        foreach ($li6->find('div[class=tab-content]') as $li7) {
                                            foreach ($li7->find('div[class=article-blk]') as $li8) {
                                                foreach ($li8->find('div[class=article]') as $li9) {
                                                    foreach ($li9->find('p') as $li10) {
                                                        #echo $li10->plaintext;
                                                        $textForWordCloud = $textForWordCloud . trim($li10->plaintext) . " ";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
		
        return $textForWordCloud;
    }
}

/*
$provider = new WordCloud;
$papersID = $provider->getPapersByKeyword("Halfond", 10);
$words =  $provider->getWordsByPapers($papersID);
*/
?>