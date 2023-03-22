@mod @mod_data
Feature: Users can be required to specify certain fields when adding entries to database activities
  In order to constrain user input
  As a teacher
  I need to specify certain fields as required when I add entries to databases

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email |
      | student1 | Student | 1 | student1@example.com |
      | teacher1 | Teacher | 1 | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1 | 0 |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher1 | C1 | editingteacher |
      | student1 | C1 | student |
    And the following "activities" exist:
      | activity | name               | intro | course | idnumber |
      | data     | Test database name | n     | C1     | data1    |
<<<<<<< HEAD
    And I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I add a "Short text" field to "Test database name" database and I fill the form with:
      | Field name | Base Text input |
      | Required | yes |
      | Field description | Base Text input |
    And I add a "Checkbox" field to "Test database name" database and I fill the form with:
      | Field name | Required Checkbox |
      | Field description | Required Checkbox |
      | Required | yes |
      | Options | Required Checkbox Option 1 |
    And I follow "Fields"
    And I select "Checkbox" from the "newtype" singleselect
    And I set the following fields to these values:
      | Field name | Required Two-Option Checkbox |
      | Field description | Required Two-Option Checkbox |
      | Required | yes |
    And I set the field "Options" to multiline:
    """
    RTOC Option 1
    RTOC Option 2
    """
    And I press "Add"
    And I add a "Coordinates" field to "Test database name" database and I fill the form with:
      | Field name | Required Coordinates |
      | Field description | Required Coordinates |
      | Required | yes |
    And I add a "Dropdown list" field to "Test database name" database and I fill the form with:
      | Field name | Required Menu |
      | Field description | Required Menu |
      | Required | yes |
      | Options | Option 1 |
    And I add a "Number" field to "Test database name" database and I fill the form with:
      | Field name | Required Number |
      | Field description | Required Number |
      | Required | yes |
    And I add a "Radio button" field to "Test database name" database and I fill the form with:
      | Field name | Required Radio |
      | Field description | Required Radio |
      | Required | yes |
      | Options | Required Radio Option 1 |
    And I add a "Short text" field to "Test database name" database and I fill the form with:
      | Field name | Required Text input |
      | Field description | Required Text input |
      | Required | yes |
    And I add a "Text area" field to "Test database name" database and I fill the form with:
      | Field name | Required Text area |
      | Field description | Required Text area |
      | Required | yes |
    And I add a "URL" field to "Test database name" database and I fill the form with:
      | Field name | Required URL |
      | Field description | Required URL |
      | Required | yes |
    And I add a "Multi-select list" field to "Test database name" database and I fill the form with:
      | Field name | Required Multimenu |
      | Field description | Required Multimenu |
      | Required | yes |
      | Options | Option 1 |
    And I follow "Fields"
    And I select "Multi-select list" from the "newtype" singleselect
    And I set the following fields to these values:
      | Field name | Required Two-Option Multimenu |
      | Field description | Required Two-Option Multimenu |
      | Required | yes |
    And I set the field "Options" to multiline:
    """
    Option 1
    Option 2
    """
    And I press "Add"
    And I add a "Checkbox" field to "Test database name" database and I fill the form with:
      | Field name | Not required Checkbox |
      | Field description | Not required Checkbox |
      | Options | Not required Checkbox Option 1 |
    And I add a "Coordinates" field to "Test database name" database and I fill the form with:
      | Field name | Not required Coordinates |
      | Field description | Not required Coordinates |
    And I add a "Dropdown list" field to "Test database name" database and I fill the form with:
      | Field name | Not required Menu |
      | Field description | Not required Menu |
      | Options | Option 1 |
    And I add a "Number" field to "Test database name" database and I fill the form with:
      | Field name | Not required Number |
      | Field description | Not required Number |
    And I add a "Radio button" field to "Test database name" database and I fill the form with:
      | Field name | Not required Radio |
      | Field description | Not required Radio |
      | Options | Not required Radio Option 1 |
    And I add a "Short text" field to "Test database name" database and I fill the form with:
      | Field name | Not required Text input |
      | Field description | Not required Text input |
    And I add a "Text area" field to "Test database name" database and I fill the form with:
      | Field name | Not required Text area |
      | Field description | Not required Text area |
    And I add a "URL" field to "Test database name" database and I fill the form with:
      | Field name | Not required URL |
      | Field description | Not required URL |
    And I add a "Multi-select list" field to "Test database name" database and I fill the form with:
      | Field name | Not required Multimenu |
      | Field description | Not required Multimenu |
      | Options | Option 1 |
    And I navigate to "Templates" in current page administration
    And I log out
