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
	
    function getLyricsByArtist($artist, $site, $upperSongLimit)
    {
        include_once('simple_html_dom.php');
        // Create DOM from URL or file
        $artist = str_replace(" ", "-", $artist);
        $artist = strtolower($artist);
		
		try {
			$html = file_get_html($site . $artist . '-lyrics.html');
		} catch (Exception $e) {
			return "<div>Invalid Artist</div>";
		}
        
        $song_links = array();
        $str = "";
        $massivesonglyrics = "";

        foreach ($html->find('a') as $element) {
            if (strpos($element, '-lyrics-' . $artist) !== false) {
                $song_links[] = $element->href;
            }
        }
		
		$song_size = count($song_links);
		if ($song_size > $upperSongLimit) {
            $song_size = $upperSongLimit;
        } 
		
        for ($x = 0; $x < $song_size; $x++) {
            $htmlsong = file_get_html($song_links[$x]);
            foreach ($htmlsong->find('div[id=lyrics-body-text]') as $lyrics) {
                $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
                $massivesonglyrics = $massivesonglyrics . $str;
            }
        }
        return $massivesonglyrics;
	}
	
    function getSongsByWord($_word, $_artist, $_site, $upperSongLimit)
    {
        include_once('simple_html_dom.php');
        // Create DOM from URL or file
        $artist = $_artist;
        $word = $_word;
        $artist = str_replace(" ", "-", $artist);
        $artist = strtolower($artist);
        $html = file_get_html($_site . $artist . '-lyrics.html');
        $song_links = array();
        $str = "";
		
        foreach ($html->find('a') as $element) {
            if (strpos($element, '-lyrics-' . $artist) !== false) {
                $song_links[] = $element->href;
            }
        }
		
		$song_size = count($song_links);
		if ($song_size > $upperSongLimit) {
            $song_size = $upperSongLimit;
        } 
		
        $array_songs = array();
        for ($x = 0; $x < $song_size; $x++) {
            $htmlsong = file_get_html($song_links[$x]);
            foreach ($htmlsong->find('div[id=lyrics-body-text]') as $lyrics) {
                $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
                if (stripos($str, strtolower($word)) !== false || stripos($str, strtoupper($word)) !== false || stripos($str, $word) !== false) {
                    foreach ($htmlsong->find('title') as $title) {
                        $finaltitle = $this->get_string_between($title->plaintext, "-", "Lyrics");
                        $array_songs[] = $finaltitle;
                    }
                }
            }
        }
        return $array_songs;
    }
	
    function getLyricsBySong($_artist, $_song, $_word, $_site)
    {
        include_once('simple_html_dom.php');
        // Create DOM from URL or file
        $artist = $_artist;
        $artist = str_replace(" ", "-", $artist);
        $artist = strtolower($artist);
        $song = $_song;
        #$song = str_replace(" ", "-", $song);
        $song = strtolower($song);
        $html = file_get_html($_site . $artist . '-lyrics.html');
        $song_links = "";
        $str = "";
        $massivesonglyrics = "";
        foreach ($html->find('a') as $element) {
            if (strpos($element, '-lyrics-' . $artist) !== false) {
                if (stripos($element, strtolower($song)) !== false || stripos($element, strtoupper($song)) !== false || stripos($element, $song) !== false) {
                    $song_links = $element->href;
                    break;
                }
            }
        }
        $song_size = 1;
		if($song_links == "") {
			return "";
		}
        $htmlsong = file_get_html($song_links);
        foreach ($htmlsong->find('div[id=lyrics-body-text]') as $lyrics) {
            $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
            $massivesonglyrics = $massivesonglyrics . $str;
        }
        return $massivesonglyrics;
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