<?php declare(strict_types = 1);

namespace Tests\BlogModule\Post;

use App\BlogModule\Post\Post;
use PHPUnit\Framework\TestCase;


final class PostTest extends TestCase
{

	private const ID = 'id';
	private const DATETIME = '2017-01-01';


	public static function createPost(): Post
	{
		return new Post(self::ID, new \DateTimeImmutable(self::DATETIME), PostContentTest::createContent());
	}


	public function test(): void
	{
		$post = $this->createPost();
		$this->assertSame(self::ID, $post->getId());
		$this->assertSame(self::ID, $post->__toString());
		$this->assertSame(self::DATETIME, $post->getDatetime()->format('Y-m-d'));

		$postContent = PostContentTest::createContent();
		$this->assertSame($postContent->getTitle(), $post->getTitle());
		$this->assertSame($postContent->getPerex(), $post->getPerex());
		$this->assertSame($postContent->getContent(), $post->getContent());
	}
}
