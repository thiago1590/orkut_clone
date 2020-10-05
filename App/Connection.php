<?php

namespace App;

class Connection {

	public static function getDb() {
		try {

			$conn = new \PDO(
				"mysql:host=sql300.epizy.com;dbname=epiz_26861800_orkut;charset=utf8",
				"epiz_26861800",
				"JfLYTCzBwl4mc"
			);

			return $conn;

		} catch (\PDOException $e) {
			//.. tratar de alguma forma ..//
		}
	}
}

?>