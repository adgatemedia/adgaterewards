<?php

/**
 * For a plain PHP page to receive the postback data from AdGate Media you may simply
 * retrieve the array from the global $_GET variable. To ensure that the data is coming
 * from AdGate Media check that the server sending the data is from AdGate Media by the ip
 * address as listed on your affiliate panel at http://adgatemedia.com under
 * the Postbacks Section and the Postback Information heading.
 */
define('AdGate_IP', '123.123.123.123'); // Note: as noted above change the IP to match what is in your affiliate panel.
protected $ip = $_SERVER['REMOTE_ADDR'];
protected $data = null;
protected $servername = "localhost";
protected $username = "username";
protected $password = "password";
protected $dbname = "app";


/**
 * Check the Remote Address is AdGate Media
 * if it is not throw an Exception
 */
if($ip === AdGate_IP)
{
    $data = $_GET;
    // Process or Persist Data here inline or via a function call.
} else {

     // Throw either a custom Exception or just throw a generic \Exception
    throw new InvalidIPException();
}


/**
 * The data array will contain all the macros you included under the Postbacks section of your
 * affiliate panel at http://adgatemedia.com. The array is keyed by the names you assigned to each macro
 * when you constructed the url e.g., http://yoururl.com/postback/?tx_id={transaction_id}
 * the transaction_id macro's data will have a key of 'tx_id' in the $data array: $data['tx_id'];
 *
 * Possible Macros
 * For a list of possible macros see your affiliate panel at http://adgatemedia.com under the
 * Postbacks section and the heading Postback Information.
 *
 * Parsing:
 * From the data array you may parse the data into an object, supply it to an SQL query, or do
 * any needed processing or persisting required by your application.
 *
 */


/**
 * Inline SQL Query Example
 */
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->prepare("INSERT INTO Postbacks (tx_id, user_id, offer_id) VALUES (:tx_id,:user_id. :offer_id)");
    $conn->bindValue(':tx_id', $data['tx_id']);
    $conn->bindValue(':user_id', $data['user_id']);
    $conn->bindValue('offer_id', $data['offer_id']);
    // use exec() because no results are returned
    $conn->exec();
    echo "New Postback recorded successfully";
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;

/**
 * Processing Example
 * This example shows sending an notification to an admin when receiving a charge back of a conversion
 * being sent to the postback url.
 *
 * The example uses a Static Notify class, use your own notification class or one provided by your framework
 * of choice.
 */
if($data['status'] == 0)
{
    Notify::admin("Conversion charge back for offer " . $data['offer_id'] . " on transaction " . $data['tx_id'] . "!");
}
