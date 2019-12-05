<?php

//timezone

date_default_timezone_set('America/Sao_Paulo');

//database connection

define('MYSQL_HOST',$_ENV['MYSQL_HOST']);
define('MYSQL_USER',$_ENV['MYSQL_USER']);
define('MYSQL_PASS',$_ENV['MYSQL_PASS']);
define('MYSQL_DBNAME',$_ENV['MYSQL_DBNAME']);