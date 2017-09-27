<?php
/**
 * Zettacast\Contract\Filesystem\DiskInterface interface file.
 * @package Zettacast
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @license MIT License
 * @copyright 2015-2017 Rodrigo Siqueira
 */
namespace Zettacast\Contract\Filesystem;

use Zettacast\Contract\Stream\StreamInterface;
use Zettacast\Contract\Collection\SequenceInterface;

/**
 * The disk interface is responsible for exposing mandatory methods a
 * Filesystem disk must have.
 * @package Zettacast\Filesystem
 */
interface DiskInterface
{
	/**
	 * Checks whether a path exists in the disk.
	 * @param string $path Path to be checked.
	 * @return bool Was the path found?
	 */
	public function has(string $path): bool;
	
	/**
	 * Removes a file from disk.
	 * @param string $path Path to file to be removed from disk.
	 * @return bool Was file or directory successfully removed?
	 */
	public function remove(string $path): bool;
	
	/**
	 * Creates a copy of a file in the given destiny path.
	 * @param string $path File to be copied.
	 * @param string $target Path to which copy is created.
	 * @return bool Was it possible to copy such the file?
	 */
	public function copy(string $path, string $target): bool;
	
	/**
	 * Returns metadata available for given path.
	 * @param string $path Target path for metadata request.
	 * @param string $data Specific data to be retrieved.
	 * @return mixed All metadata values or retrieved specific data.
	 */
	public function info(string $path = null, string $data = null);
	
	/**
	 * Checks whether the given path is a directory.
	 * @param string $path Path to be checked.
	 * @return bool Is path a directory?
	 */
	public function isDir(string $path): bool;
	
	/**
	 * Checks whether the given path is a file.
	 * @param string $path Path to be checked.
	 * @return bool Is path a file?
	 */
	public function isFile(string $path): bool;
	
	/**
	 * Creates a new directory into the disk.
	 * @param string $path Path of the directory to be created.
	 * @return bool Was the directory successfully created?
	 */
	public function mkdir(string $path): bool;
	
	/**
	 * Moves given file or directory to another location.
	 * @param string $path Target path, that will be moved.
	 * @param string $newpath The new name for target file or directory.
	 * @return bool Was the file or directory successfully moved?
	 */
	public function move(string $path, string $newpath): bool;
	
	/**
	 * Lists all files and directories contained in the given path.
	 * @param string $dir Path to be listed.
	 * @return SequenceInterface All directory contents in the path.
	 */
	public function list(string $dir = null): SequenceInterface;
	
	/**
	 * Opens a file as a directly editable stream.
	 * @param string $fname File to be opened.
	 * @param string $mode Reading/writing mode the file should be opened in.
	 * @return StreamInterface The directly editable file handler.
	 */
	public function open(string $fname, string $mode = 'r'): StreamInterface;
	
	/**
	 * Retrieves all contents from the given file.
	 * @param string $filename File to be read.
	 * @return string All file contents.
	 */
	public function read(string $filename);
	
	/**
	 * Retrieves contents from a file and puts it into a stream.
	 * @param string $file Source file to be read.
	 * @param resource|StreamInterface $stream Target to put content on.
	 * @param int $length Maximum number of bytes to be written to stream.
	 * @return int Length of data read from file.
	 */
	public function readTo(string $file, $stream, int $length = null): int;
	
	/**
	 * Removes a directory from disk.
	 * @param string $path Path to directory to be removed from disk.
	 * @return bool Was directory successfully removed?
	 */
	public function rmdir(string $path): bool;
	
	/**
	 * Appends the content to a file, that will be created if needed.
	 * @param string $filename Target file path to be written.
	 * @param mixed $content Content to be written to path.
	 * @return int Number of written characters.
	 */
	public function update(string $filename, $content): int;
	
	/**
	 * Retrieves content from stream and appends it to a file.
	 * @param resource|StreamInterface $stream Source to get content from.
	 * @param string $file Target file to be written to.
	 * @param int $length Maximum number of bytes to be written to file.
	 * @return int Total length of data written to file.
	 */
	public function updateFrom($stream, string $file, int $length = null): int;
	
	/**
	 * Writes the content to a file, that will be created if needed.
	 * @param string $filename Target file path to be written.
	 * @param mixed $content Content to be written to path.
	 * @return int Number of written characters.
	 */
	public function write(string $filename, $content): int;
	
	/**
	 * Retrieves content from stream and writes it to a file.
	 * @param resource|StreamInterface $stream Stream to get content from.
	 * @param string $file Target file to be written to.
	 * @param int $length Maximum number of bytes to be written to file.
	 * @return int Total length of data written to file.
	 */
	public function writeFrom($stream, string $file, int $length = null): int;
	
}