<?php
/**
 * Zettacast\Collection\CollectionInterface interface file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2018 Rodrigo Siqueira
 */
namespace Zettacast\Collection;

use Zettacast\Support\IterableInterface;
use Zettacast\Support\StorageInterface;

interface CollectionInterface extends IterableInterface, StorageInterface
{
	/**
	 * Retrieves an element stored in object.
	 * @param mixed $key Key of requested element.
	 * @param mixed $default Default value fallback.
	 * @return mixed Requested element or default fallback.
	 */
	public function get($key, $default = null);
}
