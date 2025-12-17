# Gooday Cafe Website

To set up with XAMPP:
1. Copy this folder into `xampp/htdocs/GoodayCafeWebsite`.
2. Start Apache (PHP runs via Apache) and ensure your SQL Server/SQLExpress service is running.
3. Execute the root-level `CREATE TABLES FOR CAFE.sql` in SQL Server Management Studio or via `sqlcmd` to create the `Good_Day_Cafe` database and tables.

_Sections 5 and 6 follow the numbering used in the project brief._

## 5. Database Design
- **USERS**: stores customer and staff profiles (`FIRSTNAME`, `LASTNAME`, `DATEOFBIRTH`, `EMAIL`, `PASS`, `STATUS`). `USER_ID` is the primary key used by sessions and orders.
- **PRODUCTS**: menu items with `PRODUCT_NAME`, `PRODUCT_CATEGORY`, `PRICE`, and `DESCRIPTION`. `PRODUCT_ID` is the primary key.
- **PRODUCT_IMAGE**: image metadata (`IMAGE_NAME`, `FILEPATH`) linked to `PRODUCT_ID` for each product.
- **ORDER**: top-level order records (`USER_ID`, `TOTAL_PRICE`, `ORDER_PLACED`, `PAYMENT`, `DISCOUNT`) with `ORDER_ID` as the primary key.
- **ORDER_ITEM**: line items for each order, referencing `ORDER_ID` and `PRODUCT_ID`, with quantity and price per item.
- Schema is defined in `CREATE TABLES FOR CAFE.sql`; import it into your SQL Server instance before running the site.

## 6. Code Details

### 6.1 Folder Structure Explanation (XAMPP `htdocs/GoodayCafeWebsite`)
- `/admin/`: staff dashboard for managing products.  
  - `adminpage.php`: main admin panel.  
  - `add_product.php`, `delete_product.php`: endpoints to add/remove menu items.  
  - `admin.js`: admin UI interactions.  
  - `adminpage.css`: styling for the admin pages.
- `/assets/`: static front-end dependencies.  
  - `bootstrap/`, `css/`, `fonts/`, `img/`, `js/`: vendor CSS/JS and shared styles, fonts, and images.
- `/uploads/`: product images saved from the admin panel.
- Root files:  
  - `loginandregis.html`: landing page for login/registration forms.  
  - `login.php`: authenticates users against `USERS` and routes staff to `/admin/adminpage.php` and customers to `menupage.php`.  
  - `regis.php`: registers new users.  
  - `menupage.php`: customer-facing menu and ordering UI.  
  - `order.php`: handles order submissions.  
  - `test.html`: static test/demo page.  
  - `CREATE TABLES FOR CAFE.sql`: database schema script.

### 6.2 GitHub Repository
Public repository: https://github.com/Skelet0r-dev/GoodayCafeWebsite
