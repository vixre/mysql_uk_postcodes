import_postcodes
================

PHP code for taking the csv found at http://www.freemaptools.com/download-uk-postcode-lat-lng.htm and importing it into a mysql database. You can use the script in two ways:

1. Fill in the database details at the start of the file and run the queries as they are built.

    php import.php postcodes.csv

2. Specify 'echo' as the 2nd argument and output the sql to a file.

    php import.php postcodes.csv echo > mysql_postcodes.sql

