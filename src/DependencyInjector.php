<?php
namespace Webos;

use ReflectionObject;
use ReflectionFunction;

class DependencyInjector {
	
	static public function getDependenciesList (callable $fn): array {
		if (is_array($fn) && is_object($fn[0]) && isset($fn[1])) {
			$ro = new ReflectionObject($fn[0]);
			$rf = $ro->getMethod($fn[1]);
		} else {
			$rf = new ReflectionFunction($fn);
		}
		$pl = $rf->getParameters();
		$list = [];
		foreach($pl as $p) {
			$list[] = $p->getName();
		}
		return $list;
	}
	
	static public function buildDependenciesFromArray(array $list, array $dependencies): array {
		$newList = [];
		
		foreach($list as $name) {
			if (isset($dependencies[$name])) {
				$newList[] = $dependencies[$name];
			} else {
				$newList[] = null;
			}
		}
		return $newList;
	}
	
	static public function inject(callable $callable, array $dependencies = []) {
		return call_user_func_array($callable, $dependencies);
	}
}