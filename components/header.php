<?php
function headerComponentWithMenu($title){
    echo '
    <head>
        <title>'.$title.'</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
          href="https://fonts.googleapis.com/css2?family=Molle&family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet"
        />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
        body{
            font-family: "Poppins", sans-serif;
        }
        </style>
        <link href="/src/css/index.css" rel="stylesheet" />
        <script src="/src/js/index.js"></script>
    </head>
    <body>
        <header>
            <div class="container">
                <div class="logo">
                    <a href="index.php">Logo</a>
                </div>
                <div class="menu">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </header>
    ';
}
function headerComponent($title){
    echo '
    <head>
        <title>'.$title.'</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
          href="https://fonts.googleapis.com/css2?family=Molle&family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet"
        />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
        body{
            font-family: "Poppins", sans-serif;
        }
        </style>
        <link href="/src/css/index.css" rel="stylesheet" />
        <script src="/src/js/index.js"></script>
    </head>
    <body>
        
    ';
}
?>