
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MSC Software: Event Listing</title>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="shortcut icon" href="https://media.mscsoftware.com/cdn/farfuture/xOwsKcC3mIm-Iqfj4r7XWg7lk-9NwPglxVzI7ZhQNBQ/mtime:1567191942/favicon.ico" type="image/vnd.microsoft.icon" />
<link href="css/website_cards.css" rel="stylesheet">
</head>
<body class="">
<?php
$servername = "marketing-portal.cdbvvuxawpkp.eu-west-2.rds.amazonaws.com";
$username = "marketing_portal";
$password = "Welcome2019!";
$dbname = "marketing_portal_v2";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

$sql = "SELECT id, title, image, event_type, description, region, cta, website FROM live_website_listing";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
while( $record = mysqli_fetch_assoc($resultset) ) {
?>
<div class="container">
<div class="col-lg-4 col-sm-6">
	<div class="card hovercard">
	<div class="formBorder"></div>
		<div class="cardheader" style="background: url('<?php echo $record['image']; ?>');">">
			<div class="title-overlay">
                <h3><?php echo $record['title']; ?></h3>
                <p>Event Type: <?php echo $record['event_type']; ?></p>
                <a href="website_detail.php?eventid=<?php echo $record['id']; ?>" target="_blank" class="btn btn-lg btn-primary" style="width:100%;max-width:262.5px;text-align:left"><?php echo $record['cta']; ?></a>
			</div>
		</div>
		<div class="card-body info">
			<!--<div class="title">
				<a href="#"><?php echo $record['title']; ?></a>
			</div>
			<div class="desc"> <a target="_blank" href="<?php echo $record['website']; ?>"><?php echo $record['website']; ?></a></div>-->
			<?php 
			$string = $record['description'];
			if (strlen($string) > 250) {
			$trimstring = substr($string, 0, 250). ' <a href="website_detail.php?eventid=' . $record['id'] . '">Read more...</a>';
			} else {
			$trimstring = $string;
			}
			//echo $trimstring;
			?>
			<div class="desc" style="text-align:left;"><?php echo $trimstring ?></div>
			<div class="desc"><?php echo $record['address']; ?></div>
			<!--<div class="desc">
				<a href="http://pages.mscsoftware.com/Products-Quote.html" target="_blank" class="btn btn-lg btn-primary" style="width:100%;max-width:262.5px;text-align:left"><?php echo $record['cta']; ?></a>
			</div>-->
		</div>
		<div class="card-footer bottom" style="display:none;">
			<a class="btn btn-primary btn-twitter btn-sm" href="<?php echo $record['twitter']; ?>">
			<i class="fa fa-twitter"></i>
			</a>
			<a class="btn btn-danger btn-sm" rel="publisher"
				href="<?php echo $record['gplus']; ?>">
			<i class="fa fa-google-plus"></i>
			</a>
			<a class="btn btn-primary btn-sm" rel="publisher"
				href="<?php echo $record['facebook']; ?>">
			<i class="fa fa-facebook"></i>
			</a>
		</div>
	</div>
</div>

<?php } ?>
		</div>
</body>
</html>

