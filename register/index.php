<?php
	$error = '';
	function createCSV($data){
		$rows = '';
		$row1 = [];
		foreach ($data[0] as $key => $value){
			array_push($row1, '"' . $key . '"');
		}
		$rows .= implode(',', $row1) . "\n";
		foreach ($data as $dataRow){
			$row = [];
			foreach ($dataRow as $value){
				array_push($row, '"' . $value . '"');
			}
			$rows .= implode(',', $row) . "\n";
		}
		file_put_contents('./registrations.csv', $rows);
	}
	if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['school']) && isset($_POST['grade'])
			&& isset($_POST['experience']) && isset($_POST['food']) && isset($_POST['shirt'])) {
		$data = json_decode(file_get_contents('./data.json'), true);
		$registrant = array(
			'name' => $_POST['fullname'],
			'email' => $_POST['email'],
			'school' => $_POST['school'],
			'grade' => $_POST['grade'],
			'experience' => $_POST['experience'],
			'food' => $_POST['food'],
			'shirt' => $_POST['shirt']
		);
		if ($registrant['grade'] == '7' || $registrant['grade'] == '8'){
			$middle_schoolers = 0;
			foreach ($data as $value){
				if ($value['grade'] == '7' || $value['grade'] == '8') $middle_schoolers++;
			}
			if ($middle_schoolers >= 30){
				$error = 'Sorry, we have already reached the maximum amount of middle schoolers we can accomodate.';
			} else {
				array_push($data, $registrant);
				file_put_contents('./data.json', json_encode($data));
				createCSV($data);
				header('Location: ./registered.php');
			}
		} else {
			array_push($data, $registrant);
			file_put_contents('./data.json', json_encode($data));
			createCSV($data);
			header('Location: ./registered.php');
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link href="inputs.css" rel="stylesheet">
	<title>Register | hackWHRHS</title>
	<script src="../js/jquery-1.11.2.min.js"></script>
	<script src="inputs.js"></script>
</head>
<body class="body">
	<form action="" method="post">
		<div class= "header">
			<a href="/">
				<img alt="Logo" class="img-responsive center-block" src="Logo_(1088x256).png">
			</a>
			<h1>Registration</h1>
		</div>
		<?php
			if (strlen($error) > 0){
				echo '<p style="color: red;">' . $error . '</p>';
			}
		?>
		<div class="group">
			<input type="text" id="fullname" name="fullname" required="required" />
			<label for="fullname">Full name</label>
			<div class="bar"></div>
		</div>
		<div class="group">
			<input type="text" id="email" name="email" required="required" />
			<label for="email">Your email</label>
			<div class="bar"></div>
			(Don't worry. We won't spam you.)
		</div>
		<div class="group">
			<input type="text" id="school" name="school" required="required" />
			<label for="school">Your school</label>
			<div class="bar"></div>
		</div>
		<div class="groupD">
			<select id="grade" name="grade">
				<option selected value="hide">Your current grade</option>
				<option value="7">Grade 7</option>
				<option value="8">Grade 8</option>
				<option value="9">Grade 9</option>
				<option value="10">Grade 10</option>
				<option value="11">Grade 11</option>
				<option value="12">Grade 12</option>
			</select>
		</div>

		<div class="groupD">
			<select id="experience" name="experience">
				<option selected value="hide">Your programming experience</option>
				<option value="none">None</option>
				<option value="beginner">Beginner</option>
				<option value="experienced">Experienced</option>
			</select>
		</div>
		<div class="groupD">
			<select id="food" name="food">
				<option selected value="hide">Your food preferences</option>
				<option value="none">None</option>
				<option value="vegetarian">Vegetarian</option>
			</select>
		</div>
		<div class="groupD">
			<select id="shirt" name="shirt">
				<option selected value="hide">Your shirt size</option>
				<option value="S">Small</option>
				<option value="M">Medium</option>
				<option value="L">Large</option>
				<option value="XL">X-Large</option>
			</select>
		</div>
		<div style="text-align:center;">
			<input type="submit" class="button" value="Continue" />
		</div>
	</form>
</body>
</html>