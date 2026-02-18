<?php
$cookie_name = "user";
  if (isset($_GET['action'])) {
    $action = $_GET['action'];
    // Handle cookie update
    // PUT YOUR CODE HERE
    if ($action == "update") {
        $cookie_value = $_GET['value'];
        setcookie($cookie_name, $cookie_value, time() + (300), "/");
    }


    // Handle cookie removal
    // PUT YOUR CODE HERE
    if ($action == "remove") {
        setcookie($cookie_name, "", time() - 60, "/");
    }
    
    // Reload Page
    header("Location: cookie.php");
    exit();
  }
?>

<html>
  <head>
    <link rel="stylesheet" href="custom_style.css">
  </head>
  <body>
  <div id="cookie_div">
  <?php
    $cookie_name = "user";
    if(!isset($_COOKIE[$cookie_name])) {
      echo "Cookie is not set for this site!";
    } else {
      echo "Cookie '" . $cookie_name . "' is set!<br>";
      echo "Value is: " . $_COOKIE[$cookie_name];
    }
    include "cookie_input.html";
  ?>
  </div>
  </body>
</html>
