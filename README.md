--- Inventory POS ---

**** Configuration **** 
   * Update database credentials in config/database.php
      - You can change also the default password, Used for ressetting user password.
   * Update your folder name in system_name.js

pos_fresh.sql
   * Fresh database dump of the system
   * Remain 1 user for login purpose. 
       - username : owner
       - password : owner
   * If you want to create another owner role. 
      Just register it in the system then, directly
      change the role in database




**** Boolean notes of column in each table ****

Users table
 * role
    1 = owner
    2 = admin
    3 = user
 * status
    1 = active
    2 = inactive

Invoices table
 * discount
    1 = Yes
    0 = No

Product_details table
 * expired_status
    1 = Yes
    0 = No

Products table
 * status
    1 = Active
    0 = Inactive
 * Type
    1 = Branded
    0 = Generic
    null = <No Type>

Sales table
  * void
    1 = Void
    0 = Not Void

10/28/2024

- Reopened the system

11/01/2024

- Reopened the system using MySQL workbench outside xampp
- Renamed empty tables initials
- Updated all complex Controllers statements from if else to switch

11/04/2024
- Updated ActionLogs statement with specific actions involved (e.g. Name of Category or Product)

11/07/2024
- Added a notification when a product is updated.
- Properly name the tables accordingly to pages.

Restructure the Register and Adding of Stocks of the Products to avoid complication of Notification.

12/12/2024

- Fixed the location problem in adding stocks page.
- Included notification functions for each save and update of products in ProductController.php
- Updated registering a user's ActionLog description on Logs.
- Updated login and logout ActionLog, including the username of the current user on Logs.
- Updated void ActionLog, including the username of the current user and invoice number of the voided invoice on Logs.
- Changed the timezone in POS page in Asia/Singapore.
- Improved the refreshing of Expiration Status, when an expired table is clicked, a submit button is shown before sending it to the designated products.

01/08/2025

- Transforming the process of designation from refreshing the page to a submit button.

