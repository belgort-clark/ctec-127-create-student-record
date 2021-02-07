<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<title>Create Record Demo</title>
</head>

<body>
	<div class="container">
		<div class="row mt-5">
			<div class="col-sm-12 col-md-6 col-lg-6">
				<div class="alert alert-info">
					<h1>Create a New Record</h1>
				</div>
				<?php
				function display_error_bucket($error_bucket)
				{
					echo '<div class="pt-4 alert alert-warning" role="alert">';
					echo '<p>The following errors were detected:</p>';
					echo '<ul>';
					foreach ($error_bucket as $text) {
						echo '<li>' . $text . '</li>';
					}
					echo '</ul>';
					echo '</div>';
					echo '<p>All of these fields are required. Please fill them in.</p>';
				}

				$error_bucket = [];

				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					// First insure that all required fields are filled in
					if (empty($_POST["first"])) {
						array_push($error_bucket, "<p>A first name is required.</p>");
					} else {
						$first = $_POST["first"];
					}
					if (empty($_POST["last"])) {
						array_push($error_bucket, "<p>A last name is required.</p>");
					} else {
						$last = $_POST["last"];
					}
					if (empty($_POST["student_id"])) {
						array_push($error_bucket, "<p>A student ID is required.</p>");
					} else {
						$student_id = intval($_POST["student_id"]);
					}
					if (empty($_POST["email"])) {
						array_push($error_bucket, "<p>An email address is required.</p>");
					} else {
						$email = $_POST["email"];
					}
					if (empty($_POST["phone"])) {
						array_push($error_bucket, "<p>A phone number is required.</p>");
					} else {
						$phone = $_POST["phone"];
					}

					// If we have no errors than we can try and insert the data
					$host = 'localhost';
					$user = 'root';
					$password = '';
					$dbname = 'ctec';

					// DSN - Data Source Name
					$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

					// Create a PDO Instance
					$db = new PDO($dsn, $user, $password);
					// Set PDO default data type to be returned
					$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

					if (count($error_bucket) == 0) {
						// Time for some SQL
						$sql = "INSERT INTO STUDENT (first_name,last_name,email,phone,student_id) ";
						$sql .= "VALUES (:first,:last,:email,:phone,:student_id)";

						$stmt = $db->prepare($sql);
						$stmt->execute(["first" => $first, "last" => $last, "email" => $email, "phone" => $phone, "student_id" => $student_id]);

						if ($stmt->rowCount() == 0) {
							echo '<div class="alert alert-danger" role="alert">
						I am sorry, but I could not save that record for you.</div>';
						} else {
							header("Location: create-record.php");
						}
					} else {
						display_error_bucket($error_bucket);
					}
				}
				?>

				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
					<label class="col-form-label" for="first">First Name</label>
					<input class="form-control" type="text" id="first" name="first" value="<?= isset($first) ? $first : null ?>">
					<br>
					<label class="col-form-label" for="last">Last Name</label>
					<input class="form-control" type="text" id="last" name="last" value="<?= isset($last) ? $last : null ?>">
					<br>
					<label class=" col-form-label" for="id">Student ID </label>
					<input class="form-control" type="number" id="id" name="student_id" value="<?= isset($student_id) ? $student_id : null ?>">
					<br>
					<label class=" col-form-label" for="email">Email</label>
					<input class="form-control" type="text" id="email" name="email" value="<?= isset($email) ? $email : null ?>">
					<br>
					<label class=" col-form-label" for="phone">Phone</label>
					<input class="form-control" type="text" id="phone" name="phone" value="<?= isset($phone) ? $phone : null ?>">
					<br>
					<br>
					<a href="create-record.php" title="Cancel">Cancel</a>
					&nbsp;&nbsp;
					<button class="btn btn-primary" type="submit">Save Record</button>
				</form>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<p class="text-center mt-4">Create Record Demo Page</p>
			</div>
		</div>
	</div>
</body>

</html>