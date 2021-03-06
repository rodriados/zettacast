<?php
/**
 * Zettacast\Stream\StreamException exception file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2017 Rodrigo Siqueira
 */
namespace Zettacast\Stream;

use Zettacast\Exception\Exception;

/**
 * This class informs an error occurred during execution of a stream operation.
 * @package Zettacast\Stream
 * @version 1.0
 */
class StreamException extends Exception
{
	/**
	 * Creates a stream operation exception.
	 * @param string $uri The identifier of stream that issued exception.
	 * @return static The created stream exception.
	 */
	public static function unopened(string $uri)
	{
		return static::format(
			_('The stream identified by "%1$s" could not be found or opened.'),
			$uri
		);
	}
}
