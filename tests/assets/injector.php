<?php

interface AInterface {}
interface BInterface {}
interface CInterface extends BInterface {}
interface DInterface extends CInterface {}
interface EInterface {}

class A implements AInterface {}

class B extends A implements BInterface {}

class C implements CInterface {
	public function __construct(AInterface $a, BInterface $b)
	{}
}

class D implements DInterface {
	public $b;
	public function __construct(BInterface $b)
	{
		$this->b = $b;
	}
	
	public static function staticF(AInterface $a, int $i)
	{
		return [$a, $i];
	}
	
	public function instanceF(AInterface $a, float $f)
	{
		return [$a, $f];
	}
}

function f(DInterface $d) {
	return $d;
}
