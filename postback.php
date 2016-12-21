<?php

/**
 * For a plain PHP page to receive the postback data from AdGate Media you may simply
 * retrieve the array from the global $_GET variable. To ensure that the data is coming
 * from AdGate Media check that the server sending the data is AdGate Media at 104.130.7.162.
 */
define('AdGate_IP', '104.130.7.162');
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
    throw new InvalidIPException();
}


/**
 * The data array will contain all the macros you included under the Postbacks section of your
 * affiliate panel at http://adgatemedia.com. The array is keyed by the names you assigned to each macro
 * when you constructed the url e.g., http://yoururl.com/postback/?tx_id={transaction_id}
 * the transaction_id macro's data will have a key of 'tx_id' in the $data array: $data['tx_id'];
 *
 * Possible Macros
 *   {offer_id} - ID of offer.
 *   {offer_name} - Name of offer, url encoded
 *   {affiliate_id} - ID of affiliate.
 *   {source} - Source value specified in the tracking link.
 *   {s1} - Affiliate sub specified in the tracking link.
 *   {s2} - Affiliate sub 2 specified in the tracking link.
 *   {s3} - Affiliate sub 3 specified in the tracking link.
 *   {s4} - Affiliate sub 4 specified in the tracking link.
 *   {s5} - Affiliate sub 5 specified in the tracking link.
 *   {transaction_id} - ID of click and conversion on the network.
 *   {session_ip} - User's IP address that started the tracking session.
 *   {date} - Current date of conversion formatted as YYYY-MM-DD.
 *   {time} - Current time of conversion formatted as HH:MM:SS.
 *   {datetime} - Current date and time of conversion formatted as YYYY-MM-DD HH:MM:SS.
 *   {ran} - Randomly generated number.
 *   {payout} - Amount paid to affiliate for conversion. In whole dollars: xx.xx
 *   {status} - 1 for approved conversion. 0 for charged back conversion.
 *   {points} - Decimal, number of points/credits the user earned on your website or game
 *   {vc_title} - Title of the campaign as it is displayed on the offer wall
 *
 * Parsing:
 * From the data array you may parse the data into an object, supply it to an SQL query, or do
 * any needed processing or persisting required by your application.
 *
 */

/**
 * Parse into an Object Example
 */
$postback = new Postback($data); // A simple data object could be a simple Collection object

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
    // $conn->exec();
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
 */
if($data['status'] == 0)
{
    Notify::admin("Conversion charge back for offer " . $data['offer_id'] . " on transaction " . $data['tx_id'] . "!");
}
