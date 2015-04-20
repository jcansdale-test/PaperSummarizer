Feature: Get word cloud for word
	In order to get a word cloud for a certain word
	As a user
	I want a button that will generate a word cloud

Scenario: Given the PaperFloat page is loaded
	And I have entered a valid word, books, in the input box
	When I press the 'Submit' button
	Then I should get a word cloud displaying the word, books
	And other words from articles containing books
