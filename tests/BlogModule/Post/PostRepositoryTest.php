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

	public static function createPostRepository(string $directory = __DIR__): PostRepository
	{
		return new PostRepository(
			sprintf('%s/%s', $directory, (new ReflectionClass(self::class))->getShortName()),
			$htmlPostContentParser = new HtmlPostContentParser,
			new MarkdownPostContentParser(new \Parsedown(), $htmlPostContentParser)
		);
	}


	public function testCanGetById(): void
	{
		$postRepository = self::createPostRepository();

		$newYearPost = $postRepository->getById('2017/01/01/new-year');
		if ($newYearPost) {
			$this->assertEquals('2017/01/01/new-year', $newYearPost->getId());
			$this->assertEquals('2017-01-01', $newYearPost->getDatetime()->format('Y-m-d'));
			$this->assertEquals('Happy new year!', $newYearPost->getTitle());
			$this->assertEquals('Perex', $newYearPost->getPerex());
			$this->assertEquals('<p>Content</p>', $newYearPost->getContent());
		}
		$this->assertInstanceOf(Post::class, $newYearPost);

		$birthdayPost = $postRepository->getById('2017/05/24/birthday');
		if ($birthdayPost) {
			$this->assertEquals('2017/05/24/birthday', $birthdayPost->getId());
			$this->assertEquals('2017-05-24', $birthdayPost->getDatetime()->format('Y-m-d'));
			$this->assertEquals('Happy birthday!', $birthdayPost->getTitle());
			$this->assertEquals('Perex', $birthdayPost->getPerex());
			$this->assertEquals('<p>Content</p>', $birthdayPost->getContent());
		}
		$this->assertInstanceOf(Post::class, $birthdayPost);

		$christmasPost = $postRepository->getById('2017/12/24/christmas');
		if ($christmasPost) {
			$this->assertEquals('2017/12/24/christmas', $christmasPost->getId());
			$this->assertEquals('2017-12-24', $christmasPost->getDatetime()->format('Y-m-d'));
			$this->assertEquals('Merry christmas!', $christmasPost->getTitle());
			$this->assertEquals('Perex', $christmasPost->getPerex());
			$this->assertEquals('<p>Content</p>', $christmasPost->getContent());
		}
		$this->assertInstanceOf(Post::class, $christmasPost);
	}


	public function testCannotGetById(): void
	{
		$postRepository = self::createPostRepository();
		$this->assertNull($postRepository->getById('0000/00/00/zero'));
		$postRepository = self::createPostRepository();
		$this->assertNull($postRepository->getById('not-categorized'));
	}


	public function testCanFindAll(): void
	{
		$postRepository = self::createPostRepository();
		$posts = $postRepository->findAll();

		$this->assertInstanceOf(PostCollection::class, $posts);
		$this->assertCount(3, $posts);
	}


	public function testCannotFindAll(): void
	{
		$postRepository = self::createPostRepository(sprintf('%s/undefined', __DIR__));
		$posts = $postRepository->findAll();

		$this->assertInstanceOf(PostCollection::class, $posts);
		$this->assertCount(0, $posts);
	}


	public function testCanOrderFindAll(): void
	{
		$postRepository = self::createPostRepository();

		/** @var \DateTimeInterface $datetime */
		$datetime = NULL;
		foreach ($postRepository->findAll() as $post) {
			if ($datetime) {
				$this->assertLessThan($datetime->getTimestamp(), $post->getDatetime()->getTimestamp());
			}
			$datetime = $post->getDatetime();
		}
	}
}
