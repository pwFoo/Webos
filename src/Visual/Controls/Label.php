<?php
namespace Webos\Visual\Controls;

use Webos\StringChar;

class Label extends Field {
	public function render(): string {
		$html = new StringChar('<div id="__ID__" class="LabelControl"__style__>__text__</div>');
		
		return $html
			->replace('__ID__',    $this->getObjectID())
			->replace('__text__',  $this->text)
			->replace('__style__', $this->getInlineStyle());
	}
}