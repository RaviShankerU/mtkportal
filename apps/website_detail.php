<?php
$servername = "marketing-portal.cdbvvuxawpkp.eu-west-2.rds.amazonaws.com";
$username = "marketing_portal";
$password = "Welcome2019!";
$dbname = "marketing_portal_v2";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

if (isset($_GET['eventid'])) {
    //echo $_GET['eventid'];
    $eventid = $_GET['eventid'];

}

$sql = "SELECT id, title, image, event_type, description, region, cta, title_seo, website, start_date, end_date FROM live_website_listing WHERE id=  '" . $eventid . "'";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
while( $record = mysqli_fetch_assoc($resultset) ) {
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0, shrink-to-fit=yes">
  <title><?php echo $record['title']; ?></title> 
  <meta name="author" content="<?php echo $record['title_seo']; ?>" />
  <meta name="description" content="<?php echo $record['description']; ?>" />
  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="shortcut icon" href="https://media.mscsoftware.com/cdn/farfuture/xOwsKcC3mIm-Iqfj4r7XWg7lk-9NwPglxVzI7ZhQNBQ/mtime:1567191942/favicon.ico" type="image/vnd.microsoft.icon" />
  <link href="css/website_cards.css" rel="stylesheet">
</head>
<body>


<header class="container">
	<div class="row">
		<figure class="text-center">
			<img src="<?php echo $record['image']; ?>" alt="" class="" />
		</figure>
	</div>
	<div class="row">
		<div class="col-md-10 col-md-offset-0">
			<h1><?php echo $record['title']; ?></h1>
			
		</div>
	</div>
</header>
<div class="container">
<div class="row">
	<div class="col-xs-12 col-md-7 col-md-offset-0">
		<p class="lead"><?php echo $record['description']; ?></p>
		<p>
			<strong>When is the <?php echo $record['event_type']; ?></strong> <?php echo $record['start_date']; ?> until <?php echo $record['end_date']; ?>.
		</p>
				
	</div>
	<div class="col-xs-12 col-md-4">
	<div class="rightContent Right-col-frm pr-0 pl-0 pt-0">
		<div class="formBorder"></div>
		<div class="col-md-offset-1">Form goes here</div>
	</div>
	<hr />
	<div class="row" style="padding-top:20px;">
		<figure class="col-md-2 col-md-offset-1">
			<img src="http://placehold.it/100x100" alt="Jonathan F. Doe" class="img-responsive img-circle pull-right" />
		</figure>
		<blockquote class="col-md-7">
			<p>
				Testimonials are important. Be sure to include some in your sales page.
			</p>
			<p>
				With Product, my sales page was <strong>online in minutes</strong>. And it rocks!.
			</p>
			<small>Jonathan F. Doe, CIO at Lorem Ipsum</small>
		</blockquote>
	</div>
</div>

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<?php } ?>