<!DOCTYPE>
<html>
<head>

<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">



<title>Daily Reports</title>

<link href="style.css" rel="stylesheet" type="text/css">

</head>

<body>

<br>

<h0>&dollar; &Ropf;&eopf;&popf;&oopf;&ropf;&topf;&sopf; &dollar;</h0>

<br>

<a href= "manager.php">Manager</a>

<!---- ***********************************DAILY REPORT************************************************** --->

<h1>Generate a Daily Report</h1>

<form id="add" name="add" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>Date</td><td><input type="text" size=30 name="new_dateOrdered"</td></tr>
<tr><td></td><td><input type="submit" name="submitManagerReport" border=0 value="Generate Report"></td></tr>
</table>
</form>
<br>


<h1>Daily Reports</h1>
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>

<tr valign=center>
<td class=rowheader>UPC</td>
<td class=rowheader>Category</td>
<td class=rowheader>Unit Price</td>
<td class=rowheader>Units</td>
<td class=rowheader>Total Value</td>
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
        
        if (isset($_POST["submitManagerReport"]) && $_POST["submitManagerReport"] == "Generate Report") {
            
            $DateOrdered = $_POST['new_dateOrdered'];
            
            $sql = "SELECT PurchaseItem.receiptId, Item.category, PurchaseItem.quantity, Item.upc, Item.price, Item.price*PurchaseItem.quantity as TotalValue, PurchaseOrder.dateOrdered FROM PurchaseItem INNER JOIN PurchaseOrder ON PurchaseOrder.receiptId = PurchaseItem.receiptId JOIN Item ON Item.upc = PurchaseItem.upc WHERE PurchaseOrder.dateOrdered = ' ".$DateOrdered." 'ORDER BY Item.category";
            
            $results = $db->query($sql);
            $tots = 0;
            $mcgoats = 0;
            
            if($results->num_rows) {
                while($row = $results->fetch_assoc()) {
                    //echo "{$row->receiptId} {$row->upc} {$row->quantity} {$row->dateOrdered} {$row->price} {$row->TotalValue}<br>";
                    echo "<td>".$row['upc']."</td>";
                    echo "<td>".$row['category']."</td>";
                    echo "<td>".$row['price']."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    echo "<td>".$row['TotalValue']."</td>";
                    $tots = $tots + $row['TotalValue'];
                    $mcgoats = $mcgoats + $row['quantity'];
                    
                    echo "</td></tr>";
                }
                echo "Total Sales: " .$tots;
                echo " Total Units: " .$mcgoats;
            } else{
                echo 'No results';
            }
            
            
            
            $sql2 = "SELECT Item.category, SUM(PurchaseItem.quantity) as sum1, SUM(Item.price*PurchaseItem.quantity) as sum2 FROM PurchaseItem INNER JOIN PurchaseOrder ON PurchaseOrder.receiptId = PurchaseItem.receiptId JOIN Item ON Item.upc = PurchaseItem.upc WHERE PurchaseOrder.dateOrdered = ' ".$DateOrdered." ' GROUP BY Item.category";
            $results1 = $db->query($sql2);
            $tots1 = 0;
            
            if($results1->num_rows) {
                while($row1 = $results1->fetch_assoc()){
                    //echo "<td>".$row1['category']."</td>";
                    echo "<td>".$row['']."</td>";
                    echo "<td>Total from ".$row1['category']."</td>";
                    echo "<td>".$row['']."</td>";
                    echo "<td>".$row1['sum1']."</td>";
                    echo "<td>".$row1['sum2']."</td>";
                    /*while($row1 = $results1->fetch_object()) {
                     echo "{$row1->category} {$row1->sum1} {$row1->sum2}<br>";
                     }*/
                    
                    echo "</td></tr>";
                }
            }else{
                echo 'No results';
            }
            
        }
    }
    
    ?>



</table>

<!----- ****************************************TOP SELLING ITEMS****************************************** --->

<br>
<h1>Generate Report for Top Selling Items</h2>
<form id="add" name="add" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table ID="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>Date</td><td><input type="text" size=30 name="new_dateOrdered1"</td></tr>
<tr><td>Limit</td><td><input type="text" size=30 name="new_limit"</td></tr>
<tr><td></td><td><input type="submit" name="submitTopSelling" border=0 value="Find Top Selling Items"></td></tr>
</table>
</form>

<h1>Top Selling Items</h1>
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>

<tr valign=center>
<td class=rowheader>Title</td>
<td class=rowheader>Company</td>
<td class=rowheader>Current Stock</td>
<td class=rowheader>Number of Copies Sold</td>
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
        
        if (isset($_POST["submitTopSelling"]) && $_POST["submitTopSelling"] == "Find Top Selling Items") {
            
            $DateOrdered1 = $_POST['new_dateOrdered1'];
            $Limit = $_POST['new_limit'];
            
            $sql3 = "SELECT Item.upc, Item.title, Item.company, Item.stock, PurchaseItem.quantity FROM PurchaseItem INNER JOIN PurchaseOrder ON PurchaseOrder.receiptId = PurchaseItem.receiptId JOIN Item ON Item.upc = PurchaseItem.upc WHERE PurchaseOrder.dateOrdered = ' ".$DateOrdered1." ' ORDER BY PurchaseItem.quantity DESC LIMIT  $Limit ";
            
            $result = $db->query($sql3);
            
            
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    //echo "{$row2->title} {$row2->company} {$row2->stock} {$row2->quantity}<br>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['company']."</td>";
                    echo "<td>".$row['stock']."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    
                    echo "</td></tr>";
                }
                
            } else{
                echo 'No results';
            }
        }
    }
    
    ?>



</table>








</body>
</html>




