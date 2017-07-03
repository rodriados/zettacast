<?php
/**
 * Zettacast\Zettacast class file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2017 Rodrigo Siqueira
 */
namespace Zettacast;

use Zettacast\Injector\Injector;

/**
 * Boots framework and starts its main classes and modules, allowing its
 * correct usage and execution.
 * @version 1.0
 */
final class Zettacast extends Injector {
	
	/**
	 * Informs Zettacast current version.
	 * @var string Zettacast version.
	 */
	const VERSION       = '1.0';
	
	/**#@+
	 * Environment mode constants. These constants determine in which mode
	 * Zettacast should execute. In some occasions, different actions are taken
	 * depending on the environment framework is executing.
	 * @var string Execution mode constants.
	 */
	const LOCAL         = 0x001;
	const TESTING       = 0x002;
	const DEVELOPMENT   = 0x004;
	const PRODUCTION    = 0x008;
	/**#@-*/
	
	/**#@+
	 * Input mode constants. These constants inform whether the framework is
	 * being executed by command line or by an user via a browser, or even if
	 * it's an asynchronous request, such as AJAX.
	 * @var int Input mode constants.
	 */
	const APPLICATION   = 0x010;
	const COMMANDLINE   = 0x020;
	const ASYNCHRONOUS  = 0x040;
	/**#@-*/
	
	/**
	 * Internationalization locale. This property informs the language the
	 * application is being presented to the used.
	 * @var string Application's language.
	 */
	public static $locale = 'en_US';
	
	/**
	 * User's timezone. This property informs the timezone to be shown whenever
	 * a date or hour is presented to the user.
	 * @var string Application's timezone.
	 */
	public static $timezone = 'UTC';
	
	/**
	 * Application's encoding. This property informs the encoding used to show
	 * texts for the user.
	 * @var string Application's encoding.
	 */
	public static $encoding = 'UTF-8';
	
	/**
	 * Stores this class' singleton instance and helps checking whether the
	 * framework has already been booted or not.
	 * @var Zettacast Framework singleton instance.
	 */
	private static $instance = null;
	
	/**
	 * This method is responsible for setting the minimal configuration and
	 * gathering information about the environment so the framework can work
	 * correctly and execute the application as expected.
	 * @param string $root Document root directory path.
	 */
	public function __construct(string $root = DOCROOT) {
		parent::__construct();
		
		$this->share('path', $root.'/app');
		$this->share('path.base', $root);
		$this->share('path.public', $root.'/public');
		$this->share('path.zetta', $root.'/zettacast');
		
		$this->share(self::class, $this);
		$this->share(Injector::class, $this);
		
		$this->fworkbind();
		
	}
	
	/**
	 * Singleton instance discovery. This method gives access to the singleton
	 * or creates it if it's not yet created.
	 * @return static Singleton instance.
	 */
	public static function instance() {
		
		if(is_null(self::$instance))
			self::$instance = new self;
		
		return self::$instance;
		
	}
	
	/**
	 * This method binds all framework contract abstractions to their default
	 * concrete implementations. Thus, dependency injection can work correctly.
	 * @return void
	 */
	private function fworkbind() {
		
		$bindings = require FWORKPATH.'/bindings.php';
		
		foreach($bindings as $abstract => $concrete)
			$this->bind($abstract, $concrete);
		
	}
	
}