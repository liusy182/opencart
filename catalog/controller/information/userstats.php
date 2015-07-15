<?php 

class ControllerInformationUserstats extends Controller {

	public function index() {

		$this->document->title = 'Statistics';
		$this->document->breadcrumbs = array();
		
		$this->document->breadcrumbs[] = array(
				'href'      => $this->url->http('information/userstats'),
				'text'      => 'statistics',
				'separator' => FALSE
		);
		
		$this->load->model('user/stats');
		$this->data['timeout'] = 10;
		$this->data['start'] = 0;
		$this->data['limit'] = 20;
		$this->data['usercount'] = $this->model_user_stats->countWho($this->data); 

		
		$this->data['browsers'] = array();
		$this->data['countries'] = array();
		$results = $this->model_user_stats->getWhos($this->data);
		foreach ($results as $result) {
			$browsername = $this->getBrowser($result['agent']);
			if (isset($this->data['browsers'][$browsername])) {
				$this->data['browsers'][$browsername] += 1;
			}
			else {
				$this->data['browsers'][$browsername] = 1;
			}
			
			$countryname = file_get_contents('http://api.hostip.info/country.php?ip='.$result['ip']);
			if (isset($this->data['countries'][$countryname])) {
				$this->data['countries'][$countryname] += 1;
			}
			else {
				$this->data['countries'][$countryname] = 1;
			}
		}
		
		$this->load->model('catalog/review');
		$this->data['reviews'] = $this->model_catalog_review->getReviewCounts();
			
		
		$tempArray = array();
		foreach($this->data['browsers'] as $key => $value) {
			$tempStr = "[\"" . "$key" . "\"," . "$value". "]";
			array_push($tempArray, $tempStr);
		}
		$this->data['browserDataOutput'] = implode (",", $tempArray);
		
		$tempArray2 = array();
		foreach($this->data['countries'] as $key => $value) {
			$tempStr2 = "[\"" . "$key" . "\"," . "$value". "]";
			array_push($tempArray2, $tempStr2);
		}
		$this->data['countryDataOutput'] = implode (",", $tempArray2);
		
		$tempArray3 = array();
		foreach($this->data['reviews'] as $review) {
			$tempStr3 = "[\"" . "$review[name]" . "\"," . "$review[total]". "]";
			array_push($tempArray3, $tempStr3);
		}
		$this->data['rankDataOutput'] = implode (",", $tempArray3);

		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/userstats.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/userstats.tpl';
		} else {
			$this->template = 'default/template/information/userstats.tpl';
		}
		
		$this->children = array(
				'common/header',
				'common/footer',
				'common/column_left',
				'common/column_right'
		);
		
	  	$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}
  	
  	
  	private function getBrowser($user_agent) {
  		$browser_name = 'Unknown';
  		$platform = 'Unknown';
  		$version = '?';
  		$ub = '';
  	
  		// Platform
  		if (preg_match('/linux/i', $user_agent)) {
  			$platform = 'linux';
  		} elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
  			$platform = 'Mac';
  		} elseif (preg_match('/windows|win32/i', $user_agent)) {
  			$platform = 'Windows';
  		}
  	
  		// Browser
  		if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent)) {
  			$browser_name = 'Internet Explorer';
  			$ub = "MSIE";
  		} elseif(preg_match('/Firefox/i',$user_agent)) {
  			$browser_name = 'Mozilla Firefox';
  			$ub = "Firefox";
  		} elseif(preg_match('/Chrome/i',$user_agent)) {
  			$browser_name = 'Google Chrome';
  			$ub = "Chrome";
  		} elseif(preg_match('/Safari/i',$user_agent)) {
  			$browser_name = 'Apple Safari';
  			$ub = "Safari";
  		} elseif(preg_match('/Opera/i',$user_agent)) {
  			$browser_name = 'Opera';
  			$ub = "Opera";
  		} elseif(preg_match('/Netscape/i',$user_agent)) {
  			$browser_name = 'Netscape';
  			$ub = "Netscape";
  		}
  	
  		// Browser version
  		$known = array('Version', $ub, 'other');
  		$pattern = '#(?<browser>' . join('|', $known) .	')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  		if (preg_match_all($pattern, $user_agent, $matches)) {
  			// see how many we have
  			$i = count($matches['browser']);
  			if ($i != 1) {
  				//we will have two since we are not using 'other' argument yet
  				//see if version is before or after the name
  				if (strripos($user_agent,"Version") < strripos($user_agent,$ub)){
  					$version = $matches['version'][0];
  				} else {
  					$version = $matches['version'][1];
  				}
  			} else {
  				$version = $matches['version'][0];
  			}
  		}
  	
  		$browser = new stdclass();
  		$browser->name = $browser_name;
  		$browser->version = $version;
  		$browser->platform = $platform;
  	
  		return $browser_name;
  		// return $browser;
  	}
}
?>