=======
    And the following "mod_data > fields" exist:
      | database | type        | name                          | required | description                   | param1                         |
      | data1    | text        | Base Text input               | 1        | Base Text input               |                                |
      | data1    | checkbox    | Required Checkbox             | 1        | Base Text input               | Required Checkbox Option 1     |
      | data1    | checkbox    | Required Two-Option Checkbox  | 1        | Required Two-Option Checkbox  | RTOC Option 1\nRTOC Option 2   |
      | data1    | latlong     | Required Coordinates          | 1        | Required Coordinates          |                                |
      | data1    | menu        | Required Menu                 | 1        | Required Menu                 | Option 1                       |
      | data1    | number      | Required Number               | 1        | Required Number               |                                |
      | data1    | radiobutton | Required Radio                | 1        | Required Radio                | Required Radio Option 1        |
      | data1    | text        | Required Text input           | 1        | Required Text input           |                                |
      | data1    | textarea    | Required Text area            | 1        | Required Text area            |                                |
      | data1    | url         | Required URL                  | 1        | Required URL                  |                                |
      | data1    | multimenu   | Required Multimenu            | 1        | Required Multimenu            | Option 1                       |
      | data1    | multimenu   | Required Two-Option Multimenu | 1        | Required Two-Option Multimenu | Option 1\nOption 2             |
      | data1    | checkbox    | Not required Checkbox         | 0        | Not required Checkbox         | Not required Checkbox Option 1 |
      | data1    | latlong     | Not required Coordinates      | 0        | Not required Coordinates      |                                |
      | data1    | menu        | Not required Menu             | 0        | Not required Menu             | Option 1                       |
      | data1    | number      | Not required Number           | 0        | Not required Number           |                                |
      | data1    | radiobutton | Not required Radio            | 0        | Not required Radio            | Not required Radio Option 1    |
      | data1    | text        | Not required Text input       | 0        | Not required Text input       |                                |
      | data1    | textarea    | Not required Text area        | 0        | Not required Text area        |                                |
      | data1    | url         | Not required URL              | 0        | Not required URL              |                                |
      | data1    | multimenu   | Not required Multimenu        | 0        | Not required Multimenu        | Option 1                       |
>>>>>>> master

  Scenario: Students receive errors for empty required fields but not for optional fields
    When I log in as "student1"
    And I am on "Course 1" course homepage
    And I add an entry to "Test database name" database with:
       | Base Text input | Some input to allow us to submit the otherwise empty form |
    And I press "Save"
<<<<<<< HEAD
    Then ".alert" "css_element" should exist in the "Required Checkbox" "table_row"
    And ".alert" "css_element" should exist in the "Required Two-Option Checkbox" "table_row"
    And ".alert" "css_element" should exist in the "Required Coordinates" "table_row"
    And ".alert" "css_element" should exist in the "Required Menu" "table_row"
    And ".alert" "css_element" should exist in the "Required Number" "table_row"
    And ".alert" "css_element" should exist in the "Required Radio" "table_row"
    And ".alert" "css_element" should exist in the "Required Text input" "table_row"
    And ".alert" "css_element" should exist in the "Required Text area" "table_row"
    And ".alert" "css_element" should exist in the "Required URL" "table_row"
    And ".alert" "css_element" should exist in the "Required Multimenu" "table_row"
    And ".alert" "css_element" should exist in the "Required Two-Option Multimenu" "table_row"
    And ".alert" "css_element" should not exist in the "Not required Checkbox" "table_row"
    And ".alert" "css_element" should not exist in the "Not required Coordinates" "table_row"
    And ".alert" "css_element" should not exist in the "Not required Menu" "table_row"
    And ".alert" "css_element" should not exist in the "Not required Number" "table_row"
    And ".alert" "css_element" should not exist in the "Not required Radio" "table_row"
    And ".alert" "css_element" should not exist in the "Not required Text input" "table_row"
    And ".alert" "css_element" should not exist in the "Not required Text area" "table_row"
    And ".alert" "css_element" should not exist in the "Not required URL" "table_row"
    And ".alert" "css_element" should not exist in the "Not required Multimenu" "table_row"
=======
#    Then ".alert" "css_element" should exist in the "//div[contains(@id,'defaulttemplate-addentry']//div[position()=1]]" "xpath_element"
    Then ".alert" "css_element" should appear after "Checkbox" "text"
    And ".alert" "css_element" should appear before "Required Checkbox" "text"
    And ".alert" "css_element" should appear after "Two-Option Checkbox" "text"
    And ".alert" "css_element" should appear before "Required Two-Option Checkbox" "text"
    And ".alert" "css_element" should appear after "Coordinates" "text"
    And ".alert" "css_element" should appear before "Required Coordinates" "text"
    And ".alert" "css_element" should appear after "Menu" "text"
    And ".alert" "css_element" should appear before "Required Menu" "text"
    And ".alert" "css_element" should appear after "Radio" "text"
    And ".alert" "css_element" should appear before "Required Radio" "text"
    And ".alert" "css_element" should appear after "Text input" "text"
    And ".alert" "css_element" should appear before "Required Text input" "text"
    And ".alert" "css_element" should appear after "Text area" "text"
    And ".alert" "css_element" should appear before "Required Text area" "text"
    And ".alert" "css_element" should appear after "URL" "text"
    And ".alert" "css_element" should appear before "Required URL" "text"
    And ".alert" "css_element" should appear after "Multimenu" "text"
    And ".alert" "css_element" should appear before "Required Multimenu" "text"
    And ".alert" "css_element" should appear after "Two-Option Multimenu" "text"
    And ".alert" "css_element" should appear before "Required Two-Option Multimenu" "text"
