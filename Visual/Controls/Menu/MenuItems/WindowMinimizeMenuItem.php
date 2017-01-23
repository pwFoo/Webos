<?php

class WindowMinimizeMenuItem extends MenuItem {

	public function  getInitialAttributes() {
		return array(
			'title' => 'Minimizar',
		);
	}

	public function press() {
		$this->getParentWindow()->status = 'minimized';
		$this->getParentByClassName('MenuButton')->close();
	}
}