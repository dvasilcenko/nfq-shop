Feature: Product Shop
  In order to see product attribute information
  As an user
  I need to be able to see correct information

  Scenario: List all enabled product attributes
    Given: I am on "/en_US/products/book-sylius"
    When I am on "/en_US/products/book-sylius"
    Then I should see "Barcode"