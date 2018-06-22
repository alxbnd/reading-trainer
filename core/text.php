<?php

namespace Core;

class Text
{
	
	public function book_processing ($id) {
		echo $id.'<br>'.FILES_DIR;
		$text = strip_tags(file_get_contents(FILES_DIR.'/upload/'.$id));
		$lines = preg_split('/\\r\\n?|\\n/', $text);
		$text = '';
		foreach ($lines as $k=>$v) {
			$text .= '<p>'.$v.'</p>'; 
		}
		file_put_contents(FILES_DIR.'/ready/'.$id, $text);
	}
	
	public function mean_processing ($text) {
		$lines = preg_split('/\.\s+\d+\./', $text);
		
		return $lines;
	}
	
}