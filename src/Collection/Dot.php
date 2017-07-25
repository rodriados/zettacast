<?php
/**
 * Zettacast\Collection\Dot class file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2017 Rodrigo Siqueira
 */
namespace Zettacast\Collection;

/**
 * Dot class. This collection implements dot access methods, that is
 * it's possible to access its recursive data via dot notation.
 * @package Zettacast\Collection
 * @version 1.0
 */
class Dot
	extends Recursive
{
	/**
	 * Depth-separator. This variable holds the symbol that indicates depth
	 * when iterating over the data. It defaults to a single dot.
	 * @var string Depth separator.
	 */
	protected $dot;
	
	/**
	 * Dot constructor. This constructor simply sets the data received as the
	 * data stored in collection.
	 * @param array|\Traversable $data Data to be stored.
	 * @param string $dot Depth-separator.
	 */
	public function __construct($data = null, string $dot = '.')
	{
		$this->dot = $dot;
		parent::__construct($data);
	}
	
	/**
	 * Filters elements according to the given tests. If no tests function is
	 * given, it fallbacks to removing all false equivalent values.
	 * @param callable $fn Test function. Parameters: value, key.
	 * @return static Collection of all filtered values.
	 */
	public function filter(callable $fn = null)
	{
		static $scope = [];
		$fn = $fn ?? 'with';
		
		foreach($this->data as $key => $value) {
			array_push($scope, $key);
			
			if($fn($value, implode($this->dot, $scope)))
				$result[$key] = listable($value)
					? $this->new($value)->filter($fn)
					: $value;
			
			array_pop($scope);
		}
		
		return $this->new($result ?? []);
	}
	
	/**
	 * Gets an element stored in collection.
	 * @param mixed $key Key of requested element.
	 * @param mixed $default Default value fallback.
	 * @return mixed Requested element or default fallback.
	 */
	public function get($key, $default = null)
	{
		$dot = $this->undot($key);
		$node = &$this->data;
		
		foreach($dot as $segment) {
			if(!listable($node) || !isset($node[$segment]))
				return $default;
			
			$node instanceof Collection
				? ($node = &$node->data[$segment])
				: ($node = &$node[$segment]);
		}
		
		return $this->ref($node);
	}
	
	/**
	 * Checks whether element key exists.
	 * @param mixed $key Key to be check if exists.
	 * @return bool Does key exist?
	 */
	public function has($key) : bool
	{
		$dot = $this->undot($key);
		$node = &$this->data;
		
		foreach($dot as $segment) {
			if(!listable($node) || !isset($node[$segment]))
				return false;
			
			$node instanceof Collection
				? ($node = &$node->data[$segment])
				: ($node = &$node[$segment]);
		}
		
		return true;
	}
	
	/**
	 * Plucks an array of values from collection.
	 * @param string|array $value Requested keys to pluck.
	 * @param string|array $key Keys to index plucked array.
	 * @return Collection The plucked values.
	 */
	public function pluck($value, $key = null)
	{
		foreach($this->data as $item) {
			$ref = $this->ref($item);
			
			(is_null($key) || !($keyvalue = $ref->get($key)))
				? ($result[/*nokey*/] = $ref->get($value))
				: ($result[$keyvalue] = $ref->get($value));
				
		}
		
		return new Collection($result ?? []);
	}
	
	/**
	 * Sets a value to the given key.
	 * @param mixed $key Key to created or updated.
	 * @param mixed $value Value to be stored in key.
	 * @return static Collection for method chaining.
	 */
	public function set($key, $value)
	{
		$dot = $this->undot($key);
		$last = array_pop($dot);
		$node = &$this->data;
		
		foreach($dot as $segment) {
			if(!isset($node[$segment]) || !listable($node[$segment]))
				$node[$segment] = [];
			
			$node instanceof Collection
				? ($node = &$node->data[$segment])
				: ($node = &$node[$segment]);
		}
		
		$node[$last] = $value;
		return $this;
	}
	
	/**
	 * Removes an element from collection.
	 * @param mixed $key Key to be removed.
	 * @return static Collection for method chaining.
	 */
	public function remove($key)
	{
		$dot = $this->undot($key);
		$last = array_pop($dot);
		$node = &$this->data;
		
		foreach($dot as $segment) {
			if(!listable($node) or !isset($node[$segment]))
				return $this;
			
			$node instanceof Collection
				? ($node = &$node->data[$segment])
				: ($node = &$node[$segment]);
		}
		
		unset($node[$last]);
		return $this;
	}
	
	/**
	 * Creates a new instance of class based on an already existing instance.
	 * @param mixed $target Data to be fed into the new instance.
	 * @return static The new instance.
	 */
	protected function new($target = [])
	{
		$obj = new static($target, $this->dot);
		return $obj;
	}
	
	/**
	 * Explodes dot expression into array.
	 * @param string $key Dot expression key to be split.
	 * @return array Dot expression segments.
	 */
	protected function undot(string $key) : array
	{
		return explode($this->dot, trim($key, $this->dot));
	}
	
}