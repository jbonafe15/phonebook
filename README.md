## PART II: MYSQL

1. SELECT ProductName AS NAME, QuantityPerUnit AS QuantityUnit FROM products

2. SELECT CONCAT(ProductID,ProductName) AS 'Product List' FROM products

3. SELECT CONCAT(MAX(unitprice), ProductName) AS 'Product List' ,CONCAT(MIN(unitprice), ProductName) AS 'Product List' FROM products

4. SELECT ProductName AS 'Name', UnitPrice AS 'Unit Price' FROM products WHERE UnitPrice > (SELECT AVG(UnitPrice) FROM products)

5. SELECT ProductID AS id, ProductName AS 'name', UnitPrice AS 'unit price' FROM products WHERE UnitPrice < 20

6. SELECT ProductName AS 'name', UnitsOnOrder AS 'units on order', UnitsInStock AS 'units in stock' FROM products WHERE UnitsInStock < UnitsOnOrder