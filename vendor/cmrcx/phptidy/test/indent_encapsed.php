<?

$query = "SELECT * FROM $table
	WHERE $column=".intval($value1)."
		AND id=".intval($value2);
