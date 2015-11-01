<?php
// for this demo a fixed name has been set rather than a session value
$user = "bob";

// error reporting
mysqli_report(MYSQLI_REPORT_OFF);
error_reporting(E_ALL);
error_reporting(-1);
ini_set('display_errors',true);

$link = new mysqli("$servername", "$username", "$password", "$dbname");

// initial message for new account

$stmt =mysqli_prepare($link, "SELECT wmoved FROM users where name = ?");
$stmt->bind_param('s',$user);

if($stmt->execute())
{
    $stmt->bind_result($wmoved_from_db);
    if($stmt->fetch())
    {
       $moved = $wmoved_from_db;
       if($moved!="yes"){
       $message = "This is your page, once modified this message will change.";
       // set initial position of stock widget
       $initial_x_coordinate = "150px";
       $initial_y_coordinate = "150px";
       }else{
       $message = "";

// position widgets 

$link = new mysqli("$servername", "$username", "$password", "$dbname");

$wname = "stock";

$stmt = mysqli_prepare($link, "SELECT xcor,ycor,xwid,yhei FROM widgets where name = ? and wname = ?");
$stmt->bind_param('ss', $user,$wname);

 if($stmt->execute()){
 
 $stmt->bind_result($xcor_from_db,$ycor_from_db,$xwid_from_db,$yhei_from_db);
    if($stmt->fetch())
    {
    $xcor = $xcor_from_db."px";
    $ycor = $ycor_from_db."px";
    $xwid = $xwid_from_db."px";
    $yhei = $yhei_from_db."px";
    $initial_x_coordinate = $xcor;
    $initial_y_coordinate = $ycor;
    }else{
    $xcor = "";
    $ycor = "";
    $xwid = "";
    $yhei = "";
    }
 }
       }
    }
}
?>
<!DOCTYPE HTML>
<!-- declaring character encoding -->
<meta charset="utf-8">
<head>
<!-- This is the small icon displayed in browser tabs -->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" width="16" height="16"> 
<!-- meta tags -->
<title></title>
<meta name="Description" CONTENT=""> 
<meta name="author" content="Jacob David C. Cunningham" >
<!-- google meta tags -->
<link rel="" href=""/>
<link rel=""? href=""/>
<!-- open graph meta tags -->
<meta property="og:title" content=""/>
<meta property="og:type" content=""/>
<meta property="og:image" content=""/>
<meta property="og:url" content=""/>
<meta property="og:description" content=""/>
<!-- Twitter meta tags -->
<meta name="twitter:card" content=""/>
<meta name="twitter:url" content=""/>
<meta name="twitter:title" content="">
<meta name="twitter:description" content=""/>
<meta name="twitter:image" content=""/>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
<!-- <script type="text/javascript" src="/touch_punch/jquery.ui.mouse.js"></script> -->
<!-- <script type="text/javascript" src="/touch_punch/jquery.ui.touch-punch.min.js"></script> -->
<!-- <script type="text/javascript" src="/touch_punch/jquery.ui.touch-punch.min.development.js"></script> -->
<style>
.words {
font-size: 200%;
color: #303030;
}
.text {
font-size: 150%;
color: #303030;
z-index: 2;
}
.snap-grid {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
}
.user-icon {
width: <?php echo $xwid; ?>;
height: <?php echo $yhei; ?>;
border-radius: 12px;
box-shadow: 3px 3px 3px 3px #303;
position: absolute; 
top: <?php echo $initial_y_coordinate; ?>;
left: <?php echo $initial_x_coordinate; ?>;
cursor: pointer;
min-width: 150px;
min-height: 150px;
background-image: url();
background-size: 100px 100px;
background-repeat: none;
}
#user-icon {
display: none;
}
.photo {
border-radius: 12px;
}
.usertext {
font-size: 150%;
color: #ff8400;
margin-top: 25%;
}
.tap {
font-size: 130%;
color: #303030;
}
.gear-icon {
width: 100px;
height: 100px;
border-radius: 12px;
box-shadow: 3px 3px 3px 3px #303;
position: absolute; 
top: ;
left: ;
display: none;
border-radius: 12px;
background-color: #ff8400;
}
.photo-offset {
margin-left: 10%;
margin-top: 10%;
float: left;
}
.binoculars-icon {
width: 100px;
height: 100px;
border-radius: 12px;
box-shadow: 3px 3px 3px 3px #303;
position: absolute; 
top: ;
left: ;
display: none;
border-radius: 12px;
}
</style>
</head>
<body>
<div class="text" id="startmessage" align="center">
<p class="words">
<?php echo $message; ?>
</p>
</div>
<div class="snap-grid" id="snap-grid" align="center">
<div class="user-icon" id="user_icon" onclick="check();" align="center">
<p class="usertext" align="center"><?php echo $user; ?></p>
<p class="tap" id="sub" align="center">( drag me )</p>
</div>
</div>
<div class="gear-icon" id="settings" align="center">
<img src="gear.png" class="photo-offset" width="80%" height="auto">
</div>
<div class="binoculars-icon" id="find" align="center">
<img src="binoculars.png" width="100%" height="auto">
</div>
<form id="form" method="POST" name="position" action="update_coordinate.php">
<input type="hidden" name="id" id="id" value="">
<input type="hidden" name="name" id="name"  value="<?php echo $user; ?>">
<input type="hidden" name="wname" id="wname"  value="stock">
<input type="hidden" name="xcor" id="xcor" value="">
<input type="hidden" name="ycor" id="ycor" value="">
<input type="hidden" name="xwid" id="xwid" value="">
<input type="hidden" name="yhei" id="yhei" value="">
<input type="hidden" name="photo" id="photo" value="none">
<input type="hidden" name="targeturl" id="targeturl" value="none">
</form>
<script>
$('#user_icon').draggable({
cursor: 'move',
containment: '#snap-grid',
start: mod,
stop: coordinateEcho
});
function echo(){
var div = $("#user_icon");
var position = div.position();
var xcor = position.left;
var ycor = position.top;
var xwid = document.getElementById('user_icon').clientWidth;
var yhei = document.getElementById('user_icon').clientHeight;
$("#id").val();
$("#xcor").val(xcor);
$("#ycor").val(ycor);
$("#xwid").val(xwid);
$("#yhei").val(yhei);

var $id = $('#id').val();
var $name = $('#name').val();
var $wname = $('#wname').val();
var $xcor = $('#xcor').val();
var $ycor = $('#ycor').val();
var $xwid = $('#xwid').val();
var $yhei = $('#yhei').val();
var $photo = $('#photo').val();
var $targeturl = $('#targeturl').val();
$.post( "update_coordinate.php", {
'id':$id,
    'name':$name,
    'wname':$wname,
    'xcor':$xcor,
    'ycor':$ycor,
    'xwid':$xwid,
    'yhei':$yhei,
    'photo':$photo,
    'targeturl':$targeturl
    }).done(function( data ) {
    //alert( "Server Response: " + data );
    });
}
function mod( event, ui){   
$( "#startmessage" ).find("p").html("");
$( "#user_icon" ).find("#sub").html("( tap me )");
}
function coordinateEcho( event, ui ){
echo();
}
function check() {
var x = screen.width;
var y = screen.height;
var c = x*0.5;
var d = y*0.5;
var div = $("#user_icon");
var position = div.position();
var xcor = position.left;
var ycor = position.top;
var xwid = document.getElementById('user_icon').clientWidth;
var yhei = document.getElementById('user_icon').clientHeight;
// condition 1
function complete(){
$("#settings").css("left", 0);
$("#settings").css("top", 0);
$("#find").css("left", 0);
$("#find").css("top", 0);
}
function show(){
document.getElementById('settings').style.display = "block";
document.getElementById('find').style.display = "block";
}
function hide(){
document.getElementById('settings').style.display = "none";
document.getElementById('find').style.display = "none";
}
if (xcor < c && ycor < d){
var gearOffSetX = xcor;
var nXCSettings = gearOffSetX + xwid + 25; 
var nYCSettings = ycor; 
var nXCFind = nXCSettings + 125;
var nYCFind = nYCSettings;
$("#settings").css("left", nXCSettings);
$("#settings").css("top", nYCSettings);
$("#find").css("left", nXCFind);
$("#find").css("top", nYCFind);
$("#settings").show().delay( 3000 ).fadeOut( "slow" );
$("#find").show().delay( 3000 ).fadeOut( "slow", complete );
}
// condition 2
if (xcor > c && ycor < d){
var gearOffSetX = xcor;
var nXCSettings = gearOffSetX - xwid + 25; 
var nYCSettings = ycor; 
var nXCFind = nXCSettings - 125;
var nYCFind = nYCSettings;
$("#settings").css("left", nXCFind);
$("#settings").css("top", nYCSettings);
$("#find").css("left", nXCSettings);
$("#find").css("top", nYCFind);
$("#settings").show().delay( 3000 ).fadeOut( "slow" );
$("#find").show().delay( 3000 ).fadeOut( "slow", complete );
}
if (xcor < c && ycor > d){
var gearOffSetX = xcor;
var nXCSettings = gearOffSetX + xwid + 25; 
var nYCSettings = ycor; 
var nXCFind = nXCSettings + 125;
var nYCFind = nYCSettings;
$("#settings").css("left", nXCSettings);
$("#settings").css("top", nYCSettings);
$("#find").css("left", nXCFind);
$("#find").css("top", nYCFind);
$("#settings").show().delay( 3000 ).fadeOut( "slow" );
$("#find").show().delay( 3000 ).fadeOut( "slow", complete );
}
if (xcor > c && ycor > d){
var gearOffSetX = xcor;
var nXCSettings = gearOffSetX - xwid +25; 
var nYCSettings = ycor; 
var nXCFind = nXCSettings - 125;
var nYCFind = nYCSettings;
$("#settings").css("left", nXCFind);
$("#settings").css("top", nYCSettings);
$("#find").css("left", nXCSettings);
$("#find").css("top", nYCFind);
$("#settings").show().delay( 3000 ).fadeOut( "slow" );
$("#find").show().delay( 3000 ).fadeOut( "slow", complete );
}
}
</script>
</body>
