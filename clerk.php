<!DOCTYPE>
<html>
<head>

<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">


<title>Clerk</title>

<link href="style.css" rel="stylesheet" type="text/css">

<script>
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

function formSubmitReturn(retid) {
    'use strict';
    if (confirm('Are you sure you want to delete this return?')) {
        // Set the value of a hidden HTML element in this form
        var form = document.getElementById('deleteReturn');
        form.retid.value = retid;
        // Post this form
        form.submit();
    }
}


function formSubmitRetitem(retid) {
    'use strict';
    if (confirm('Are you sure you want to delete this returnItem?')) {
        // Set the value of a hidden HTML element in this form
        var form = document.getElementById('deleteRetitem');
        form.retid.value = retid;
        // Post this form
        form.submit();
    }
}

</script>


</head>

<body>

<br>

<h0>&#9997; &Copf;&lopf;&eopf;&ropf;&kopf; &#9997;</h0>

<br>

<a href= "home.php">Home</a>

<br>


<!--*********************** RETURN ITEM  *******************************-->

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
        
        if (isset($_POST["submitDeleteRetitem"]) && $_POST["submitDeleteRetitem"] == "DELETE") {
            
            // Delete the selected book title using the upc
            // Create a delete query prepared statement with a ? for the title_id
            $stmtRetitem = $db->prepare("DELETE FROM ReturnItem WHERE retid=?");
            $deleteRET = $_POST['retid'];
            // Bind the title_id parameter, 's' indicates a string value
            $stmtRetitem->bind_param("s", $deleteRET);
            
            // Execute the delete statement
            $stmtRetitem->execute();
            
            if($stmtRetitem->error) {
                printf("<b>Error: %s.</b>\n", $stmtRetitem->error);
            } else {
                echo "<b>Successfully deleted ".$deleteRET."</b>";
            }
            
            // INSERT
        } else if (isset($_POST["submitRetitem"]) && $_POST["submitRetitem"] ==  "ADD") {
            /*
             Add a book title using the post variables title_id, title and pub_id.
             */
            $retid = $_POST["new_retid"];
            $upc = $_POST["new_upc"];
            $quantity = $_POST["new_quantity"];
            
            
            $stmtRetitem = $db->prepare("INSERT INTO ReturnItem (retid, upc, quantity) VALUES (?,?,?)");
            
            // Bind the title and pub_id parameters, 'sss' indicates 3 strings
            $stmtRetitem->bind_param("sss", $retid, $upc, $quantity);
            
            // Execute the insert statement
            $stmtRetitem->execute();
            
            if($stmtRetitem->error) {
                printf("<b>Error: %s.</b>\n", $stmtRetitem->error);
            } else {
                echo "<b>Successfully added ".$retid."</b>";
            }
            
            
        }
    }
    ?>




<?php
    
    
    
    // Select all of the Item rows columns title, type, and year
    if (!$result = $db->query("SELECT retid, upc, quantity FROM ReturnItem ORDER BY retid")) {
        die('There was an error running the query [' . $db->error . ']');
    }
    
    //This stuff was in bookbiz keep cause it's useful somehow
    // Avoid Cross-site scripting (XSS) by encoding PHP_SELF (this page) using htmlspecialchars.
    echo "<form id=\"deleteRetitem\" name=\"deleteRetitem\" action=\"";
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    echo "\" method=\"POST\">";
    // Hidden value is used if the delete link is clicked
    echo "<input type=\"hidden\" name=\"retid\" value=\"-1\"/>";
    // We need a submit value to detect if delete was pressed
    echo "<input type=\"hidden\" name=\"submitDeleteRetitem\" value=\"DELETE\"/>";
    
    
    echo "</form>";
    
    // Close the connection to the database once we're done with it.
    mysqli_close($db);
    
    ?>

</table>







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
    
    //  CHECK IF RETURN IS VALID
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if(isset($_POST["checkReturn"]) && $_POST["checkReturn"] == "Check Return") {
            
            $newReceiptId = $_POST["novel_receiptId"];
            
            
            
            $sqlReturn = "SELECT receiptId, deliveredDate, cardNum  FROM PurchaseOrder WHERE receiptId='$newReceiptId'";
            
            
            $stmtReturn = $db->query($sqlReturn);
            
            
            $currentDate = strtotime(date("Y-m-d"));
            
            if ($stmtReturn->num_rows > 0) {
                
                while ($row = $stmtReturn->fetch_assoc()) {
                    $delivDate = strtotime($row["deliveredDate"]). "<br>";
                    ($range = $currentDate - $delivDate) / (60*60*24);
                    
                    $rangeDay = ($range / (60*60*24));
                    $custCard =$row["cardNum"]."<br>";
                    if ($rangeDay < 15){
                        echo "<b> The receipt is still valid.<br> Clerk may process the return. <br></b>";
                        echo "<b> Days remaining to process receipt: ".$rangeDay."<br></b>";
                        echo "<b> Issue Refund to Credit Card number: ".$custCard."</b>";
                    } else {
                        echo "<b> The receipt is non valid.<br> Clerk may not process the return.</b>";
                        echo "<b> Days past return date:  ".$rangeDay."</b>";
                    }
                    
                }
                
            }
            else echo "<b> Invalid receipt ID.<br> Please re-enter valid receipt ID.<br></b>";
        }
        
    }
    
    
    
    
    
    
    
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
    }
    
    ?>


