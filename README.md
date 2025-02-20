# UTMBackendAPI2024

**How to use this source code**

1. Install XAMPP, and start the Apache and mySQL 
2. Download this source code as zip
3. Extract the zip file in c:\xampp\htdocs
4. Rename the root folder as 'api'
5. At browser, go to http://localhost:80/phpmyadmin where 8888 belongs to the port (might be vary from your PC)
6. At the middle of the screen, go to SQL tab, type the SQL queries below:

```CREATE DATABASE file_upload_db;```

Then click button GO at the bottom

7. At the left menu bar, find the database called "file_upload_db" and click to the db
9. Go back to SQL tab, type the SQL queries below:

```
CREATE TABLE files (
 id INT NOT NULL AUTO_INCREMENT,
 filename VARCHAR(200) NOT NULL,
 type VARCHAR(30) NOT NULL,
 size INT NOT NULL DEFAULT 0,
 path VARCHAR(200) NOT NULL,
 PRIMARY KEY (id)
);
```
**To Do**
8. Download and install Postman, make sure you sign up and log in.
9. Open Postman, click on import, then choose ```Warehouse API.postman_collection.json``` in \warehouse folder
10. Run and test API!
