<!DOCTYPE>
<html>
<head>

<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">


<script>

function formSubmitCart(title) {
    'use strict';
    if (confirm('THIS DELETES ITEM: STILL NEED TO IMPLEMENT ADD TO CART FUNCTIONALITY')) {
        // Set the value of a hidden HTML element in this form
        var form = document.getElementById('addToCart');
        form.title.value = title;
        // Post this form
        form.submit();
    }
}

function formSubmitUpc(upc) {
    'use strict';
    if (confirm('THIS DELETES ITEM: STILL NEED TO IMPLEMENT ADD TO CART FUNCTIONALITY')) {
        // Set the value of a hidden HTML element in this form
        var form = document.getElementById('shoppingCart');
        form.upc.value = upc;
        // Post this form
        form.submit();
    }
}

function formSubmitCart(cartID) {
    'use strict';
    if (confirm('Do you want to delete this item from your shopping cart?')) {
        // Set the value of a hidden HTML element in this form
        var form = document.getElementById('deleteItem');
        form.cartID.value = cartID;
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
<title>Customer</title>

<link href="style.css" rel="stylesheet" type="text/css">

</head>

<body>

<br>

<h0>&#8982; &Copf;&uopf;&sopf;&topf;&oopf;&mopf;&eopf;&ropf;&sopf; &#8982;</h0>


<br>

<a href= "home.php">Home</a>




<!--*******************  SEARCH ITEMS  ********************************************************************-->




<br>

<h1>Search for Music</h2>
<form id="searchingItems" name="searchingItems" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>Title</td><td><input type="text" size=30 name="new_title"</td></tr>
<tr><td>Singer</td><td><input type="text" size=30 name="new_name"</td></tr>
<tr><td>Category</td><td><input type="text" size=30 name="new_category"</td></tr>
<tr><td></td><td><input type="submit" name="searchItems" border=0 value="Search Me Silly!"></td></tr>
</table>
</form>

<br>
<h1>Search Results</h2>
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr valign=center>
<td class=rowheader>UPC</td>
<td class=rowheader>Album Title</td>
<td class=rowheader>Lead Singer</td>
<td class=rowheader>Category</td>
<td class=rowheader>Price</td>
<td class=rowheader>Stock</td>
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
    
    
    // SEARCH: broken into three queries/ if-statements: title, singer, category
    // All use same submit button
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        
        if(isset($_POST["searchItems"]) && $_POST["searchItems"] == "Search Me Silly!") {
            
            $searchItemTitle = $_POST['new_title'];
            
            $sqlTitle = "SELECT title, name, category, price, stock, Item.upc FROM Item, LeadSinger WHERE title='$searchItemTitle' AND Item.upc = LeadSinger.upc";
            
            $stmtTitle = $db->query($sqlTitle);
            
            if ($stmtTitle->num_rows > 0) {
                
                echo "<form id=\"addToCart\" name=\"addToCart\" action=\"";
                echo htmlspecialchars($_SERVER["PHP_SELF"]);
                echo "\" method=\"POST\">";
                echo "<input type=\"hidden\" name=\"upc\" value=\"-1\"/>";
                echo "<input type=\"hidden\" name=\"addToCart\" value=\"Add to Cart\"/>";
                
                
                while ($row = $stmtTitle->fetch_assoc()) {
                    echo "<td>".$row["upc"]. "</td>";
                    echo "<td>".$row["title"]. "</td>";
                    echo "<td>".$row["name"]. "</td>";
                    echo "<td>".$row["category"]. "</td>";
                    echo "<td>".$row["price"]. "</td>";
                    echo "<td>".$row["stock"]. "</td>";
                    
                    // echo "<td><a href=\"javascript:formSubmitSong('".$row['title']."');\">Add to Cart</a>";
                    echo "</td></tr>";
                }
                echo "</form>";
            }
        }
        
        
        
        
        if(isset($_POST["searchItems"]) && $_POST["searchItems"] == "Search Me Silly!") {
            
            $searchCategory = $_POST['new_category'];
            
            $sqlCategory = "SELECT  title, name, category, price, stock, Item.upc FROM Item, LeadSinger WHERE category='$searchCategory' AND Item.upc = LeadSinger.upc";
            
            $stmtCategory = $db->query($sqlCategory);
            
            if ($stmtCategory->num_rows > 0) {
                
                echo "<form id=\"addToCart\" name=\"addToCart\" action=\"";
                echo htmlspecialchars($_SERVER["PHP_SELF"]);
                echo "\" method=\"POST\">";
                echo "<input type=\"hidden\" name=\"upc\" value=\"-1\"/>";
                echo "<input type=\"hidden\" name=\"addToCart\" value=\"Add to Cart\"/>";
                
                while ($row = $stmtCategory->fetch_assoc()) {
                    echo "<td>".$row["upc"]. "</td>";
                    echo "<td>".$row["title"]. "</td>";
                    echo "<td>".$row["name"]. "</td>";
                    echo "<td>".$row["category"]. "</td>";
                    echo "<td>".$row["price"]. "</td>";
                    echo "<td>".$row["stock"]. "</td>";
                    
                    // echo "<td><a href=\"javascript:formSubmitSong('".$row['category']."');\">Add to Cart</a>";
                    echo "</td></tr>";
                }
                echo "</form>";
            }
        }
        
        if(isset($_POST["searchItems"]) && $_POST["searchItems"] == "Search Me Silly!") {
            
            $searchName = $_POST['new_name'];
            
            $sqlName = "SELECT  title, name, category, price, stock, Item.upc FROM Item, LeadSinger WHERE name='$searchName' AND Item.upc = LeadSinger.upc";
            
            $stmtName = $db->query($sqlName);
            
            if ($stmtName->num_rows > 0) {
                
                echo "<form id=\"addToCart\" name=\"addToCart\" action=\"";
                echo htmlspecialchars($_SERVER["PHP_SELF"]);
                echo "\" method=\"POST\">";
                echo "<input type=\"hidden\" name=\"upc\" value=\"-1\"/>";
                echo "<input type=\"hidden\" name=\"addToCart\" value=\"Add to Cart\"/>";
                
                
                while ($row = $stmtName->fetch_assoc()) {
                    echo "<td>".$row["upc"]. "</td>";
                    echo "<td>".$row["title"]. "</td>";
                    echo "<td>".$row["name"]. "</td>";
                    echo "<td>".$row["category"]. "</td>";
                    echo "<td>".$row["price"]. "</td>";
                    echo "<td>".$row["stock"]. "</td>";
                    
                    // echo "<td><a href=\"javascript:formSubmitSong('".$row['name']."');\">Add to Cart</a>";
                    echo "</td></tr>";
                }
                echo "</form>";
            }
        }
        
    }
    
    ?>

</table>







<!--*******************  SHOPPING CART  ********************************************************************-->



<br>
<h1>Enter the UPC and Quantity to Add to Your Basket</h1>
<form id="shoppingCart" name="shoppingCart" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>Enter the UPC</td><td><input type="text" size=30 name="new_upcCart"</td></tr>
<tr><td>Enter the Quantity</td><td><input type="text" size=30 name="new_quantCart"</td></tr>
<tr><td></td><td><input type="submit" name="shoppingCart" border=0 value="Add to Cart"></td></tr>
</table>
</form>


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
    
    
    if(isset($_POST["shoppingCart"]) && $_POST["shoppingCart"] == "Add to Cart") {
        
        $upcCart = $_POST['new_upcCart'];
        $sqlUpc = "SELECT upc, title, price, stock FROM Item WHERE upc='$upcCart'";
        $stmtUpc = $db->query($sqlUpc);
        
        
        $quantCart = $_POST['new_quantCart'];
        
        
        if ($stmtUpc->num_rows > 0) {
            
            echo "<form id=\"shoppingCart\" name=\"shoppingCart\" action=\"";
            echo htmlspecialchars($_SERVER["PHP_SELF"]);
            echo "\" method=\"POST\">";
            echo "<input type=\"hidden\" name=\"upc\" value=\"-1\"/>";
            echo "<input type=\"hidden\" name=\"shoppingCart\" value=\"Add to Cart\"/>";
            
            
            while ($row = $stmtUpc->fetch_assoc()) {
                
                
                
                if ($quantCart > $row["stock"]){
                    echo "Insufficient Stock. There are only ".$row["stock"]. " " .$row["title"]."'s available.";
                    break;
                    
                    
                } else if ($quantCart <= $row["stock"]) {
                    
                    
                    //can't yet insert into PurchaseItem, becuase these need to go into shopping cart
                    // insert these into ShoppingCart Table
                    //delete all tuples from ShoppingCart after using: sqlClearShoppingCart = (DELETE * FROM ShoppingCart);
                    
                    $cost = $row['price']*$quantCart;
                    
                    $stmtCart= $db->prepare("INSERT INTO ShoppingCart (upc, title, quantity, price, cost) VALUES (?, ?, ?, ?, ?)");
                    $stmtCart->bind_param("sssss", $upcCart, $row['title'] , $quantCart, $row['price'], $cost );
                    $stmtCart->execute();
                    
                }
                
            }
            
            
            //echo "<td><a href=\"javascript:formSubmitUpc('".$row['upc']."');\">Add to Cart</a>";
            echo "</td></tr>";
        }
        echo "</form>";
        
    }
    
    
    
    ?>


<!-- ********************** DISPLAY SHOPPING CART **************************** -->

<br>
<h1>Shopping Cart</h1>
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr valign=center>
<td class=rowheader>Title</td>
<td class=rowheader>Unit Price</td>
<td class=rowheader>Quantity</td>
<td class=rowheader>Cost</td>
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
    
    // DELETE ITEM
    
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_POST["deleteItem"]) && $_POST["deleteItem"] == "Remove Item") {
            
            // Delete the selected book title using the upc
            // Create a delete query prepared statement with a ? for the title_id
            $stmtCID = $db->prepare("DELETE FROM ShoppingCart WHERE cartID=?");
            
            
            $deleteCID = $_POST['cartID'];
            // Bind the title_id parameter, 's' indicates a string value
            $stmtCID->bind_param("s", $deleteCID);
            
            // Execute the delete statement
            $stmtCID->execute();
            
            if($stmtCID->error) {
                printf("<b>Error: %s.</b>\n", $stmtCID->error);
            } else {
                echo "Successfully removed item from shopping cart.";
            }
            
        }
    }
    ?>






