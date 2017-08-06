<?php declare(strict_types = 1);

namespace Tests\BlogModule\Post;

use App\BlogModule\Post\Post;
use App\BlogModule\Post\PostCollection;
use App\BlogModule\Post\PostContentParser\HtmlPostContentParser;
use App\BlogModule\Post\PostContentParser\MarkdownPostContentParser;
use App\BlogModule\Post\PostRepository;
use PHPUnit\Framework\TestCase;
use ReflectionClass;


final class PostRepositoryTest extends TestCase
{

	public function testCanGetById(): void
	{
		$postRepository = $this->createPostRepository();

		$newYearPost = $postRepository->getById('2017-01-01-new-year');
		if ($newYearPost) {
			$this->assertEquals('2017-01-01-new-year', $newYearPost->getId());
			$this->assertEquals('2017-01-01', $newYearPost->getDatetime()->format('Y-m-d'));
		}
		$this->assertInstanceOf(Post::class, $newYearPost);

		$birthdayPost = $postRepository->getById('2017-05-24-birthday');
		if ($birthdayPost) {
			$this->assertEquals('2017-05-24-birthday', $birthdayPost->getId());
			$this->assertEquals('2017-05-24', $birthdayPost->getDatetime()->format('Y-m-d'));
		}
		$this->assertInstanceOf(Post::class, $birthdayPost);

		$christmasPost = $postRepository->getById('2017-12-24-christmas');
		if ($christmasPost) {
			$this->assertEquals('2017-12-24-christmas', $christmasPost->getId());
			$this->assertEquals('2017-12-24', $christmasPost->getDatetime()->format('Y-m-d'));
		}
		$this->assertInstanceOf(Post::class, $christmasPost);
	}


	public function testCannotGetById(): void
	{
		$postRepository = $this->createPostRepository();
		$this->assertNull($postRepository->getById('0000-00-00-zero'));
	}


	public function testCanFindAll(): void
	{
		$postRepository = $this->createPostRepository();
		$posts = $postRepository->findAll();

		$this->assertInstanceOf(PostCollection::class, $posts);
		$this->assertCount(3, $posts);
	}


	public function testCannotFindAll(): void
	{
		$postRepository = $this->createPostRepository(sprintf('%s/undefined', __DIR__));
		$posts = $postRepository->findAll();

		$this->assertInstanceOf(PostCollection::class, $posts);
		$this->assertCount(0, $posts);
	}


	public function testCanOrderFindAll(): void
	{
		$postRepository = $this->createPostRepository();

		/** @var \DateTimeInterface $datetime */
		$datetime = NULL;
		foreach ($postRepository->findAll() as $post) {
			if ($datetime) {
				$this->assertLessThan($datetime->getTimestamp(), $post->getDatetime()->getTimestamp());
			}
			$datetime = $post->getDatetime();
		}
	}


	private function createPostRepository(string $directory = __DIR__): PostRepository
	{
		return new PostRepository(
			sprintf('%s/%s', $directory, (new ReflectionClass(self::class))->getShortName()),
			$htmlPostContentParser = new HtmlPostContentParser,
			new MarkdownPostContentParser(new \Parsedown(), $htmlPostContentParser)
		);
	}
}
