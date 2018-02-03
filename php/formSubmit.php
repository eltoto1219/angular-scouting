<?php
include("connect.php");
include("functions.php");
header('Content-Type: application/json');
$postData = json_decode(file_get_contents("php://input"), true);
$query = "INSERT INTO form_data (
			auto_check,
			auto_defend,
			auto_scale,
			auto_speed,
			bar_climb,
			comment,
			cube_ranking,
			enemy_switch_cubes,
			help_climb,
			match_number,
			other_climb,
			ramp_climb,
			scale_cubes,
			score,
			switch_cubes,
			team_number,
			tele_check,
			tele_defense,
			tele_speed)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$autoCheck = isset($postData['autoCheck']) ? intval($postData['autoCheck']) : '';
$autoDefend = isset($postData['autoDefend']) ? intval($postData['autoDefend']) : '';
$autoScale = isset($postData['autoScale']) ? intval($postData['autoScale']) : '';
$autoSpeed = isset($postData['autoSpeed']) ? $postData['autoSpeed'] : '';
$barClimb = isset($postData['barClimb']) ? intval($postData['barClimb']) : '';
$comment = isset($postData['comment']) ? strip_tags($postData['comment']) : '';
$cubeRanking = isset($postData['cubeRanking']) ? $postData['cubeRanking'] : '';
$enemySwitchCubes = isset($postData['enemySwitchCubes']) ? $postData['enemySwitchCubes'] : '';
$helpClimb = isset($postData['helpClimb']) ? intval($postData['helpClimb']) : '';
$matchNumber = isset($postData['matchNumber']) ? $postData['matchNumber'] : '';
$otherClimb = isset($postData['otherClimb']) ? strip_tags($postData['otherClimb']) : '';
$rampClimb = isset($postData['rampClimb']) ? intval($postData['rampClimb']) : '';
$scaleCubes = isset($postData['scaleCubes']) ? $postData['scaleCubes'] : '';
$score = isset($postData['score']) ? $postData['score'] : '';
$switchCubes = isset($postData['switchCubes']) ? $postData['switchCubes'] : '';
$teamNumber = isset($postData['teamNumber']) ? $postData['teamNumber'] : '';
$teleCheck = isset($postData['teleCheck']) ? intval($postData['teleCheck']) : '';
$teleDefense = isset($postData['teleDefense']) ? intval($postData['teleDefense']) : '';
$teleSpeed = isset($postData['teleSpeed']) ? $postData['teleSpeed'] : '';

if($stmt = $db->prepare($query)) {
	$stmt->bind_param("iiiiisiiiisiiiiiiii",
		$autoCheck,
		$autoDefend,
		$autoScale,
		$autoSpeed,
		$barClimb,
		$comment,
		$cubeRanking,
		$enemySwitchCubes,
		$helpClimb,
		$matchNumber,
		$otherClimb,
		$rampClimb,
		$scaleCubes,
		$score,
		$switchCubes,
		$teamNumber,
		$teleCheck,
		$teleDefense,
		$teleSpeed
	);
    $stmt->execute();
    if ($stmt->error) {
        header('HTTP/1.1 500 SQL Error', true, 500);
        $db->close();
	    die('{"message":"'.$stmt->error.'"}');
    }
	$insert_id = $stmt->insert_id;
} else {
    header('HTTP/1.1 500 SQL Error', true, 500);
    $db->close();
	die ( '{"message":"Failed creating statement"}' );
}

$db->close();
?>
