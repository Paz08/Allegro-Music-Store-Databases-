<!DOCTYPE>
<html>
<head>

<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">


<title>Manager</title>

<link href="style.css" rel="stylesheet" type="text/css">

<script>
function formSubmit(upc) {
    'use strict';
    if (confirm('Are you sure you want to delete this item?')) {
        // Set the value of a hidden HTML element in this form
        var form = document.getElementById('delete');
        form.upc.value = upc;
        // Post this form
        form.submit();
    }
}

function formSubmitPurchaseOrder(receiptId) {
    'use strict';
    if (confirm('Are you sure you want to delete this purchase order?')) {
        // Set the value of a hidden HTML element in this form
        var form = document.getElementById('deletePurchaseOrder');
        form.receiptId.value = receiptId;
        // Post this form
        form.submit();
    }
}

</script>

</head>

<body>

<br>

<h0>&checkmark; &Mopf;&aopf;&nopf;&aopf;&gopf;&eopf;&ropf; &checkmark;</h0>

<br>
<br>

<a href= "home.php">Home</a>
<a href= "reports.php">Reports</a>

<?php
    
    $user = 'root';
    $pass = '';
    $db = 'AMS';
    
    $db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
    
    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_POST["submitDeleteItem"]) && $_POST["submitDeleteItem"] == "DELETE") {
            
            // Delete the selected book title using the upc
            // Create a delete query prepared statement with a ? for the title_id
            $stmt = $db->prepare("DELETE FROM Item WHERE upc=?");
            $deleteUPC = $_POST['upc'];
            // Bind the title_id parameter, 's' indicates a string value
            $stmt->bind_param("s", $deleteUPC);
            
            // Execute the delete statement
            $stmt->execute();
            
            if($stmt->error) {
                printf("<b>Error: %s.</b>\n", $stmt->error);
            } else {
                echo "<b>Successfully deleted ".$deleteUPC."</b>";
            }
            
            // INSERT
        } else if (isset($_POST["submitItem"]) && $_POST["submitItem"] ==  "ADD") {
            /*
             Add a book title using the post variables title_id, title and pub_id.
             */
            $upc = $_POST["new_upc"];
            $title = $_POST["new_title"];
            $type = $_POST["new_type"];
            $category = $_POST["new_category"];
            $company = $_POST["new_company"];
            $year = $_POST["new_year"];
            $price = $_POST["new_price"];
            $stock = $_POST["new_stock"];
            
            
            $stmt = $db->prepare("INSERT INTO Item (upc, title, type, category, company, year, price, stock) VALUES (?,?,?,?,?,?,?,?)");
            
            // Bind the title and pub_id parameters, 'sss' indicates 3 strings
            $stmt->bind_param("ssssssss", $upc, $title, $type, $category, $company, $year, $price, $stock);
            
            // Execute the insert statement
            $stmt->execute();
            
            if($stmt->error) {
                printf("<b>Error: %s.</b>\n", $stmt->error);
            } else {
                echo "<b>Successfully added ".$title."</b>";
            }
        } else if (isset($_POST["submitStock"]) && $_POST["submitStock"] == "Update Stock & Price"){
            $upc1 = $_POST["new_upc1"];
            $stock1 = $_POST["new_stock1"];
            $price1 = $_POST["new_price1"];
            
            
            $sql = "UPDATE Item SET stock ='".$stock1."', price ='".$price1."'WHERE ( upc = '".$upc1."')";
            
            if(mysqli_query($db, $sql)){
                echo "Record updated";
            }
            else{
                echo "Error updating" . mysqli_error($db);
            }
        }
    }
    ?>





<h1>Current Inventory</h1>
<!-- Set up a table to view the book titles -->
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->

<tr valign=center>
<td class=rowheader>UPC</td>
<td class=rowheader>Title</td>
<td class=rowheader>Type</td>
<td class=rowheader>Category</td>
<td class=rowheader>Company</td>
<td class=rowheader>Year</td>
<td class=rowheader>Price</td>
<td class=rowheader>Stock</td>
</tr>


