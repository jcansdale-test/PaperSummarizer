Feature: Get table for selected Word
	In order to get the table of articles for the word
	As a user I will click the word in the word cloud
	I want to get a table of articles with the word, ordered from highest frequency

Scenario: Given the PaperFloat page is loaded
	And I have entered a valid word, books, in the input box
	And The word cloud is displayed
	When I click one of the words in the word cloud, books
	Then I should get a table containing articles containing the word books
	And the articles should be ordered in highest frequency