>>>>>>> master
    And I am on "Course 1" course homepage
    And I follow "Test database name"
    And I should see "No entries yet"

  Scenario: Students recieve no error for filled in required fields
    When I log in as "student1"
    And I am on "Course 1" course homepage
    And I add an entry to "Test database name" database with:
       | Base Text input               | Some input to allow us to submit the otherwise empty form |
       | Required Checkbox Option 1    | 1                                                         |
       | RTOC Option 1                 | 1                                                         |
       | Latitude                      | 0                                                         |
       | Longitude                     | 0                                                         |
       | Required Menu                 | 1                                                         |
       | Required Number               | 1                                                         |
       | Required Radio Option 1       | 1                                                         |
       | Required Text input           | New entry text                                            |
       | Required Text area            | More text                                                 |
       | Required URL                  | http://example.com/                                       |
       | Required Multimenu            | 1                                                         |
       | Required Two-Option Multimenu | 1                                                         |
    And I press "Save"
    And I select "List view" from the "jump" singleselect
    Then I should not see "No entries in database"
    And I should see "New entry text"

  Scenario: Fields refill with data after having an error
    When I log in as "student1"
    And I am on "Course 1" course homepage
    And I add an entry to "Test database name" database with:
       | RTOC Option 1                 | 1                   |
       | Latitude                      | 0                   |
       | Longitude                     | 0                   |
       | Required Menu                 | 1                   |
       | Required Number               | 1                   |
       | Required Radio Option 1       | 1                   |
       | Required Text input           | New entry text      |
       | Required Text area            | More text           |
       | Required URL                  | http://example.com/ |
       | Required Multimenu            | 1                   |
       | Required Two-Option Multimenu | 1                   |
    And I press "Save"
    Then the following fields match these values:
       | Base Text input               |                     |
       | Latitude                      | 0                   |
       | Longitude                     | 0                   |
       | Required Menu                 | Option 1            |
       | Required Number               | 1                   |
       | Required Radio Option 1       | 1                   |
       | Required Text input           | New entry text      |
       | Required Text area            | More text           |
       | Required URL                  | http://example.com/ |
       | Required Multimenu            | Option 1            |
       | Required Two-Option Multimenu | Option 1            |

  @javascript
  Scenario: A student fills in Latitude but not Longitude will see an error
    Given I log in as "student1"
    And I am on "Course 1" course homepage
    When I add an entry to "Test database name" database with:
       | Base Text input               | Some input to allow us to submit the otherwise empty form |
       | Required Checkbox Option 1    | 1                                                         |
       | RTOC Option 1                 | 1                                                         |
       | Latitude                      | 24                                                        |
       | Required Menu                 | 1                                                         |
       | Required Number               | 1                                                         |
       | Required Radio Option 1       | 1                                                         |
       | Required Text input           | New entry text                                            |
       | Required Text area            | More text                                                 |
       | Required URL                  | http://example.com/                                       |
       | Required Multimenu            | 1                                                         |
       | Required Two-Option Multimenu | 1                                                         |
<<<<<<< HEAD
    And I set the field with xpath "//div[@title='Not required Coordinates']//tr[td/label[normalize-space(.)='Latitude']]/td/input" to "20"
    And I press "Save"
    Then ".alert" "css_element" should exist in the "Required Coordinates" "table_row"
    And ".alert" "css_element" should exist in the "Not required Coordinates" "table_row"
=======
    And I set the field "Latitude" to "20"
    #And I set the field with xpath "//div[@title='Not required Coordinates']//tr[td/label[normalize-space(.)='Latitude']]/td/input" to "20"
    And I press "Save"
    Then I should see "Both latitude and longitude are required."
>>>>>>> master

  Scenario: A student filling in number and text fields with zero will not see an error.
    Given I log in as "student1"
    And I am on "Course 1" course homepage
    When I add an entry to "Test database name" database with:
       | Base Text input               | Some input to allow us to submit the otherwise empty form |
       | Required Checkbox Option 1    | 1                                                         |
       | RTOC Option 1                 | 1                                                         |
       | Latitude                      | 0                                                         |
       | Longitude                     | 0                                                         |
       | Required Menu                 | 1                                                         |
       | Required Number               | 0                                                         |
       | Required Radio Option 1       | 1                                                         |
       | Required Text input           | 0                                                         |
       | Required Text area            | 0                                                         |
       | Required URL                  | http://example.com/                                       |
       | Required Multimenu            | 1                                                         |
       | Required Two-Option Multimenu | 1                                                         |
    And I press "Save"
    And I select "List view" from the "jump" singleselect
    Then I should not see "No entries in database"
    And I should see "Some input to allow us to submit the otherwise empty form"