<?php
    
    
    // Select all of the Item rows columns title, type, and year
    if (!$result = $db->query("SELECT upc, title, type, category, company, year, price, stock FROM Item ORDER BY title")) {
        die('There was an error running the query [' . $db->error . ']');
    }
    
    //This stuff was in bookbiz keep cause it's useful somehow
    // Avoid Cross-site scripting (XSS) by encoding PHP_SELF (this page) using htmlspecialchars.
    echo "<form id=\"delete\" name=\"delete\" action=\"";
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    echo "\" method=\"POST\">";
    // Hidden value is used if the delete link is clicked
    echo "<input type=\"hidden\" name=\"upc\" value=\"-1\"/>";
    // We need a submit value to detect if delete was pressed
    echo "<input type=\"hidden\" name=\"submitDeleteItem\" value=\"DELETE\"/>";
    
    while($row = $result->fetch_assoc()){
        
        echo "<td>".$row['upc']."</td>";
        echo "<td>".$row['title']."</td>";
        echo "<td>".$row['type']."</td>";
        echo "<td>".$row['category']."</td>";
        echo "<td>".$row['company']."</td>";
        echo "<td>".$row['year']."</td>";
        echo "<td>".$row['price']."</td>";
        echo "<td>".$row['stock']."</td><td>";
        
        
        echo "<a href=\"javascript:formSubmit('".$row['upc']."');\">DELETE</a>";
        echo "</td></tr>";
        
    }
    echo "</form>";
    
    // Close the connection to the database once we're done with it.
    mysqli_close($db);
    
    ?>

</table>


<br>
<h1>Add a New Item</h1>

<form id="add" name="add" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>UPC</td><td><input type="text" size=30 name="new_upc"</td></tr>
<tr><td>Title</td><td><input type="text" size=30 name="new_title"</td></tr>
<tr><td>Type</td><td> <input type="text" size=30 name="new_type"></td></tr>
<tr><td>Category</td><td><input type="text" size=30 name="new_category"</td></tr>
<tr><td>Company</td><td><input type="text" size=30 name="new_company"</td></tr>
<tr><td>Year</td><td><input type="text" size=30 name="new_year"</td></tr>
<tr><td>Price</td><td><input type="text" size=30 name="new_price"</td></tr>
<tr><td>Stock</td><td><input type="text" size=30 name="new_stock"</td></tr>
<tr><td></td><td><input type="submit" name="submitItem" border=0 value="ADD"></td></tr>
</table>
</form>

</table>



<br>
<h1>Update the Price and Stock of an Item</h1>

<form id="addstock" name="addstock" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>UPC</td><td><input type="text" size=30 name="new_upc1"</td></tr>
<tr><td>Stock</td><td><input type="text" size=30 name="new_stock1"</td></tr>
<tr><td>Price</td><td><input type="text" size=30 name="new_price1"</td></tr>
<tr><td></td><td><input type="submit" name="submitStock" border=0 value="Update Stock & Price"></td></tr>
</table>
</form>






<!-- ************************* PURCHASE ORDER ******************************* -->

<br>
<h1>View Purchase Orders</h1>
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>

<tr valign=center>
<td class=rowheader>Receipt ID</td>
<td class=rowheader>Date Ordered</td>
<td class=rowheader>Customer ID</td>
<td class=rowheader>Card Number</td>
<td class=rowheader>Expiry Date</td>
<td class=rowheader>Expected Date</td>
<td class=rowheader>Delivered Date</td>
</tr>




