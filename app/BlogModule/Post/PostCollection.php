<?php declare(strict_types=1);

namespace App\BlogModule\Post;

use ArrayIterator;
use Iterator;
use IteratorAggregate;


final class PostCollection implements IteratorAggregate
{

	/**
	 * @var array
	 */
	private $posts = [];


	public function __construct(Post ...$posts)
	{
		$this->posts = $posts;
	}


	public function getIterator(): Iterator
	{
		return new ArrayIterator($this->posts);
	}

}
