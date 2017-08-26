<?php
namespace Webos\Visual\Windows;
use \Webos\Visual\Window;
use \salodev\Utils;
class Message extends Window {

	public function initialize(array $params = array()) {
		$this->title   = Utils::Ifnull($params['title'  ], 'Mensaje:');
		$this->message = Utils::Ifnull($params['message'], 'Mensaje:');
		$this->width   = Utils::Ifnull($params['width'  ], 450       );
		$this->height  = Utils::Ifnull($params['height' ], 150       );
		$this->messageType = Utils::Ifnull($params['type']);

	}

	public function  getInitialAttributes(): array {
		return array(
			'height' => 100,
			'width'  => 200
		);
	}
	
	public function render(): string {
		$template = $this->_getRenderTemplate();

		$content = new \Webos\StringChar(
			'<div style="text-align:center;">' .
				'<div style="margin:10px 20px 20px 20px;font-weight:bold;__MESSAGE_TYPE__">__MESSAGE__</div>' .
				'<div>' .
					'<input type="button" value="Cerrar" webos action="close" />'.
				'</div>' .
			'</div>'
		);
		
		$messageType = 'color:blue;';
		if ($this->messageType=='info') {
			$messageType = 'color:blue;';
		}
		if ($this->messageType=='error') {
			$messageType = 'color:red;';
		}
		
		$content->replace('__MESSAGE__',      $this->message      );
		$content->replace('__MESSAGE_TYPE__', $messageType        );
		$content->replace('__OBJECTID__',     $this->getObjectID());
		
		$template->replace('__TITLE__',       $this->title        );
		$template->replace('__CONTENT__',     $content            );
		
		return $template;
	}
}