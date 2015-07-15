<?php
class ModelUserStats extends Model {
	
	public function getWhos($data) {
		$this->deleteWho($data);
		
		$sql = "
		SELECT
			wo.user_id,
			wo.customer_id,
			wo.session_id,
			wo.first_click,
			wo.last_click,
			wo.ip,
			wo.route,
			wo.agent,
			wo.referer,
			TIMEDIFF(wo.last_click, wo.first_click) 'time_online'
		FROM " . DB_PREFIX . "whos_online wo
		WHERE 1=1
		ORDER BY wo.first_click, wo.last_click";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function deleteWho($data) {
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "whos_online WHERE last_click < NOW() - INTERVAL {$data['timeout']} MINUTE");
		//$query = $this->db->query("DELETE FROM " . DB_PREFIX . "whos_online WHERE last_click < NOW() - INTERVAL 3 MINUTE");
	}
	
	public function countWho($data) {
		$this->deleteWho($data);
		$query = $this->db->query("SELECT DISTINCT session_id FROM " . DB_PREFIX . "whos_online");
		return $query->num_rows;
	}
	
}
?>