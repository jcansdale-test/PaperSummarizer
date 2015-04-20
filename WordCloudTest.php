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
	
	public function testGetPapersNameByKeywordReturnsTitlesIfValidXML() {
		$provider = new WordCloud;
		$papers = $provider->getPapersNameByKeyword("", 0, "test/testXML.xml");
		$this->assertEquals((string)$papers[0], "TestTitle1");
		$this->assertEquals((string)$papers[1], "TestTitle2");
	}
	
	public function testGetPapersNameByKeywordRenturnsEmptyIfInvalidXML() {
		$provider = new WordCloud;
		$papers = $provider->getPapersIDByKeyword("", 0, "test/badXML.xml");
		$this->assertEquals($papers, array());
	}
	
	public function testGetArticlesByWordReturnsArticlesIfValidKeyword() {
		$provider = new WordCloud;
		$papersID = array(
			0 => 0,
			1 => 1 );
		$papers = $provider->getArticlesByWord("dummy", $papersID , "", "", null, null, "test/article");
		$this->assertEquals(trim((string)$papers[0]), "TestTitle1");
		$this->assertEquals(trim((string)$papers[1]), "TestTitle2");
	}
	
	public function testGetArticlesByWordReturnsArticlesIfInvalidKeyword() {
		$provider = new WordCloud;
		$papersID = array(
			0 => 0,
			1 => 1 );
		$papers = $provider->getArticlesByWord("---", $papersID , "", "", null, null, "test/article");
		$this->assertEquals($papers, array());
	}

	
}
?>
 