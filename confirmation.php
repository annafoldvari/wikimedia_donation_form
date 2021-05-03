<?php
  include("inc/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Wikimedia Foundation Confirmation</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
  </head>
  <body>
    <main role="main">
      <?php
        $errors_output = formValidationErrors($_POST);

        //If there a form validation errors, outputs the errors and a button to go back to form prefilled with previously given details
        
        if ($errors_output) {
          echo $errors_output;
          echo buildHiddenForm($_POST, 'index.php', 'Edit Your Details');
        } else {
          
          //If there are no error messages and details are confirmed, saves details to database and redirects to a thank you page
          
          if ($_POST['confirmation-message']) {
            if (saveDetailsInDatabase($_POST)) {
              $host  = $_SERVER['HTTP_HOST'];
              header("Location: http://$host/thanks.php");
              exit();
            } else { 
              echo "<h2>There was a problem saving your details.</h2>";
              echo buildHiddenForm($_POST, 'index.php', 'Try Again');
            }
          } else {

          //If confirmation hasn't happened yet, builds the details section to review and cancel button  

            echo buildDetails($_POST, calculateYearlyDonation($_POST['preferred-payment'], $_POST['frequency'], $_POST['amount'])); 
            echo buildHiddenForm($_POST, 'index.php', 'Edit Your Details');
            echo buildHiddenForm($_POST, 'confirmation.php', 'Confirm');
            echo buildCancelFunction();
          }      
        }
      ?>
    </main>
  </body>
</html>  