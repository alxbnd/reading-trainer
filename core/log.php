<?php

namespace Core;

class Log
{
	
	private $message;
	private $path;
	
	public function __construct ($type, $err) {
		$this->path = LOG_DIR.$type.'/'.date('Y-m-d');
		$this->message = $err;
		$this->prep_dir(LOG_DIR.$type);
	}
	
	public function write_log() {
		$msg = date("H:m:s") . ':____'. $this->message. '
		IP = '. $_SERVER['REMOTE_ADDR'] .'
		
';		
		file_put_contents($this->path, $msg, FILE_APPEND);
	}
	
	protected function prep_dir($path) {
		if (!file_exists($this->path)) {
			if (!is_dir($path)) {
				if (!mkdir($path)) {
					throw new \RuntimeException("Log dir can't be created by path \"{$path}\" ");
				}
			}
			mail(DEV_EMAIL, 'error_logs', 'new logfile created '.$this->path);
		}
	}
	
}