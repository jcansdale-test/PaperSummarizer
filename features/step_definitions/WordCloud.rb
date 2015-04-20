Given /^I am on PaperFloat home page$/ do
  visit 'http://127.0.0.1/index.html'
end

Given /^I have entered a valid word, books, in the input box $/ do 
  fill_in(inputBox, :with => books)
  
end

When /^I click the submit button$/ do
  click_button('submitButton')
end

Then /^WordCloud should be displayed$/ do
  page.should have_content('cloudResult')
end
