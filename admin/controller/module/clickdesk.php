<?php
class ControllerModuleclickdesk extends Controller {

	private $error = array(); 

	public function index() {
		$this->load->language('module/clickdesk'); // THIS IS LOCATED UNDER YOUR ADMIN DIRECTORY
		$this->document->title = $this->language->get('heading_title');
		$this->load->model('setting/setting');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
/*
		if(isset($_GET["cdwidgetid"]))
		{
			$cdwidgetid = trim($_GET["cdwidgetid"]);
			if($cdwidgetid != "" )
			{
				
for ($i=1;$i<=11;$i++)
$settings['clickdesk_module'][] = Array (
	'layout_id' => $i,
	'position' => 'content_top',
	'status' => 1,
	'sort_order' => '',
'clickdeskiddgetid'=>$cdwidgetid
);
$this->model_setting_setting->editSetting('clickdesk', $settings);


			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/clickdesk', 'token=' . $this->session->data['token'], 'SSL'));
			}

		}
 
		if(isset($_POST["clickdeskwidgetid"]))
		{
			$clickdeskwidgetid = trim($_POST["clickdeskwidgetid"]);
			if($clickdeskwidgetid != "" )
			{
				for ($i=1;$i<=11;$i++)
$settings['clickdesk_module'][] = Array (
	'layout_id' => $i,
	'position' => 'content_top',
	'status' => 1,
	'sort_order' => '',
'clickdeskiddgetid'=>$clickdeskwidgetid 
);
$this->model_setting_setting->editSetting('clickdesk', $settings);

			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/clickdesk', 'token=' . $this->session->data['token'], 'SSL'));
			}
		} 


		$widgetid = $this->config->get('clickdesk_module');
 
 

		if(isset($widgetid[0]["clickdeskiddgetid"]))
		{
			$widgetid = 	$widgetid[0]["clickdeskiddgetid"];
		}else
		{
			$widgetid = "";
		}
		define('LIVILY_SERVER_URL', "http://my.clickdesk.com/");
		define('LIVILY_DASHBOARD_URL', LIVILY_SERVER_URL.'widgets-wp.jsp?cdplugin=opencart&wpurl=');
		$Path=$this->url->link('module/clickdesk', 'token=' . $this->session->data['token'], 'SSL');

		$Path = urlencode($Path);

		$cdURL= LIVILY_DASHBOARD_URL.$Path;

		$this->data["widgetid"] = $widgetid;
		if(strlen($widgetid) != 0){
			$mssg = urlencode("Plugin has been installed successfully.");
			$cdURL = $cdURL."&mssg=".$mssg;

			$this->data["iframeurl"] = $cdURL;

		}else
		{

			$this->data["iframeurl"] = $cdURL;	

		}


		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

			

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/clickdesk', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
 

		$this->data['modules'] = array();
	
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

*/
		$this->template = 'module/clickdesk.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

}
?>
