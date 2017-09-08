<?php
/**
 * Config façade file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2017 Rodrigo Siqueira
 */
namespace Zettacast\Facade;

use Zettacast\Helper\Facade;
use Zettacast\Config\Config as DataConfig;
use Zettacast\Config\Repository as baseclass;

/**
 * Zettacast's Config façade class.
 * This class exposes package:config\Repository methods to external usage.
 * @method static mixed get(string $key, $default = null)
 * @method static bool load(string $file)
 * @method static baseclass remove(string $key)
 * @method static baseclass set(string $key, $default)
 * @version 1.0
 */
final class Config
{
	use Facade;
	
	/**
	 * Creates a new imutable configuration instance.
	 * @param array $data Data to be stored by instance.
	 * @return DataConfig The created configuration instance.
	 */
	public static function make(array $data = [])
	{
		return new DataConfig($data);
	}
	
	/**
	 * Informs what the façaded object accessor is, allowing it to be further
	 * used when calling façaded methods.
	 * @return mixed Façaded object accessor.
	 */
	protected static function accessor()
	{
		return new baseclass(APPPATH.'/config');
	}
	
}
