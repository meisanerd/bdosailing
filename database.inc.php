<?php
	class Database {
		private $query = null;
		private $result = null;
		private $lastid = null;
		private $link = null;
		private $debug = false;
		public $config = null;

		function __construct($dbconfig,$link = null) {
			$this->config = $dbconfig;
			$this->link = $link;
			return $this->connect($this->config->host,$this->config->user,$this->config->pass,$this->config->db);
		}

		function connect($host,$user,$pass,$db) {
			if($this->link) {
				return true;
			}
			$this->link = mysqli_connect($host,$user,$pass,$db);
			return $this->link;
		}

		function disconnect() {
			if($this->link) {
				mysqli_close($this->link);
				$this->link = null;
			}
		}

		function startTransaction() {
			mysqli_autocommit($this->link, false);
		}

		function endTransaction() {
			mysqli_commit($this->link);
			mysqli_autocommit($this->link, true);
		}

		function setQuery($query) {
			$this->query = $query;
		}

		function runQuery() {
			if(func_num_args()) {
				$args = func_get_args();
				for($x = 0; $x < count($args); $x++) {
					$args[$x] = $this->escape($args[$x]);
				}
				array_unshift($args,$this->query);
				$query = call_user_func_array('sprintf',$args);
			} else {
				$query = $this->query;
			}
			if($this->debug) echo '<br />' . $query . "<br />\n";
			$this->result = mysqli_query($this->link,$query);
			if($this->debug) echo '<br />' . mysqli_error($this->link) . "<br />\n";
			$this->lastid = mysqli_insert_id($this->link);
			return $this->result?true:false;
		}

		function getAffectedRows() {
			return mysqli_affected_rows($this->link);
		}

		function getLastId() {
			return $this->lastid;
		}

		function getLink() {
			return $this->link;
		}

		function getNumRows() {
			return mysqli_num_rows($this->result);
		}

		function getResult() {
			return mysqli_num_rows($this->result)?mysqli_fetch_object($this->result):false;
		}

		function getResultSingle() {
			if($this->getNumRows()) {
				$row = mysqli_fetch_row($this->result);
				return $row[0];
			}
			return false;
		}

		function getResults() {
			$result = array();
			if($this->getNumRows()) {
				while(($row = mysqli_fetch_object($this->result)) !== NULL) {
					$result[] = $row;
				}
			}
			return $result;
		}

		function getResultsIndexed($col = 'id') {
			$result = array();
			if($this->getNumRows()) {
				while(($row = mysqli_fetch_object($this->result)) !== NULL) {
					$result[$row->{$col}] = $row;
				}
			}
			return $result;
		}

		function getResultsSingle() {
			$result = array();
			if($this->getNumRows()) {
				for($x = 0; $x < mysqli_num_rows($this->result); $x++) {
					$row = mysqli_fetch_row($this->result);
					$result[] = $row[0];
				}
			}
			return $result;
		}

		function getResultsSingleIndexed($col = 'id', $resultcol = 'name') {
			$result = array();
			if($this->getNumRows()) {
				while(($row = mysqli_fetch_object($this->result)) !== NULL) {
					$result[$row->{$col}] = $row->{$resultcol};
				}
			}
			return $result;
		}

		function escape($value,$escapePrintf = false) {
			if(is_numeric($value)) {
				return $value;
			}
			if($escapePrintf) {
				$value = str_replace('%','%%',$value);
			}
			return mysqli_real_escape_string($this->link,$value);
		}

		function getError() {
			return mysqli_error($this->link);
		}

		function setDebug($debug) {
			$this->debug = $debug;
		}
	}
