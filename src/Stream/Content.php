<?php

namespace Webos\Stream;
use Exception;
use salodev\FileSystem\File;

class Content {
	
	private $_content  = null;
	private $_mimeType = null;
	private $_name     = null;
	private $_path     = null;
	private $_download = false;
	
	public function __construct(string $content = null, string $mimeType = null, string $name = null, string $path = null, bool $download = false) {
		
		if ($content === null && $path === null) {
			throw new Exception('Provide content or path');
		}
		
		$this->_content  = $content;
		$this->_mimeType = $mimeType;
		$this->_name     = $name;
		$this->_path     = $path;
		$this->_download = $download;
	}
	
	static public function CreateFileContent(string $filePath): self {
		return new self(null, null, null, $filePath);
	}
	
	static public function CreateFromArray(array $data): self {
		return new self($data['content'], $data['mimeType'], $data['name'], $data['path'], $data['download']);
	}
	
	public function getArray(): array {
		return [
			'download' => $this->_download,
			'content'  => $this->_content,
			'mimeType' => $this->_mimeType,
			'name'     => $this->_name,
			'path'     => $this->_path,
		];
	}
	
	public function streamIt(): void {
		if (!empty($this->_content)) {
			if ($this->_name) {
				header("Content-Disposition: attachment; filename=\"{$this->_name}\"");
			} else {
				header("Content-Disposition: attachment");
			}
			header("Content-Type: {$this->_mimeType}");
			echo $this->_content;
			die();
		}
		
		if (!empty($this->_path)) {
			$file = new File($this->_path);
			$mimeType = $file->getMimeType();
			if ($this->_download) {
				if ($this->_name) {
					header("Content-Disposition: attachment; filename=\"{$this->_name}\"");
				} else {
					header("Content-Disposition: attachment");
				}
			}
			header("Content-Type: {$mimeType}");
			$file->streamAllContent();
			die();
		}
		
		die();
	}
}