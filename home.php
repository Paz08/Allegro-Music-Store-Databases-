<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<title>HOME</title>

<link href="style.css" rel="stylesheet" type="text/css">


<script>

function formSubmitCust(cid) {
    'use strict';
    if (confirm('Are you sure you want to delete this customer?')) {
        // Set the value of a hidden HTML element in this form
        var form = document.getElementById('deleteCust');
        form.cid.value = cid;
        // Post this form
        form.submit();
    }
}

</script>
</head>


<body>


<br>

<h0>&#9836 &Aopf;&lopf;&lopf;&eopf;&gopf;&ropf;&oopf; &Mopf;&uopf;&sopf;&iopf;&copf; &Sopf;&topf;&oopf;&ropf;&eopf; &#9836</h0>

<br>
<br>

<a href="customer.php">Customer</a>
<a href="clerk.php">Clerk</a>
<a href="manager.php">Manager</a>

<br/ >
<br/ >

<h1>Hello Music &#10084r's. Welcome to the Allegro Music Store!<h1>


<h2>If you already have an account, login below then get your booty to the <a href="customer.php">online dancefloor</a> to start groovin.</h3>

<h1>Login</h1>

<form id="login" name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>Login</td><td><input type="text" size=30 name="novel_login"</td></tr>
<tr><td>Password</td><td><input type="text" size=30 name="novel_password"</td></tr>
<tr><td></td><td><input type="submit" name="loginCust" border=0 value="Login"></td></tr>
</table>
</form>


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
            
            
            $sql = "SELECT cid, password, name FROM Customer WHERE cid='$newLogin'";
            $stmtLogin = $db->query($sql);
            
            
            if($stmtLogin->num_rows > 0) {
                while ($row = $stmtLogin->fetch_assoc()) {
                    
                    if ($row["password"] == $newPassword){
                        echo "Hey heeeeey ".$row["name"]. "<br>";
                        
                        
                    }
                    else {
                        echo "<b>Wrong password dude.<b>";
                    }
                }
            } else {
                
                $sql1 = "SELECT cid, password, name FROM Customer WHERE cid='$newLogin'";
                $stmtLogin1 = $db->query($sql1);
                
                if($stmtLogin->num_rows > 0) {
                    while ($row = $stmtLogin->fetch_assoc()) {
                        
                        if ($row["password"] == $newPassword){
                            echo "Hey heeeeey ".$row["name"]. "<br>";
                            
                        }
                        else {
                            echo "<b>Wrong password dude.<b>";
                        }
                    }
                }
                
                echo "<b>Wrong login dude.<b>";
            }
        }
        
    }
    mysqli_close($db);
    ?>


<br>
<h2> If not, create an account below to register on AMS and begin searching for your favourite tunes.</h2>


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
        
        if (isset($_POST["submitDeleteCust"]) && $_POST["submitDeleteCust"] == "DELETE") {
            
            // Delete the selected book title using the upc
            // Create a delete query prepared statement with a ? for the title_id
            $stmtCust = $db->prepare("DELETE FROM Customer WHERE cid=?");
            $deleteCID = $_POST['cid'];
            // Bind the title_id parameter, 's' indicates a string value
            $stmtCust->bind_param("s", $deleteCID);
            
            // Execute the delete statement
            $stmtCust->execute();
            
            if($stmtCust->error) {
                printf("<b>Error: %s.</b>\n", $stmtCust->error);
            } else {
                echo "<b>Successfully deleted ".$deleteCID."</b>";
            }
            
            // INSERT
        } else if (isset($_POST["submitCust"]) && $_POST["submitCust"] ==  "Create Account") {
            /*
             Add a book title using the post variables title_id, title and pub_id.
             */
            $cid = $_POST["new_cid"];
            $password = $_POST["new_password"];
            $name = $_POST["new_name"];
            $address = $_POST["new_address"];
            $phone = $_POST["new_phone"];
            
            
            $stmtCust = $db->prepare("INSERT INTO Customer (cid, password, name, address, phone) VALUES (?,?,?,?,?)");
            
            // Bind the title and pub_id parameters, 'sss' indicates 3 strings
            $stmtCust->bind_param("sssss", $cid, $password, $name, $address, $phone);
            
            // Execute the insert statement
            $stmtCust->execute();
            
            if($stmtCust->error) {
                printf("<b>Error: %s.</b>\n", $stmtCust->error);
            } else {
                echo "<b><h2>Hey heeeeey ".$name.", thanks for registering!</h2></b>";
            }
        }
    }
    
    ?>


<h1>Create a New Account</h1>

<form id="addCust" name="addCust" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table id="tableBorder" border=0 cellpadding=0 cellspacing=0>
<tr><td>Login</td><td><input type="text" size=30 name="new_cid"</td></tr>
<tr><td>Password</td><td><input type="text" size=30 name="new_password"</td></tr>
<tr><td>Name</td><td> <input type="text" size=30 name="new_name"></td></tr>
<tr><td>Address</td><td><input type="text" size=30 name="new_address"</td></tr>
<tr><td>Phone</td><td><input type="text" size=30 name="new_phone"</td></tr>
<tr><td></td><td><input type="submit" name="submitCust" border=0 value="Create Account"></td></tr>
</table>
</form>


</body>
</html>









