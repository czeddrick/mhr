
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Microfinance</title>
</head>
<body>
  



<?php 
require_once("../include/initialize.php");
 if(!isset($_SESSION['ADMIN_USERID'])){
    redirect(web_root."admin/login.php");
  }

$content='home.php';
$view = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';
switch ($view) {
  case '1' :
        // $title="Home"; 
    // $content='home.php'; 
    if ($_SESSION['ADMIN_ROLE']=='Cashier') {
        # code...
      redirect('orders/');

    } 
    if ($_SESSION['ADMIN_ROLE']=='Administrator') {
        # code... 

      redirect('meals/');

    } 
    break;  
  default :
 
      $title="Home"; 
    $content ='home.php';    
}
require_once("theme/templates.php");
?>

</body>
</html>