<?php
/**
 * Zettacast bindings file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2017 Rodrigo Siqueira
 */

/*
 * This array informs all abstractions' implementations so the framework can
 * work properly and still be very customizable and flexible.
 */
return [
	/* Injector Module */
	Zettacast\Injector\Contract\Injector::class
		=> Zettacast\Injector\Injector::class
	
	/* Router Module */
,	Zettacast\Router\Contract\Router::class
		=> Zettacast\Router::class
	
	/* HTTP Module */
,	Zettacast\HTTP\Contract\Kernel::class
		=> Zettacast\HTTP\Kernel::class
,	Zettacast\HTTP\Contract\Request::class
		=> Zettacast\HTTP\Request::class
	
	/* FileSystem Module */
,	Zettacast\FileSystem\Contract\Driver::class
		=> Zettacast\FileSystem\Driver\Local::class
,   Zettacast\FileSystem\Contract\Handler::class
		=> Zettacast\FileSystem\File::class
	
	/* Console */
,	//Zettacast\Console\Contract\Kernel::class => Zettacast\Console\Kernel::class,
];