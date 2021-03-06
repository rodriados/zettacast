<?php
/**
 * Zettacast\Stream\Filter class file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2017 Rodrigo Siqueira
 */
namespace Zettacast\Stream;

use Zettacast\Stream\Filter\ClosureFilter;

/**
 * This class manages filters to be applied to streams.
 * @package Zettacast\Stream
 * @version 1.0
 */
class Filter implements FilterInterface
{
	/**
	 * Parameter to pass to filter object.
	 * @var mixed Filter parameter.
	 */
	protected $param;
	
	/**
	 * The name of filter to apply to stream.
	 * @var string Filter name.
	 */
	protected $filtername;
	
	/**
	 * All filter instances tracked by this object.
	 * @var resource[] Filter instances.
	 */
	private $instances;
	
	/**
	 * Filter constructor.
	 * If given filtername is not yet registered, this object will try to
	 * automatically register it. Closures are also accepted by this filter
	 * manager.
	 * @param string|\Closure $filter Filter to apply to stream.
	 * @param mixed $param Parameter to pass to filter.
	 * @throws FilterException The given filter name is not known.
	 * @see ClosureFilter
	 */
	public function __construct($filter, $param = null)
	{
		if($filter instanceof \Closure) {
			$param = $filter;
			$filter = ClosureFilter::class;
		}
		
		if(!in_array($filter, self::list())) {
			$class = zetta()->resolve($filter)['concrete'] ?? $filter;
			
			if(!class_exists($class, true))
				throw FilterException::unknown($filter);
			
			self::register($filter, $class);
		}
		
		$this->filtername = $filter;
		$this->instances = [];
		$this->param = $param;
	}
	
	/**
	 * Appends filter to a stream.
	 * @param resource $stream Stream to filter.
	 * @param int $channel Stream channel to filter.
	 * @return static Filter for method chaining.
	 */
	public function append($stream, int $channel = self::ALL)
	{
		$this->instances[] = stream_filter_append(
			$stream, $this->filtername, $channel, $this->param
		);
		
		return $this;
	}
	
	/**
	 * Prepends filter to a stream.
	 * @param resource $stream Stream to filter.
	 * @param int $channel Stream channel to filter.
	 * @return static Filter for method chaining.
	 */
	public function prepend($stream, int $channel = self::ALL)
	{
		$this->instances[] = stream_filter_prepend(
			$stream, $this->filtername, $channel, $this->param
		);
		
		return $this;
	}
	
	/**
	 * Removes the filter from all streams it was applied to.
	 * @return static Filter for method chaining.
	 */
	public function remove()
	{
		foreach($this->instances as  $filter)
			stream_filter_remove($filter);
		
		return $this;
	}
	
	/**
	 * Retrieves a list of all currently available filters.
	 * @return array List of registered filters.
	 */
	final public static function list(): array
	{
		return stream_get_filters();
	}
	
	/**
	 * Registers a class as a stream filter, making it available for use.
	 * @param string $filter Filter name to be registered.
	 * @param string $class Class responsible for responding to filter calls.
	 * @return bool Was the filter successfully registered?
	 */
	final public static function register(string $filter, string $class): bool
	{
		return stream_filter_register($filter, $class);
	}
}
