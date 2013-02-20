<?php
    require('constants.php');

    function getDb()
    {
        $db = mysql_connect(
            MYSQL_HOSTNAME,
            MYSQL_USERNAME,
            MYSQL_PASSWORD
        );

        mysql_select_db(MYSQL_SCHEMA);

        return $db;
    }
?>