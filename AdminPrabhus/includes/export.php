<?php
ini_set('max_execution_time', 500);
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/Impexp.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
switch($action) {
    case "ExportPro":
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=ExportPro.csv');
    $output = fopen("php://output", "w");
    $Frmdate= date("Y-m-d", strtotime($_REQUEST['FrmDate']));
    $Todate= date("Y-m-d", strtotime($_REQUEST['ToDate']));
    $query = "SELECT products_id, products_quantity, products_model, products_image, products_price,products_curid,product_min_qty,products_rate, DATE_FORMAT(products_date_added,'%Y-%m-%d %h:%m:%s') AS products_date_added
    ,products_last_modified,products_weight,manufacturers_id,master_categories_id,products_name,products_author,products_edition FROM products WHERE products_date_added BETWEEN'".$Frmdate."' AND '".$Todate."' ORDER BY products_id ASC";
    $result = $db->select($query);
    while($row = mysqli_fetch_assoc($result))
    {
         fputcsv($output, $row);
    }

    fclose($output);
    break;

    case "ExportSbjt":
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=ExportSbjt.csv');
    $output = fopen("php://output", "w");
    $query = "SELECT categories_id,parent_id,categories_name FROM categories";
    $result = $db->select($query);
    while($row = mysqli_fetch_assoc($result))
    {
         fputcsv($output, $row);
    }

    fclose($output);
    break;

    case "ExportPub":
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=ExportPub.csv');
    $output = fopen("php://output", "w");
    $query = "SELECT manufacturers_id,manufacturers_name,DATE_FORMAT(date_added,'%Y-%m-%d %h:%m:%s') AS date_added, DATE_FORMAT(last_modified,'%Y-%m-%d %h:%m:%s') AS last_modified FROM manufacturers";
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
            //if data exists ignore
            if ($db->checkrow('products_id', 'products', 'products_id='.$getData[0])<>true)
            {
            //else
            //Insert
            $sql = "INSERT into products (products_id, products_quantity, products_model, products_image, products_price,products_curid,product_min_qty,products_rate,products_date_added
      ,products_last_modified,products_weight,manufacturers_id,master_categories_id,products_name,products_author,products_edition) values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."','".$getData[8]."','".date("Y-m-d h:m:s")."','".$getData[10]."','".$getData[11]."','".$getData[12]."','".$getData[13]."','".$getData[14]."','".$getData[15]."')";
            $result = $db->insertdb($sql);

            if(!isset($result))
            {
              $msg ="<script type=\"text/javascript\">
            alert(\"Invalid File:Please Upload CSV File.\");
            window.location = \"../Impexp.php\"
            </script>";
          }
          else {
            $msg= "<script type=\"text/javascript\">
        alert(\"CSV File has been successfully Imported.\");
        window.location = \"../Impexp.php\"
        </script>";
       }
          }
          }

          fclose($file);
          echo $msg;
    }
    break;
    ////
    case "ImportSbjt":
    $filename=$_FILES["fileSbjt"]["tmp_name"];

    if($_FILES["fileSbjt"]["size"] > 0)
    {
       $file = fopen($filename, "r");
         while (($getData = fgetcsv($file, 100000, ",")) !== FALSE)
          {
            //if data exists ignore
            if ($db->checkrow('categories_id', 'categories', 'categories_id='.$getData[0])<>true)
            {
            //else
            //Insert
            $sql = "INSERT into categories (categories_id, parent_id, categories_name) values ('".$getData[0]."','".$getData[1]."','".$getData[2]."')";
            $result = $db->insertdb($sql);

            if(!isset($result))
            {
              $msg ="<script type=\"text/javascript\">
            alert(\"Invalid File:Please Upload CSV File.\");
            window.location = \"../Impexp.php\"
            </script>";
          }
          else {
            $msg= "<script type=\"text/javascript\">
        alert(\"CSV File has been successfully Imported.\");
        window.location = \"../Impexp.php\"
        </script>";
       }
          }
          else {
            //Update
            $sql = "UPDATE `categories` SET `parent_id`='".$getData[1]."',`categories_name`='".$getData[2]."' WHERE  `categories_id`='".$getData[0]."';";
//echo $sql.'<br>';
            $result = $db->insertdb($sql);
            if(!isset($result))
            {
              $msg ="<script type=\"text/javascript\">
            alert(\"Invalid File:Please Upload CSV File.\");
            window.location = \"../Impexp.php\"
            </script>";
          }
          else {
            $msg= "<script type=\"text/javascript\">
        alert(\"CSV File has been successfully Imported.\");
        window.location = \"../Impexp.php\"
        </script>";
       }

          }
          }

          fclose($file);
          echo $msg;
    }
    break;
    ////
    ////
    case "ImportPub":
    $filename=$_FILES["filePub"]["tmp_name"];

    if($_FILES["filePub"]["size"] > 0)
    {
       $file = fopen($filename, "r");
         while (($getData = fgetcsv($file, 100000, ",")) !== FALSE)
          {
            //if data exists ignore
            if ($db->checkrow('manufacturers_id', 'manufacturers', 'manufacturers_id='.$getData[0])<>true)
            {
            //else
            //Insert
            $sql = "INSERT into manufacturers (manufacturers_id, manufacturers_name, date_added,last_modified) values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."')";
            $result = $db->insertdb($sql);

            if(!isset($result))
            {
              $msg ="<script type=\"text/javascript\">
            alert(\"Invalid File:Please Upload CSV File.\");
            window.location = \"../Impexp.php\"
            </script>";
          }
          else {
            $msg= "<script type=\"text/javascript\">
        alert(\"CSV File has been successfully Imported.\");
        window.location = \"../Impexp.php\"
        </script>";
       }
          }
          else {
            //Update
            $sql = "UPDATE `manufacturers` SET `manufacturers_name`='".$getData[1]."',`date_added`='".$getData[2]."',`last_modified`='".$getData[3]."' WHERE  `manufacturers_id`='".$getData[0]."';";
//echo $sql.'<br>';
            $result = $db->insertdb($sql);
            if(!isset($result))
            {
              $msg ="<script type=\"text/javascript\">
            alert(\"Invalid File:Please Upload CSV File.\");
            window.location = \"../Impexp.php\"
            </script>";
          }
          else {
            $msg= "<script type=\"text/javascript\">
        alert(\"CSV File has been successfully Imported.\");
        window.location = \"../Impexp.php\"
        </script>";
       }

          }
          }

          fclose($file);
          echo $msg;
    }
    break;
    ////
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