<?php
    
    if (!$cartStmt = $db->query("SELECT cartID, title, price, quantity, cost FROM ShoppingCart ORDER BY title")) {
        die('There was an error running the query');
    }
    
    echo "<form id=\"deleteItem\" name=\"deleteItem\" action=\"";
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    echo "\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"cartID\" value=\"-1\"/>";
    echo "<input type=\"hidden\" name=\"deleteItem\" value=\"Remove Item\"/>";
    
    
    
    //$cartSql  = "SELECT title, price, quantity, cost FROM ShoppingCart ORDER BY title";
    //$cartStmt = $db->query($cartSql);
    
    
    if ($cartStmt->num_rows > 0) {
        
        //TRY TO PUT DISPLAY SHOPPING CART ITEMS: CODE HERE
        
        while ($CartRow = $cartStmt->fetch_assoc()) {
            
            echo "<td>".$CartRow['title']."</td>";
            echo "<td>".$CartRow['price']."</td>";
            echo "<td>".$CartRow['quantity']."</td>";
            echo "<td>".$CartRow['cost']."</td>";
            
            echo "<td><a href=\"javascript:formSubmitCart('".$CartRow['cartID']."');\">Remove Item</a>";
            echo "</td></tr>";
            
        }
        echo "</form>";
        
    }
    
    mysqli_close($db);
    
    ?>





