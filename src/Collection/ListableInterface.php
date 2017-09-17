<?php
/**
 * Zettacast\Collection\ListableInterface interface file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2017 Rodrigo Siqueira
 */
namespace Zettacast\Collection;

/**
 * Listable interface. This interface exposes the minimal methods needed for
 * the creation of a listable object.
 * @package Zettacast\Collection
 */
interface ListableInterface extends \Countable, \Iterator
{
	/**
	 * Returns all data stored in collection.
	 * @return array All data stored in collection.
	 */
	public function all(): array;
	
	/**
	 * Clears all data stored in object and returns it.
	 * @return array All data stored in collection before clearing.
	 */
	public function clear(): array;
	
	/**
	 * Copies all the content present in this object.
	 * @return $this A new collection with copied data.
	 */
	public function copy();
	
	/**
	 * Checks whether collection is currently empty.
	 * @return bool Is collection empty?
	 */
	public function empty(): bool;
	
}