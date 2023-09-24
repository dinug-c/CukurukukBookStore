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
        <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
    crossorigin="anonymous"
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

function headerComponentBootstrap($title){
    echo '
    <head>
        <title>'.$title.'</title>
       
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
          href="https://fonts.googleapis.com/css2?family=Molle&family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet"
        />
        <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
    crossorigin="anonymous"
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


function adminNav(){
    echo '<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #EEECF8;">
    <a class="navbar-brand" href="#">Admin</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="dashboard.php">Dashboard <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_book.php">Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_by_category.php">Buku Kategori</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_order.php">Order</a>
        </li>
      </ul>
      
    </div>
  </nav>';
}
?>