<h1>Check if a Return is Valid</h2>

<form id="checkRet" name="checkRet" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>Receipt ID</td><td><input type="text" size=30 name="novel_receiptId"</td></tr>
<tr><td></td><td><input type="submit" name="checkReturn" border=0 value="Check Return"></td></tr>
</table>
</form>






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
    
    
    echo "</form>";
    
    // Close the connection to the database once we're done with it.
    mysqli_close($db);
    
    ?>

</table>






<!--*********************** RETURNS  *******************************-->

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
        
        
        if (isset($_POST["submitDeleteReturn"]) && $_POST["submitDeleteReturn"] == "DELETE") {
            
            // Delete the selected book title using the upc
            // Create a delete query prepared statement with a ? for the title_id
            $stmtReturn = $db->prepare("DELETE FROM Returns WHERE retid=?");
            $deleteRETID = $_POST['retid'];
            // Bind the title_id parameter, 's' indicates a string value
            $stmtReturn->bind_param("s", $deleteRETID);
            
            // Execute the delete statement
            $stmtReturn->execute();
            
            if($stmtReturn->error) {
                printf("<b>Error: %s.</b>\n", $stmtReturn->error);
            } else {
                echo "<b>Successfully deleted ".$deleteRETID."</b>";
                
            }
            
            
            // INSERT
        } else if (isset($_POST["submitReturn"]) && $_POST["submitReturn"] ==  "ADD") {
            /*
             Add a book title using the post variables title_id, title and pub_id.
             */
            $retid = $_POST["new_retid"];
            $dateReturned = $_POST["new_dateReturned"];
            $receiptId = $_POST["new_receiptId"];
            $upc = $_POST["new_upc"];
            $quantity = $_POST["new_quantity"];
            
            
            $stmtReturn = $db->prepare("INSERT INTO Returns (retid, dateReturned, receiptId) VALUES (?,?,?)");
            $stmtReturn->bind_param("sss", $retid, $dateReturned, $receiptId);
            $stmtReturn->execute();
            
            $stmtStock = $db->query("SELECT stock FROM Item WHERE (upc='".$upc."')");
            
            $result = $stmtStock->fetch_assoc();
            
            
            
            
            $quantityUpdate = $quantity + $result['stock'];
            
            $quantityUpdate = intval($quantityUpdate);
            
            
            $quantityUpdate = strval($quantityUpdate);
            
            
            $stmtUpdate = $db->query("UPDATE Item SET stock='".$quantityUpdate."' WHERE (upc='".$upc."')");
            
            if($stmtReturn->error) {
                printf("<b>Error: %s.</b>\n", $stmtReturn->error);
            } else {
                echo "<b>Successfully returned item from receipt ".$retid."</b>";
            }
        }
    }
    $retrieveReceiptId = $db->query("SELECT receiptId FROM PurchaseOrder, Customer WHERE PurchaseOrder.cid = Customer.cid AND Customer.cid = 111");
    
    if($retrieveReceiptId->num_rows > 0) {
        while ($row = $retrieveReceiptId->fetch_assoc()) {
            // echo "receiptid: ".$row["receiptId"]. "<br>";
        }
    }
    
    ?>
<br>
<br>




<?php
    
    
    
    // Select all of the Item rows columns title, type, and year
    if (!$result = $db->query("SELECT retid, dateReturned, receiptId FROM Returns ORDER BY retid")) {
        die('There was an error running the query [' . $db->error . ']');
    }
    
    //This stuff was in bookbiz keep cause it's useful somehow
    // Avoid Cross-site scripting (XSS) by encoding PHP_SELF (this page) using htmlspecialchars.
    echo "<form id=\"deleteReturn\" name=\"deleteReturn\" action=\"";
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    echo "\" method=\"POST\">";
    // Hidden value is used if the delete link is clicked
    echo "<input type=\"hidden\" name=\"retid\" value=\"-1\"/>";
    // We need a submit value to detect if delete was pressed
    echo "<input type=\"hidden\" name=\"submitDeleteReturn\" value=\"DELETE\"/>";
    
    echo "</form>";
    
    // Close the connection to the database once we're done with it.
    mysqli_close($db);
    
    ?>

</table>

<h1>Add a New Return &#9785;</h1>



<form id="addReturn" name="addReturn" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>Return ID</td><td><input type="text" size=30 name="new_retid"</td></tr>
<tr><td>Date Returned</td><td><input type="text" size=30 name="new_dateReturned"</td></tr>
<tr><td>Receipt Id</td><td> <input type="text" size=30 name="new_receiptId"></td></tr>
<tr><td>Item UPC</td><td><input type="text" size=30 name="new_upc"</td></tr>
<tr><td>Quantity</td><td> <input type="text" size=30 name="new_quantity"></td></tr>
<tr><td></td><td><input type="submit" name="submitReturn" border=0 value="ADD"></td></tr>
</table>
</form>




</body>
</html>












