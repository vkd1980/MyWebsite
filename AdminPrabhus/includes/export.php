<?php
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/Impexp.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
switch($action) {
    case "ExportPro":
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=ExportPro.csv');
    $output = fopen("php://output", "w");
    $date= date("Y-m-d", strtotime($_REQUEST['Date']));
    $query = "SELECT products_id, products_quantity, products_model, products_image, products_price,products_curid,product_min_qty,products_rate, DATE_FORMAT(products_date_added,'%Y-%m-%d %h:%m:%s') AS products_date_added
    ,products_last_modified,products_weight,manufacturers_id,master_categories_id,products_name,products_author,products_edition FROM products WHERE products_date_added >'".$date."' ORDER BY products_id ASC";
    $result = $db->select($query);
    while($row = mysqli_fetch_assoc($result))
    {
         fputcsv($output, $row);
    }
    fclose($output);
    break;
    case "ExportStk":
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=ExportStk.csv');
    $output = fopen("php://output", "w");
    //fputcsv($output, array('products_id', 'products_quantity'));
    $date= date("Y-m-d", strtotime($_REQUEST['StockDate']));
    $query = "SELECT products_id, products_quantity  FROM products WHERE products_date_added <'".$date."' ORDER BY products_id ASC";
    $result = $db->select($query);
      while($row = mysqli_fetch_assoc($result))
        {
          fputcsv($output, $row);
        }
        fclose($output);
    break;
    case "ImportPro":
    $filename=$_FILES["file"]["tmp_name"];

    if($_FILES["file"]["size"] > 0)
    {
       $file = fopen($filename, "r");
         while (($getData = fgetcsv($file, 100000, ",")) !== FALSE)
          {
            $sql = "INSERT into products (products_id, products_quantity, products_model, products_image, products_price,products_curid,product_min_qty,products_rate,products_date_added
      ,products_last_modified,products_weight,manufacturers_id,master_categories_id,products_name,products_author,products_edition) values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".date("Y-m-d h:m:s")."','".$getData[10]."','".$getData[11]."','".$getData[12]."','".$getData[13]."','".$getData[14]."','".$getData[15]."')";
            $result = $db->insertdb($sql);

            if(!isset($result))
            {
              echo "<script type=\"text/javascript\">
            alert(\"Invalid File:Please Upload CSV File.\");
            window.location = \"../Impexp.php\"
            </script>";
          }
          else {
            echo "<script type=\"text/javascript\">
        alert(\"CSV File has been successfully Imported.\");
        window.location = \"../Impexp.php\"
        </script>";
       }
          }

          fclose($file);
    }
    break;
      case "ImportStk":
      $filename=$_FILES["fileStk"]["tmp_name"];

      if($_FILES["fileStk"]["size"] > 0)
      {
         $file = fopen($filename, "r");
           while (($getData = fgetcsv($file, 100000, ",")) !== FALSE)
            {
              $sql = "UPDATE `products` SET `products_quantity`='".$getData[1]."' WHERE  `products_id`='".$getData[0]."';";
//echo $sql.'<br>';
              $result = $db->insertdb($sql);

              if(!isset($result))
              {
                echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"../Impexp.php\"
              </script>";
            }
            else {
              echo "<script type=\"text/javascript\">
          alert(\"CSV File has been successfully Imported.\");
          window.location = \"../Impexp.php\"
          </script>";
        }
            }

            fclose($file);
      }
    break;
  }
}
  else{
  $response= array("ERROR","Invalid Access");
  echo json_encode($response);
}
?>
