<?php
class User {
	private $user;
	private $con;

	public function __construct($con, $user){
		$this->con = $con;
		$user_details_query = mysqli_query($con, "SELECT * FROM register_user WHERE user_name='$user'");
		$this->user = mysqli_fetch_array($user_details_query);
	}

	public function getUsername() {
		return $this->user['user_name'];
	}

	public function getFirstAndLastName() {
		$username = $this->user['user_name'];
		$query = mysqli_query($this->con, "SELECT first_name, last_name FROM register_user WHERE user_name='$username'");
		$row = mysqli_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'];
	}


}

?>
