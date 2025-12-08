<?php
// Simple JSON endpoint to fetch jobs from the database.
// Place this file in `docs/` and open via http://localhost/LOS_POL_H_PHP/docs/fetch_jobs.php

header('Content-Type: application/json; charset=utf-8');

// include DB config (this file exists in the same folder)
$cfg = __DIR__ . '/config.php';
if (!file_exists($cfg)) {
	http_response_code(500);
	echo json_encode(['error' => 'Database config not found']);
	exit;
}
require $cfg; // provides $conn (mysqli)

// Ensure $conn is available
if (!isset($conn) || !($conn instanceof mysqli)) {
	http_response_code(500);
	echo json_encode(['error' => 'Database connection not available']);
	exit;
}

$result = $conn->query("SELECT jobid, job_name, job_description, Responsibilities, req_skills, branch, position_filled FROM jobs ORDER BY jobid DESC");
if ($result === false) {
	// Query failed: maybe table name differs. Return helpful error message.
	http_response_code(500);
	echo json_encode(['error' => 'Query failed', 'details' => $conn->error]);
	exit;
}

$rows = [];
while ($r = $result->fetch_assoc()) {
	// normalize keys to lowercase and friendly names
	$rows[] = [
		'jobid' => isset($r['jobid']) ? (int)$r['jobid'] : null,
		'job_name' => $r['job_name'] ?? $r['job'] ?? null,
		'job_description' => $r['job_description'] ?? $r['description'] ?? null,
		'responsibilities' => $r['Responsibilities'] ?? $r['responsibilities'] ?? null,
		'req_skills' => $r['req_skills'] ?? null,
		'branch' => $r['branch'] ?? null,
		'position_filled' => isset($r['position_filled']) ? (int)$r['position_filled'] : null,
	];
}

echo json_encode(['data' => $rows], JSON_UNESCAPED_UNICODE);

$result->free();
$conn->close();

?>
