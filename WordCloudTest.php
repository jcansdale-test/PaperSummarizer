<?php
include 'WordCloud.php';

class WordCloudTest extends PHPUnit_Framework_TestCase {
	public function testGetPapersByKeywordReturnsValidArticleNumbersIfValidXML() {
		$provider = new WordCloud;
		$papers = $provider->getPapersByKeyword("", 0, "test/testXML.xml");
		$this->assertEquals((int)$papers[0], 4359474);
		$this->assertEquals((int)$papers[1], 4815368);
	}
	
	public function testGetPapersByKeywordReturnsEmptyIfInvvalidXML() {
		$provider = new WordCloud;
		$papers = $provider->getPapersByKeyword("", 0, "test/badXML.xml");
		$this->assertEquals($papers, array());
	}
	
	public function testGetWordsByPapersReturnsTextIfValidArticles() {
		$provider = new WordCloud;
		$papersID = array(
			0 => 0);
		$text = $provider->getWordsByPapers($papersID, "test/testArticle");
		$this->assertEquals($text, "dummy data from testArticle0  ");
	}
	
	public function testGetWordsByPapersReturnsTextIfMultipleValidArticles() {
		$provider = new WordCloud;
		$papersID = array(
			0 => 0,
			1 => 1 );
		$text = $provider->getWordsByPapers($papersID, "test/testArticle");
		$this->assertEquals($text, "dummy data from testArticle0  dummy data from testArticle1  ");
	}
	
	public function testWordsByPapersReturnsEmptyIfInvalidHTML() {
		$provider = new WordCloud;
		$papersID = array(
			0 => 3);
		$text = $provider->getWordsByPapers($papersID, "test/testArticle");
		$this->assertEquals($text, "");
	}
	
}
?>
 