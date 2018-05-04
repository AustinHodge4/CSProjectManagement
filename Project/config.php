<?php

/* Database credentials. Assuming you are running MySQL

server with default setting (user 'root' with no password) */

define('DB_SERVER', 'fdb18.awardspace.net');

define('DB_USERNAME', '2674615_cst6306');

define('DB_PASSWORD', 'q#I7c7GfyE');

define('DB_NAME', '2674615_cst6306');


/* Attempt to connect to MySQL database */

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

 

// Check connection