<?php declare(strict_types = 1);

namespace App\BlogModule\Post;

use DOMDocument;
use Parsedown;


final class PostContentParser
{

	private const TAG_TITLE = 'h1';
	private const TAG_PEREX = 'p';
	private const HTML_BEGIN = '<html><body>';
	private const HTML_END = '</body></html>';

	/**
	 * @var Parsedown
	 */
	private $parsedown;


	public function __construct(
		Parsedown $parsedown
	) {
		$this->parsedown = $parsedown;
	}


	public function parseHtml(string $html): PostContent
	{
		$document = new DOMDocument;
		$document->loadHTML($html);

		$title = $this->parseTagFromDocument(self::TAG_TITLE, $document);
		$perex = $this->parseTagFromDocument(self::TAG_PEREX, $document);

		$content = $document->saveHTML($document->documentElement);
		$content = substr($content, strlen(self::HTML_BEGIN), -strlen(self::HTML_END));

		return new PostContent(
			utf8_decode($title),
			utf8_decode($perex),
			utf8_decode($content)
		);
	}


	public function parseMarkdown(string $markdown): PostContent
	{
		return $this->parseHtml($this->parsedown->text($markdown));
	}


	private function parseTagFromDocument(string $name, DOMDocument $document): string
	{
		if ( ! $tag = $document->getElementsByTagName($name)->item(0)) {
			return '';
		}
		$tag->parentNode->removeChild($tag);

		return $tag->nodeValue;
	}
}
