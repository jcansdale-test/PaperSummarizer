<?php
include 'WordCloud.php';

class WordCloudTest extends PHPUnit_Framework_TestCase {
	public function testGetPapersIDByKeywordReturnsValidArticleNumbersIfValidXML() {
		$provider = new WordCloud;
		$papers = $provider->getPapersIDByKeyword("", 0, "test/testXML.xml");
		$this->assertEquals((int)$papers[0], 4359474);
		$this->assertEquals((int)$papers[1], 4815368);
	}

	public function testGetPapersIDByKeywordReturnsEmptyIfInvvalidXML() {
		$provider = new WordCloud;
		$papers = $provider->getPapersIDByKeyword("", 0, "test/badXML.xml");
		$this->assertEquals($papers, array());
	}
	
	public function testGetWordsByPapersReturnsTextIfValidArticles() {
		$provider = new WordCloud;
		$papersID = array(
			0 => 0);
		$text = $provider->getWordsByPapers($papersID, "test/article");
		$this->assertEquals($text, "dummy data from article0 ");
	}
	
	public function testGetWordsByPapersReturnsTextIfMultipleValidArticles() {
		$provider = new WordCloud;
		$papersID = array(
			0 => 0,
			1 => 1 );
		$text = $provider->getWordsByPapers($papersID, "test/article");
		$this->assertEquals($text, "dummy data from article0 dummy data from article1 ");
	}
	
	public function testGetWordsByPapersReturnsEmptyIfInvalidXML() {
		$provider = new WordCloud;
		$papersID = array(
			0 => 3);
		$text = $provider->getWordsByPapers($papersID, "test/article");
		$this->assertEquals($text, "");
	}
}
?>
 