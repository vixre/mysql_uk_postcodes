<?php
    $db_server = 'server';
    $db_user   = 'user';
    $db_pass   = 'pass';
    $db_name   = 'postcodes';
    $table_name = 'postcodelatlng';

    $file_path = $argv[1];
    $echo = ($argv[2] == 'echo' ? true : false);

    // Skip database connection if user only wants echo queries.
    if (!$echo) {
        $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            trigger_error('Database connection failed: ' . $conn->connect_error, E_USER_ERROR);
        }
    }

	function create_insert_query($line, $db_name, $table_name) {
		$line_array = explode(',', $line);
		if ($line_array[0] != 'id') {
			$query = "insert into `$db_name`.`$table_name` (`id`, `postcode`, `latitude`, `longitude`) values ('$line_array[0]', '$line_array[1]', '$line_array[2]', '$line_array[3]');";
			return $query;
		}
	}

    $table_creation_query = "CREATE TABLE `$table_name` (`id` int(11) NOT NULL, `postcode` varchar(11) NOT NULL, `latitude` float NOT NULL, `longitude` float NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `postcode` (`postcode`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    if ($echo) {
        echo $table_creation_query;
    } else {
        $conn->query($table_creation_query);
    }
	$handle = fopen($file_path, "r");

	if ($handle) {
		while (($line = fgets($handle)) !== false) {
            $query = create_insert_query($line, $db_name, $table_name);
            if ($echo) {
                echo $query;
            } else {
                $conn->query($query);
            }
		}
	} else {
		echo "Error reading file.";
	}

	fclose($handle);
?>
