<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title><?php if (isset($results['pageTitle'])) echo $results['pageTitle'];
else echo "Article Archive"; ?></title>

        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                text-align: left;
                padding: 8px;

            }

            tr:nth-child(even){background-color: #f2f2f2}

            th {
                background-color: #4CAF50;
                color: white;
                background: lightblue;
            }
        </style>
    </head>
    <body>
        <div id="container">
            header.php
            <hr/>