</table>

<br>







<!--*************************  CHECKOUT  ********************************************************************-->



<h1>Proceed to Checkout</h1>

<!--<form id="login" name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table border=0 cellpadding=0 cellspacing=0>
<tr><td><h2>Login</h2></td><td><input type="text" size=30 name="novel_login"</td></tr>
<tr><td><h2>Password</h2></td><td><input type="text" size=30 name="novel_password"</td></tr>
<tr><td></td><td><input type="submit" name="loginCust" border=0 value="Login"></td></tr>
</table>
</form>-->


<?php
    
    $user = 'root';
    $pass = '';
    $db = 'AMS';
    
    $db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
    
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        
        if (isset($_POST["loginCust"]) && $_POST["loginCust"] ==  "Login") {
            
            $newLogin = $_POST["novel_login"];
            $newPassword = $_POST["novel_password"];
            
            
            $sql = 'SELECT cid, password, name FROM Customer WHERE '. 'cid='.$newLogin;
            $stmtLogin = $db->query($sql);
            
            
            if($stmtLogin->num_rows > 0) {
                while ($row = $stmtLogin->fetch_assoc()) {
                    
                    if ($row["password"] == $newPassword){
                        echo "Hey heeey ".$row["name"]. "<br>";
                        // echo '<a href="home.php">GO TO...</a>';
                        
                    }
                    else {
                        echo "Invalid Password";
                    }
                }
            } else {
                
                $sql1 = 'SELECT cid, password, name FROM Customer WHERE '. 'cid='.$newLogin;
                $stmtLogin1 = $db->query($sql1);
                
                if($stmtLogin->num_rows > 0) {
                    while ($row = $stmtLogin->fetch_assoc()) {
                        
                        if ($row["password"] == $newPassword){
                            echo "Hey heeey ".$row["name"]. "<br>";
                            
                        }
                        else {
                            echo "Invalid Password";
                        }
                    }
                }
                
                echo "Invalid Login";
            }
        }
        
    }
    mysqli_close($db);
    ?>



