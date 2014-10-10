<?php

	include "cred_int.php";
	include "SQL_Statement.php";

	try{
		$db = new PDO("mysql:dbname=".DB_APP_DATABASE.";host=".DB_HOST, DB_USERNAME, DB_PASSWORD);
		$applicationSql=$db->prepare(AdminTableSQL());
		$applicationSql->execute();
		$result = $applicationSql->fetchAll(PDO::FETCH_ASSOC);
		$header = true;
		echo "<table border='1'>";
		if(empty($result)){
			throw new Exception("<p>No applications in database.</p>");
		}
		foreach ($result as $row) {
			if($header){
				echo "<tr>";
				$ColumnFields = array_unique(array_keys($row));
				foreach($ColumnFields as $field){
					echo "<th>".$field."</th>";
				}
				echo "</tr>";
				$header = false;
			}
			echo "<tr>";
			$ValueField = $row;
			foreach($ValueField as $Column => $Value){
				if($Column == 'is_complete'){
					if($Value){
						echo "<td>Complete</td>";
					} else {
						echo "<td>Incomplete</td>";
					}
				} else {
					echo "<td>".$Value."</td>";
				}
			}
		}
	} catch(PDOException $e){
		echo "Connection Failed:  ".$e->getMessage();
	} catch (Exception $e){
		echo $e->getMessage();
	} finally {
		$db = null;
	}
?>