<?php
namespace Webos\Visual;
abstract class Control extends \Webos\VisualObject {

	final public function __construct(\Webos\VisualObject $parent, array $initialAttributes = array()) {
		parent::__construct($initialAttributes);

		$this->_parentObject = $parent;
		$parent->addChildObject($this);

		$this->initialize();
	}

	/**
	 * La construcción del objeto ControlObject es delicada debido a la implementación
	 * del patrón relacional padre - hijo.
	 *
	 * Para asegurar ese comportamiento, el constructor no puede ser especializado
	 * y para permitir la inicialización de parámetros del objeto se dispone de un
	 * método initialize() que será invocado por el constructor, y que podrá ser
	 * especializado de acuerdo a las necesidades.
	 */
	public function initialize() {}
	
	public function focus() {
		$this->getParentWindow()->setActiveControl($this);
	}
	
	public function hasFocus() {
		return $this->getParentWindow()->hasFocus($this);
	}
}