<!--*************************  CREATE PO  ********************************************************************-->


<form id="add" name="add" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<!--<tr><td>Receipt ID</td><td><input type="text" size=30 name="new_receiptId"</td></tr>-->
<tr><td>Date Ordered</td><td><input type="text" size=30 name="new_dateOrdered"</td></tr>
<tr><td>Customer ID</td><td> <input type="text" size=30 name="new_cid"></td></tr>
<tr><td>Card Number</td><td><input type="text" size=30 name="new_cardNum"</td></tr>
<tr><td>Expiry Date</td><td><input type="text" size=30 name="new_expiryDate"</td></tr>
<!--<tr><td>Expected Date</td><td><input type="text" size=30 name="new_expectedDate"</td></tr>
<tr><td>Delievered Date</td><td><input type="text" size=30 name="new_deliveredDate"</td></tr>
<tr><td>Total Cost</td><td><input type="text" size=30 name="new_totalCost"</td></tr>-->
<tr><td></td><td><input type="submit" name="submitPurchaseOrder" border=0 value="ADD"></td></tr>
</table>
</form>




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
    
    // DELETE
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
            // $receiptId = $_POST["new_receiptId"];
            //$receiptId = rand(11111111111,99999999999);
            $dateOrdered = $_POST["new_dateOrdered"];
            $cid = $_POST["new_cid"];
            $cardNum = $_POST["new_cardNum"];
            $expiryDate = $_POST["new_expiryDate"];
            //$expectedDate = $_POST["new_expectedDate"];
            //$deliveredDate = $_POST["new_deliveredDate"];
            //$totalCost = $_POST["new_totalCost"];
            
            
            $stmtPO = $db->prepare("INSERT INTO PurchaseOrder (dateOrdered, cid, cardNum, expiryDate, expectedDate, deliveredDate, totalCost) VALUES (?,?,?,?,?,?,?)");
            
            // Bind the title and pub_id parameters, 'sss' indicates 3 strings
            $stmtPO->bind_param("sssssss", $dateOrdered, $cid, $cardNum, $expiryDate, $expectedDate, $deliveredDate, $totalCost);
            
            //$expectedDate, $deliveredDate)
            
            // Execute the insert statement
            $stmtPO->execute();
            
            if($stmtPO->error) {
                printf("<b>Error: %s.</b>\n", $stmtPO->error);
            } else {
                echo "Successfully added receipt";
            }
            
            
            
            
            
            
            $stmtGetUpc = $db->query("SELECT upc, title, quantity, price, cost FROM ShoppingCart");
            //$receiptrand = 10101;
            
            
            if($stmtGetUpc->num_rows > 0) {
                
                while($row = $stmtGetUpc->fetch_assoc()) {
                    $sqlin = $db->prepare( "INSERT INTO PurchaseItem (receiptId, upc, title, quantity, price, cost) VALUES(?,?,?,?,?,?)");
                    $sqlin->bind_param("ssssss", $receiptId, $row['upc'], $row['title'] , $row['quantity'], $row['price'] , $row['cost']);
                    $sqlin->execute();
                }
            }
            else {
                echo "Failed to add!";
            }
            
            
            //$stmtAddPI = $db->prepare("INSERT '".$stmtGetUpc."' INTO PurchaseItem");
            // $stmtAddPI->bind_param("s", );
            
            //$stmtAddPI->execute();
            
            /* while($row = $stmtCheckout->fetch_assoc()){
             
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
             
             } */
            
            
            
            
            if($stmtPO->error) {
                printf("<b>Error: %s.</b>\n", $stmtPO->error);
            } else {
                echo "<b>Successfully added ".$receiptId."</b>";
            }
            
            
        }
    }
    ?>




