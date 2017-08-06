<?php declare(strict_types = 1);

namespace Tests\BlogModule\Post\PostContentParser;

use App\BlogModule\Post\PostContentParser\HtmlPostContentParser;
use PHPUnit\Framework\TestCase;


final class HtmlPostContentParserTest extends TestCase
{

	public function testCanParse(): void
	{
		$postContentParser = new HtmlPostContentParser;
		$postContent = $postContentParser->parse('<h1>Title</h1><p>Perex</p><p>Content</p>');
		$this->assertEquals('Title', $postContent->getTitle());
		$this->assertEquals('Perex', $postContent->getPerex());
		$this->assertEquals('<p>Content</p>', $postContent->getContent());
	}


	public function testCanParseTitle(): void
	{
		$postContentParser = new HtmlPostContentParser;
		$postContent = $postContentParser->parse('<h1>Title</h1><h1>Another title</h1>');
		$this->assertEquals('Title', $postContent->getTitle());
		$this->assertEquals('', $postContent->getPerex());
		$this->assertEquals('<h1>Another title</h1>', $postContent->getContent());
	}


	public function testCanParsePerex(): void
	{
		$postContentParser = new HtmlPostContentParser;
		$postContent = $postContentParser->parse('<p>Perex</p><p>Content</p>');
		$this->assertEquals('', $postContent->getTitle());
		$this->assertEquals('Perex', $postContent->getPerex());
		$this->assertEquals('<p>Content</p>', $postContent->getContent());
	}


	public function testCanParseEmpty(): void
	{
		$postContentParser = new HtmlPostContentParser;
		$postContent = $postContentParser->parse('');
		$this->assertEquals('', $postContent->getTitle());
		$this->assertEquals('', $postContent->getPerex());
		$this->assertEquals('', $postContent->getContent());
	}

}
