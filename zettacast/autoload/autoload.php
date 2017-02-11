<?php
/**
 * Zettacast\Autoload\Autoload class file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2017 Rodrigo Siqueira
 */
namespace Zettacast\Autoload;

/*
 * Imports class-loaders "manually". This is the last time we do this kind of
 * "hardcoding". All future classes will be loaded automatically.
 */
require FWORKPATH.'/autoload/loader/base.php';
require FWORKPATH.'/autoload/loader/framework.php';
require FWORKPATH.'/helper/contract/singleton.php';

use Zettacast\Autoload\Loader\Base;
use Zettacast\Autoload\Loader\Framework;
use Zettacast\Helper\Contract\Singleton;

/**
 * The autoload class is responsible for loading all classes required by the
 * framework or the application itself. It also lets you set explicit paths for
 * classes to be loaded from.
 * @package Zettacast\Autoload
 * @version 1.1
 */
final class Autoload {
	
	/*
	 * Singleton trait inclusion. This trait implements Singleton pattern
	 * that allows the existance of one and only one object instance.
	 */
	use Singleton;
	
	/**
	 * Stores the classloaders already registered in the autoloading system.
	 * This allows us to keep track of all class loading functions.
	 * @var Base[] Class loader functions registered.
	 */
	private $loaders;
	
	/**
	 * Stores the default loader instance for Zettacast classes. This loader is
	 * special and cannot be closed.
	 * @var Framework Zettacast main loader instance.
	 */
	private $framework;
	
	/**
	 * Autoload constructor.
	 * Initializes the class and set values to instance properties.
	 */
	protected function __construct() {
		
		$this->loaders = [];
		$this->framework = new Framework;
		
	}
	
	/**
	 * Starts framework autoloading.
	 * Starts and registers default framework autoloader.
	 */
	public static function init() {
		
		self::register(self::i()->framework);
		
	}
	
	/**
	 * Registers a loader to the autoload stack. The autoload function will be
	 * the responsible for automatically loading all classes invoked by the
	 * framework or by the application.
	 * @var Base $loader A loader to be registered.
	 * @return bool Was the loader successfully registered?
	 */
	public static function register(Base $loader) {

		if(!in_array($loader, self::i()->loaders)) {
			
			self::i()->loaders[] = $loader;
			return spl_autoload_register([$loader, 'load']);
			
		}
		
		return false;
		
	}
	
	/**
	 * Unregisters a class loader from the autoload stack.
	 * @param Base $loader A loader to be unregistered.
	 */
	public static function unregister(Base $loader) {
		
		if(in_array($loader, self::i()->loaders)) {
			
			unset(self::i()->loaders[
				array_search($loader, self::i()->loaders)
			]);
			spl_autoload_unregister([$loader, 'load']);
			
		}
		
	}
	
	/**
	 * Resets all registered loaders and unregister all loaders but the default
	 * one. This is used when only Zettacast's core classes are needed.
	 */
	public static function reset() {
		
		foreach(self::i()->loaders as $loader) {
			spl_autoload_unregister([$loader, 'load']);
			$loader->reset();
		}
		
		self::init();
		
	}
	
}