<?php
    
    $user = 'root';
    $pass = '';
    $db = 'AMS';
    
    $db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
    
    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_POST["submitDeletePurchaseOrder"]) && $_POST["submitDeletePurchaseOrder"] == "DELETE") {
            
            // Delete the selected book title using the upc
            // Create a delete query prepared statement with a ? for the title_id
            $stmtPO = $db->prepare("DELETE FROM PurchaseOrder WHERE receiptId=?");
            $deletePO = $_POST['receiptId'];
            // Bind the title_id parameter, 's' indicates a string value
            $stmtPO->bind_param("s", $deletePO);
            
            // Execute the delete statement
            $stmtPO->execute();
            
            if($stmtPO->error) {
                printf("<b>Error: %s.</b>\n", $stmtPO->error);
            } else {
                echo "<b>Successfully deleted ".$deletePO."</b>";
            }
            
            // INSERT
        } else if (isset($_POST["submitPurchaseOrder"]) && $_POST["submitPurchaseOrder"] ==  "ADD") {
            /*
             Add a book title using the post variables title_id, title and pub_id.
             */
            $receiptId = $_POST["new_receiptId"];
            $dateOrdered = $_POST["new_dateOrdered"];
            $cid = $_POST["new_cid"];
            $cardNum = $_POST["new_cardNum"];
            $expiryDate = $_POST["new_expiryDate"];
            $expectedDate = $_POST["new_expectedDate"];
            $deliveredDate = $_POST["new_deliveredDate"];
            
            
            $stmtPO = $db->prepare("INSERT INTO PurchaseOrder (receiptId, dateOrdered, cid, cardNum, expiryDate, expectedDate, deliveredDate) VALUES (?,?,?,?,?,?,?)");
            
            // Bind the title and pub_id parameters, 'sss' indicates 3 strings
            $stmtPO->bind_param("sssssss", $receiptId, $dateOrdered, $cid, $cardNum, $expiryDate, $expectedDate, $deliveredDate);
            
            // Execute the insert statement
            $stmtPO->execute();
            
            if($stmtPO->error) {
                printf("<b>Error: %s.</b>\n", $stmtPO->error);
            } else {
                echo "<b>Successfully added ".$receiptId."</b>";
            }
        } else if (isset($_POST["submitDD"]) && $_POST["submitDD"] == "ADD Delivery Date"){
            
            $receiptId1 = $_POST["new_receiptId1"];
            $deliveredDate1 = $_POST["new_deliveredDate1"];
            
            $sql = "UPDATE PurchaseOrder SET deliveredDate ='".$deliveredDate1."' WHERE ( receiptId = '".$receiptId1."')";
            
            if(mysqli_query($db, $sql)){
                echo "Record updated";
            }
            else{
                echo "Error updating" . mysqli_error($db);
            }
        }
    }
    ?>




<?php
    
    
    // Select all of the Item rows columns title, type, and year
    if (!$result = $db->query("SELECT receiptId, dateOrdered, cid, cardNum, expiryDate, expectedDate, deliveredDate FROM PurchaseOrder ORDER BY receiptId")) {
        die('There was an error running the query [' . $db->error . ']');
    }
    
    //This stuff was in bookbiz keep cause it's useful somehow
    // Avoid Cross-site scripting (XSS) by encoding PHP_SELF (this page) using htmlspecialchars.
    echo "<form id=\"deletePurchaseOrder\" name=\"deletePurchseOrder\" action=\"";
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    echo "\" method=\"POST\">";
    // Hidden value is used if the delete link is clicked
    echo "<input type=\"hidden\" name=\"receiptId\" value=\"-1\"/>";
    // We need a submit value to detect if delete was pressed
    echo "<input type=\"hidden\" name=\"submitDeletePurchaseOrder\" value=\"DELETE\"/>";
    
    
    
    while($row = $result->fetch_assoc()){
        
        echo "<td>".$row['receiptId']."</td>";
        echo "<td>".$row['dateOrdered']."</td>";
        echo "<td>".$row['cid']."</td>";
        echo "<td>".$row['cardNum']."</td>";
        echo "<td>".$row['expiryDate']."</td>";
        echo "<td>".$row['expectedDate']."</td>";
        echo "<td>".$row['deliveredDate']."</td><td>";
        
        //Display an option to delete this title using the Javascript function and the hidden title_id
        echo "<a href=\"javascript:formSubmitPurchaseOrder('".$row['receiptId']."');\">DELETE</a>";
        echo "</td></tr>";
        
    }
    echo "</form>";
    
    // Close the connection to the database once we're done with it.
    mysqli_close($db);
    
    ?>

</table>


<br>
<h1>Update Delivery Date For a Purchase Order</h1>

<form id="addDD" name="addDD" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>Receipt ID</td><td><input type="text" size=30 name="new_receiptId1"</td></tr>
<tr><td>Delivered Date</td><td><input type="text" size=30 name="new_deliveredDate1"</td></tr>
<tr><td></td><td><input type="submit" name="submitDD" border=0 value="ADD Delivery Date"></td></tr>
</table>
</form>





</body>
</html>





