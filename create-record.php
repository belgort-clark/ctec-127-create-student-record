<?php
require "inc/functions.inc.php";
require "inc/db_connect.inc.php";
require "inc/header.inc.html";
?>
<div class="container">
	<div class="row mt-5">
		<div class="col-sm-12 col-md-6 col-lg-6">
			<a href="display-records.php">Display all Records</a>
			<div class="alert alert-info">
				<h1>Create a New Record</h1>
			</div>
			<?php

			$error_bucket = [];

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// First insure that all required fields are filled in
				if (empty($_POST["first"])) {
					array_push($error_bucket, "A first name is required.");
				} else {
					$first = $_POST["first"];
				}
				if (empty($_POST["last"])) {
					array_push($error_bucket, "A last name is required.");
				} else {
					$last = $_POST["last"];
				}
				if (empty($_POST["student_id"])) {
					array_push($error_bucket, "A student ID is required.");
				} else {
					$student_id = intval($_POST["student_id"]);
				}
				if (empty($_POST["email"])) {
					array_push($error_bucket, "An email address is required.");
				} else {
					$email = $_POST["email"];
				}
				if (empty($_POST["phone"])) {
					array_push($error_bucket, "A phone number is required.");
				} else {
					$phone = $_POST["phone"];
				}

				if (count($error_bucket) == 0) {
					// Time for some SQL
					$sql = "INSERT INTO STUDENT_V2 (first_name,last_name,email,phone,student_id) ";
					$sql .= "VALUES (:first,:last,:email,:phone,:student_id)";

					$stmt = $db->prepare($sql);
					$stmt->execute(["first" => $first, "last" => $last, "email" => $email, "phone" => $phone, "student_id" => $student_id]);

					if ($stmt->rowCount() == 0) {
						echo '<div class="alert alert-danger" role="alert">
						I am sorry, but I could not save that record for you.</div>';
					} else {
						header("Location: display-records.php?action=add");
					}
				} else {
					display_error_bucket($error_bucket);
				}
			}
			?>
			<?php
			require "inc/create.inc.php";
			?>
		</div>
	</div>
</div>
<?php
require "inc/footer.inc.html";
?>