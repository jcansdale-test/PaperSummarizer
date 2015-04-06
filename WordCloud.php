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
    
    function getPapersByKeyword($_keyword, $_topX){
        $topX = $_topX;
        $papers = array();
        $papersID = array();
        $keyword = $_keyword;
        $xml = simplexml_load_string(file_get_contents("http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?querytext=". $keyword . "&hc=" . $topX . "&rs=1"));
        foreach($xml->document as $document){
           # echo $document->title . "   " . $document ->arnumber .  "<br/>";
            $papers[] = $document ->title;
            $papersID[] = $document ->arnumber;
        }
        return $papersID;
    }
    function getWordsByPapers($papersID){
        include_once('simple_html_dom.php');
        $textForWordCloud = "";
        for($i=0; $i<count($papersID); $i++){
            $html = file_get_html("http://ieeexplore.ieee.org/xpl/articleDetails.jsp?tp=&arnumber=" . $papersID[$i]);
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
                                                        $textForWordCloud = $textForWordCloud . $li10->plaintext . " ";
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
        echo $textForWordCloud;

    }

}
$provider = new WordCloud;
$papersID = $provider->getPapersByKeyword("Halfond", 10);
$words =  $provider->getWordsByPapers($papersID);
?>