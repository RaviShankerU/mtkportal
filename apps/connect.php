
<?php
$mysqli = new mysqli("localhost","root","Welcome@2019!","marketing_portal_v2");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}


$sql = "SELECT id, master_campaign_id, `URL`, title, description, start_date, end_date, created, status, class FROM campaign_calendar LIMIT 20;";


try{

    $result = $mysqli -> query($sql);
    $calendar = array();


while($rows = $result -> fetch_assoc()) {
// convert date to milliseconds
$start = strtotime($rows['start_date']) * 1000;
$end = strtotime($rows['end_date']) * 1000;

$calendar[] = array(
    'id' =>$rows['id'],
    'event_id' => $rows['master_campaign_id'],
    'title' => $rows['title'],
    'description' => $rows['description'],
    'url' => $rows['URL'],
    "class" => $rows['class'],
    'start' => "$start",
    'end' => "$end"
    );
}
}catch(Exception $e)
{
    echo '<pre>'; print_r($e); echo '</pre>';
}

$calendarData = array(
    "success" => 1,
    "result"=>$calendar);
    echo json_encode($calendarData);
    
?>