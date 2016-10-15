<?php
// fixed user set, not using user session value for demo
$user = "bob";
// database connection credentials file
// require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR.'dbconnect.php');
// error reporting
mysqli_report(MYSQLI_REPORT_OFF);
error_reporting(E_ALL);
error_reporting(-1);
ini_set('display_errors',true);
// check if widget has moved
$link = new mysqli("$servername", "$username", "$password", "$dbname");
$stmt = mysqli_prepare($link, "SELECT wmoved FROM users where name = ?");
$stmt->bind_param('s',$user);
if($stmt->execute()) {
  $stmt->bind_result($wmoved_from_db);
  if($stmt->fetch()) {
    if ($wmoved_from_db != "yes"){
      $yes   = "yes";
      $link  = new mysqli("$servername", "$username", "$password", "$dbname");
      $stmt2 = mysqli_prepare($link, "UPDATE users SET wmoved = ? WHERE name = ?");
      $stmt2->bind_param('ss',$yes,$user);
      $stmt2->execute();
    }
  }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  // get data
  $id        = $_POST['id'];
  $name      = $_POST['name'];
  $wname     = $_POST['wname'];
  $xcor      = $_POST['xcor'];
  $ycor      = $_POST['ycor'];
  $xwid      = $_POST['xwid'];
  $yhei      = $_POST['yhei'];
  $photo     = $_POST['photo'];
  $targeturl = $_POST['targeturl'];
  // checking to see if user has any widgets in widget table
  $link = new mysqli("$servername", "$username", "$password", "$dbname");
  $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM widgets where name = ?");
  $stmt->bind_param('s', $user);
  if ($stmt->execute()) {
    // bind result count
    $row = null;
    $stmt->bind_result($row);
    while ($stmt->fetch()) {
      if($row == 0) {
        // no widgets found
        // create new entry
        $link = new mysqli("$servername", "$username", "$password", "$dbname");
        $stmt = mysqli_prepare($link, "INSERT INTO widgets VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('issiiiiss',$id,$name,$wname,$xcor,$ycor,$xwid,$yhei,$photo,$targeturl);
        $stmt->execute();
      }
      else {
        // at least one widget found
        // update entry
        $link = new mysqli("$servername", "$username", "$password", "$dbname");
        $stmt = mysqli_prepare($link, "UPDATE widgets SET xcor = ?,ycor = ?,xwid = ?,yhei = ? WHERE name = ? and wname = ?");
	$stmt->bind_param('iiiiss',$xcor,$ycor,$xwid,$yhei,$user,$wname);
        $stmt->execute();
      }
    }
  }
}
?>
