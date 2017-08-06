<?php declare(strict_types = 1);

namespace Tests\BlogModule\Post;

use App\BlogModule\Post\PostContent;
use PHPUnit\Framework\TestCase;


final class PostContentTest extends TestCase
{

	private const CONTENT_TITLE = 'title';
	private const CONTENT_PEREX = 'perex';
	private const CONTENT_CONTENT = 'content';


	public static function createContent(): PostContent
	{
		return new PostContent(self::CONTENT_TITLE, self::CONTENT_PEREX, self::CONTENT_CONTENT);
	}


	public function test(): void
	{
		$content = $this->createContent();

		$this->assertSame(self::CONTENT_TITLE, $content->getTitle());
		$this->assertSame(self::CONTENT_PEREX, $content->getPerex());
		$this->assertSame(self::CONTENT_CONTENT, $content->getContent());
	}
}
