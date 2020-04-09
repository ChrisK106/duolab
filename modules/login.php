<?php

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

	require '../global/connection.php';

	$username = $_POST['txtUsername'];
	$password = $_POST['txtPassword'];

	$sqlStatement = $pdo->prepare("SELECT u.id AS USERID, u.username AS USERNAME,
		u.password AS PASS, u.photo_url AS PHOTO_URL, e.job AS JOB,
		CONCAT(e.name, ' ', e.last_name_1) AS EMPLOYEE_NAME
		FROM tbl_user u JOIN tbl_employee e ON u.employee_id=e.id
		WHERE u.username=:username");

	$sqlStatement->bindParam("username",$username,PDO::PARAM_STR);
	$sqlStatement->execute();

	$rowsNumber=$sqlStatement->rowCount();

	if ($rowsNumber==1) {

		$sqlData=$sqlStatement->fetch(PDO::FETCH_ASSOC);

		if (password_verify($password, $sqlData['PASS'])) {

			$sqlData['PASS'] = "";

			if ($sqlData['PHOTO_URL'] == ""){
				$sqlData['PHOTO_URL'] = "default-avatar.png";
			}

			session_start();
			$_SESSION['loggedInUser']=$sqlData;

			echo json_encode(array('error' => false));
		
		} else {
			echo json_encode(array('error' => true));
		}

	} else {
		echo json_encode(array('error' => true));
	}
}

?>