<?php 
class ControllerFeedRSSReview extends Controller {
	public function index() {
		if ($this->config->get('google_base_status')) { 
			$output  = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
            $output .= '<channel>';
			$output .= '<title>' . $this->config->get('config_store') . '</title>'; 
			$output .= '<description>Customer reviews</description>';
			$output .= '<link>' . HTTP_SERVER . '</link>';
			
			$this->load->model('catalog/review');
			$reviews = $this->model_catalog_review->getLastReviews(20);
			foreach ($reviews as $review) {
					$output .= '<item>';
					$output .= '<title>' . $review['name'] . '</title>';
					$output .= '<description>' . $review['text'] . '</description>';
					$output .= '<guid>' . $review['review_id'] . '</guid>';
					$output .= '<link>' . $this->url->http('product/product&product_id=' . $review['product_id']) . '</link>';					
					$output .= '</item>';
			}

			$output .= '</channel>';
			$output .= '</rss>';	
			
			$this->response->addHeader('Content-Type', 'application/rss+xml');
			$this->response->setOutput($output);
		}
	}	
}
?>
