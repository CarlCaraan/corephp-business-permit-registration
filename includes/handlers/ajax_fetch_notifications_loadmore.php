<?php
if(isset($_POST["view"])){

	$conn = mysqli_connect("localhost", "root", "", "business");
	if($_POST["view"] != ''){
		mysqli_query($conn,"update `notifications` set seen_status='1' where seen_status='0'");
	}
	
	$query=mysqli_query($conn,"select * from `notifications` order by id desc limit 99");
	$output = '';

	if(mysqli_num_rows($query) > 0){
		while($row = mysqli_fetch_array($query)){

			// ========= Start Timeframe =========
			$date_time_now = date("Y-m-d H:i:s");
			$start_date = new DateTime($row['timestamp']); //Time of post
			$end_date = new DateTime($date_time_now); //Current Time
			$interval = $start_date->diff($end_date); //Difference between dates
			if($interval->y >= 1) {
				if($interval == 1)
					$time_message = $interval->y . " year ago"; //prints "1 year ago"
				else
					$time_message = $interval->y . " years ago"; //prints "1+ year ago"
			}
			else if ($interval->m >= 1) {
				if($interval->d == 0){
					$days = " ago";
				}
				else if($interval->d == 1){
					$days = $interval->d . " day ago";
				}
				else {
					$days = $interval->d . " days ago";
				}


				if($interval->m == 1) {
					$time_message = $interval->m . " month" . $days;
				}
				else {
					$time_message = $interval->m . " months" . $days;
				}

			}
			else if($interval->d >= 1) {
				if($interval->d == 1) {
					$time_message = "Yesterday";
				}
				else {
					$time_message = $interval->d . " days ago";
				}
			}
			else if ($interval->h >= 1) {
				if($interval->h == 1) {
					$time_message = $interval->h . " hour ago";
				}
				else {
					$time_message = $interval->h . " hours ago";
				}
			}
			else if ($interval->i >= 1) {
				if($interval->i == 1) {
					$time_message = $interval->i . " minute ago";
				}
				else {
					$time_message = $interval->i . " minutes ago";
				}
			}
			else {
				if($interval->s < 30) {
					$time_message = "Just now";
				}
				else {
					$time_message = $interval->s . " seconds ago";
				}
			}
			// ========= End Timeframe =========

			$output .= '
			<li class="p-3" id="notification_li">
				<a id="notification_link" href="adminrecords.php">
					<span style="width:300px;display:inline-block;">
						<strong id="notification_name">'.$row['name']. '</strong>
						' . $row['content'] . '
					</span>
					<br>
					<small class="text-muted">' . $time_message . '</small>
				</a>
			</li>
			';
		}
	}
	else{
	$output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
	}
	
	$query1=mysqli_query($conn,"select * from `notifications` where seen_status='0'");
	$count = mysqli_num_rows($query1);
	$data = array(
		'notification'   => $output,
		'unseen_notification' => $count
	);
	echo json_encode($data);
}
?>