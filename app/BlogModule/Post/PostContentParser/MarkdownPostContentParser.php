<?php declare(strict_types = 1);

namespace App\BlogModule\Post\PostContentParser;

use App\BlogModule\Post\PostContent;
use App\BlogModule\Post\PostContentParser;
use Parsedown;


final class MarkdownPostContentParser implements PostContentParser
{

	private const EXTENSION = 'md';

	/**
	 * @var Parsedown
	 */
	private $parsedown;
	/**
	 * @var HtmlPostContentParser
	 */
	private $htmlPostContentParser;


	public function __construct(Parsedown $parsedown, HtmlPostContentParser $htmlPostContentParser)
	{
		$this->parsedown = $parsedown;
		$this->htmlPostContentParser = $htmlPostContentParser;
	}


	public function parse(string $content): PostContent
	{
		return $this->htmlPostContentParser->parse($this->parsedown->text($content));
	}


	public function getExtension(): string
	{
		return self::EXTENSION;
	}
}
