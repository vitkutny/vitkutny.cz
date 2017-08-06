<?php declare(strict_types = 1);

namespace Tests\BlogModule\Post;

use App\BlogModule\Post\PostCollection;
use PHPUnit\Framework\TestCase;


final class PostCollectionTest extends TestCase
{

	public function test(): void
	{
		$posts = [];
		$collection = new PostCollection(...$posts);
		$this->assertSame($posts, iterator_to_array($collection));

		$posts = [PostTest::createPost(), PostTest::createPost(), PostTest::createPost()];
		$collection = new PostCollection(...$posts);
		$this->assertSame($posts, iterator_to_array($collection));
	}
}
