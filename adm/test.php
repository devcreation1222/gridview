<?php
header('Access-Control-Allow-Origin: *');

include('db.php');
$str = "80's";
echo urlencode($str); // Will only convert double quotes
echo "<br>";
echo htmlspecialchars($str, ENT_QUOTES); // Converts double and single quotes
echo "<br>";
echo htmlspecialchars($str, ENT_NOQUOTES); // Does not convert any quotes


// require('excel/php-excel-reader/excel_reader2.php');
// require('excel/SpreadsheetReader.php');

// $Reader = new SpreadsheetReader("products.xls");
// $Sheets = $Reader->Sheets();
// foreach ($Sheets as $Index => $Name)
// {
//     $Reader -> ChangeSheet($Index);
//     foreach ($Reader as $Row)
//     {
//         print_r($Row);
//         echo "<br><br>";
//     }
// }

?>