<?php
    
    
    // Select all of the Item rows columns title, type, and year
    if (!$result = $db->query("SELECT receiptId, dateOrdered, cid, cardNum, expiryDate, expectedDate, deliveredDate, totalCost FROM PurchaseOrder ORDER BY receiptId")) {
        die('There was an error running the query [' . $db->error . ']');
    }
    
    echo "<form id=\"deletePurchaseOrder\" name=\"deletePurchseOrder\" action=\"";
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    echo "\" method=\"POST\">";
    // Hidden value is used if the delete link is clicked
    echo "<input type=\"hidden\" name=\"receiptId\" value=\"-1\"/>";
    // We need a submit value to detect if delete was pressed
    echo "<input type=\"hidden\" name=\"submitDeletePurchaseOrder\" value=\"DELETE\"/>";
    
    
    
    /* while($row = $result->fetch_assoc()){
     
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
     
     } */
    echo "</form>";
    
    // Close the connection to the database once we're done with it.
    mysqli_close($db);
    
    ?>


<!-- ***************************** BILL ******************************* -->

<br>
<h1>Bill</h1>
<!-- Set up a table to view the book titles -->
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->

<tr valign=center>
<td class=rowheader>Title</td>
<td class=rowheader>Cost</td>
<!-- <td class=rowheader>Customer ID</td>
<td class=rowheader>Card Number</td>
<td class=rowheader>Expiry Date</td>
<td class=rowheader>Expected Date</td>
<td class=rowheader>Delivered Date</td>
<td class=rowheader>Total Cost</td> -->
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
        
        if (isset($_POST["submitPurchaseOrder"]) && $_POST["submitPurchaseOrder"] == "ADD") {
            
            $sql = "SELECT ShoppingCart.title as title, ShoppingCart.cost as cost FROM ShoppingCart";
            
            $results = $db->query($sql);
            
            
            if($results->num_rows) {
                while($row = $results->fetch_assoc()) {
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['cost']."</td>";
                    
                    
                    
                    echo "</td></tr>";
                }
                
            } else{
                echo 'No results';
            }
            
            
            
            $sql2 = "SELECT SUM(ShoppingCart.cost) as sum1 FROM ShoppingCart";
            $results1 = $db->query($sql2);
            
            
            if($results1->num_rows) {
                while($row1 = $results1->fetch_assoc()){
                    //echo "<td>".$row1['']."</td>";
                    echo "<td>Total Cost: ".$row1['sum1']."</td>";
                    $sql3 = "UPDATE PurchaseOrder.totalCost WHERE PurchaseOrder.totalCost = '".$row1['sum1']."'";
                    $db->query($sql3);
                    
                    
                    echo "</td></tr>";
                }
            }else{
                echo 'No results';
            }
            
            $tots = 0;
            $sql3 = "SELECT PurchaseOrder.expectedDate FROM PurchaseOrder WHERE PurchaseOrder.deliveredDate is NULL";
            $results3 = $db->query($sql3);
            if($results3->num_rows) {
                while($row3 = $results1->fetch_assoc()){
                    //echo "<td>".$row['']."</td>";
                    
                    // echo "<td>Your expected Delivery date is: ".$row3['expectedDate']."</td>";
                    $tots = $tots + 1;
                    
                    //echo "</td></tr>";
                }
                
                //$expectedDate = date('y:m:d',(strtotime(" + ($tots % 5)")));
                //$expectedDate = date_add(NULL, $tots % 5);
                $expectedDate = date('y:m:d',(time()+($tots % 5)));
                
                
                
                $db->query("UPDATE PurchaseOrder SET expectedDate = '".$expectedDate."' WHERE expectedDate is NULL");
                echo "YOUR DELIVERY DATE SHOULD BE AROUND: " .$expectedDate;
                
                $sqlend = "Delete FROM ShoppingCart";
                $db->query($sqlend);
                
            }else{
                echo 'No results';
            }
            
            
            
        }
    }
    
    
    ?>


</table>

<a href= "home.php">Thank you, come again.</a>


</body>
</html>





















