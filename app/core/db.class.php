<?php 

namespace App\Core;

class DB {
	public $CONNECT = '';

	public function __construct() {
		$this->CONNECT = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if( !$this->CONNECT ) { 
			output(array(
				'status' => 'error',
				'message' => 'Ошибка подключения к базе данных'
			));
		}

		if( mysqli_connect_errno() ) { 
			output(array(
				'status' => 'error',
				'message' => 'Ошибка подключения к базе данных'
			));
		}

		if (!mysqli_set_charset($this->CONNECT, "utf8mb4")) {
			output(array(
				'status' => 'error',
				'message' => 'Ошибка подключения к базе данных'
			));
		} 
	}

	public function __destruct() {
		mysqli_close($this->CONNECT);
	}

	/**
	 * Data Base Query
	 * 
	 * @param string $query	(require)          - SQL query
	 * 
	 */
	public function query($query) {
		return mysqli_query($this->CONNECT, $query);
	}

	/**
	 * Get Table Infomation
	 * @param string $table	(required)      - Table Name 
	 * @param array $fields                 - Table Fields 
	 *                                        ['*'] or ['name', 'password', 'alala'] or ['curent_id', '(SELECT name FROM table WHERE table_id = curent_id) as name']
	 * @param string $where                 - Table Where Params
	 *                                        "id <> 1 AND name <> 'test'"
	 * @param array $orderBy                - Order By Result
	 *                                        ['date_created', 'DESC']
	 * @param int $limit                    - Limit Results
	 * @param int $offset                   - Offset Results
	 * 
	 */
	public function get($table, $fields = array('*'), $where = false, $orderBy = false, $limit = false, $offset = false) {
		$fields = is_array($fields) ? implode(', ', $fields) : $fields;
		$query = 'SELECT ' . $fields . ' FROM ' . $table;
		if ( $where ) { $query .= ' WHERE ' . $where; }
		if ( $orderBy ) { $query .= ' ORDER BY ' . $orderBy[0] . ' ' . $orderBy[1]; }		
		if ( $limit ) { $query .= ' LIMIT ' . $limit; }
		if ( $offset ) { $query .= ' OFFSET ' . $offset; }
		$items = $this->query($query);
		$result = array();
		while( $row = mysqli_fetch_assoc($items) )
		{
			array_push($result, $row);
		}
		return $result;
	}

	/**
	 * Data Base Insert Query
	 * 
	 * @param string   $table  (required)      - Table Name
	 * @param array    $data   (required)      - Table Fields And Data
	 *                                           [ ['name1', 'data1'], ['name2', 'data2'], ['name3', 'data3'] ... ]
	 * 
	 */
	public function insert($table, $data) {
		$fields = array();
		$values = array();
		foreach ( $data as $d ) {
			array_push($fields, $d[0]);
			array_push($values, (gettype($d[1]) == 'integer' || gettype($d[1]) == 'double') ? $d[1] : '\'' . $d[1] . '\'');
		}
		$query = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
		return mysqli_query($this->CONNECT, $query);
	}

	/**
	 * Data Base Update Query
	 * 
	 * @param string   $table  (required)      - Table Name
	 * @param string   $where  (required)      - Table Where Params
	 *                                           "id <> 1 AND name <> 'test'"
	 * @param array    $data   (required)      - Table Fields And Data
	 *                                           [ ['name1', 'data1'], ['name2', 'data2'], ['name3', 'data3'] ... ]
	 * 
	 */
	public function update($table, $where, $data) {
		$allData = array();
		foreach ( $data as $d ) {
			$temp = $d[0] . ' = ' . (is_numeric($d[1]) ? $d[1] : ('\'' . $d[1] . '\''));
			array_push($allData, $temp);
		}
		$query = 'UPDATE ' . $table . ' SET ' . implode(', ', $allData) . ' WHERE ' . $where;
		return mysqli_query($this->CONNECT, $query);
	}
}