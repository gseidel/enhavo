Feature: Cart
  In order to use the cart
  As a user
  I want to put, delete, see products in my cart

  Background:
    Given following products
      | title   | price  | code   |
      | Bottle  | 1400   | bottle |
      | Can     | 300    | can    |

  Scenario: Add product
    Given I add "1" product with code "bottle" to cart
    Then I see "1" product with code "bottle" in my cart