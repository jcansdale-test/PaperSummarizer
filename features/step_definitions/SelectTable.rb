Given /^user is on LyriCloud and created word cloud of "([^"]*)"$/ do
  visit 'http://127.0.0.1/index.html'
  fill_in(inputBox, :with => books)
  click_button('submitButton')
end

When /^user selects "([^"]*)" from Word Cloud$/ do
click_link_or_button('books')
end

Then /^Table is populated$/ do
  page.should have_content('title')
end
