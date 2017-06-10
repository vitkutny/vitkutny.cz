<?php declare(strict_types=1);

namespace App\BlogModule\Post;

use ArrayObject;


final class PostCollection extends ArrayObject
{

	public function __construct(Post ...$posts)
	{
		parent::__construct($posts);
	}
}
