<?php

class WindowCloneMenuItem extends MenuItem {

	public function  getInitialAttributes() {
		return array(
			'title' => 'Nueva ventana',
		);
	}

	public function press() {
		$this->getParentApp()->addChildObject(clone $this);
		$this->getParentByClassName('MenuButton')->close();
	}
}