<h1>composer install</h1>
<h1>run "php artsian migrate:fresh"</h1>
<h1>Run "php artisan create-roles" to create roles</h1>
<h1>#To Create A admin account</h1>
<h1>Run "php artisan db:seed"</h1>

<h1>To Backup Data</h1>
<h2>php artisan backup modelName</h2>

#To create an admin account
#seeder are design for inserting data to database if the admin account is in database notice that data can be duplicate

If new cloned project 
--------------------
php artisan db:seed

If an existing account 
-----------------------
php artisan db:seed --class=AdminSeeder




