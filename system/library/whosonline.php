<?php

final class WhosOnline {
	private $default_timeout = 3;
	
	private $timeout;
	private $session_id;
	private $ip;
	private $first_click;
	private $last_click;
	private $customer_id;
	private $route;
	private $referer;
	private $agent;
	
	public function __construct() {
		
		$this->config = Registry::get('config');
		$this->customer = Registry::get('customer');
		$this->session = Registry::get('session');
		$this->db = Registry::get('db');
		
		$this->timeout = (int)$this->default_timeout;
		$this->session_id = session_id();
		$this->ip = $this->getIp();
		$this->first_click = date('Y-m-d H:i:s');
		$this->last_click = date('Y-m-d H:i:s');
		$this->customer_id = $this->customer->getId() === null ? 'null' : $this->customer->getId();
		if($this->session !== null) {
			$this->user_id = !isset($this->session->data['user_id']) ? 'null' : $this->session->data['user_id'];
		} else {
			$this->user_id = 'null';
		}
		$this->route = str_replace('_route_=', '', $_SERVER['QUERY_STRING']);
		$this->agent = $_SERVER['HTTP_USER_AGENT'];
		$this->referer = !isset($_SERVER['HTTP_REFERER']) ? 'null' : "'" . $_SERVER['HTTP_REFERER'] . "'";
		
		$this->execute();
		
		Registry::set('whos_online', $this->countWho());
	}

	private function execute() {
		$this->deleteWho();
		
		$currentWho = $this->getWho();
		if($currentWho === null) {
			$this->newWho();
		} else {
			$this->updateWho();
		}
	}
	
	private function getWho() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "whos_online WHERE session_id = '$this->session_id'");
		if($query->num_rows) {
			return $query->row;
		}
		
		return null;
	}
	
	private function newWho() {
		$query = $this->db->query("
			INSERT INTO " . DB_PREFIX . "whos_online (customer_id, user_id, session_id, first_click, last_click, ip, route, agent, referer)
			VALUES ($this->customer_id, $this->user_id, '$this->session_id', '$this->first_click', '$this->last_click', '$this->ip', '$this->route', '$this->agent',$this->referer)");
	}
	
	private function updateWho() {
		$query = $this->db->query("
			UPDATE " . DB_PREFIX . "whos_online SET
				customer_id = $this->customer_id,
				user_id = $this->user_id,
				last_click = '$this->last_click',
				ip = '$this->ip',
				route = '".$this->db->escape($this->route)."',
				agent = '".$this->db->escape($this->agent)."'
			WHERE session_id = '$this->session_id'");
	}
	
	private function deleteWho() {
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "whos_online WHERE last_click < NOW() - INTERVAL $this->timeout MINUTE");
	}
	
	private function countWho() {
		$query = $this->db->query("SELECT DISTINCT session_id FROM " . DB_PREFIX . "whos_online");
		return $query->num_rows;
	}
	
	private function getIp() {
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		} elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		} elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}
}

?>