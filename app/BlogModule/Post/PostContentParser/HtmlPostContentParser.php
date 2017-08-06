<?php declare(strict_types = 1);

namespace App\BlogModule\Post\PostContentParser;

use App\BlogModule\Post\PostContent;
use App\BlogModule\Post\PostContentParser;
use DOMDocument;


final class HtmlPostContentParser implements PostContentParser
{

	private const EXTENSION = 'html';
	private const TAG_TITLE = 'h1';
	private const TAG_PEREX = 'p';
	private const HTML_BEGIN = '<html><body>';
	private const HTML_END = '</body></html>';


	public function parse(string $content): PostContent
	{
		$document = new DOMDocument;
		if ($content) {
			$document->loadHTML($content);
		}

		$title = $this->parseTagFromDocument(self::TAG_TITLE, $document);
		$perex = $this->parseTagFromDocument(self::TAG_PEREX, $document);

		if ($content) {
			$content = $document->saveHTML($document->documentElement);
			$content = substr($content, strlen(self::HTML_BEGIN), -strlen(self::HTML_END));
		}

		return new PostContent(
			utf8_decode($title),
			utf8_decode($perex),
			utf8_decode($content)
		);
	}


	public function getExtension(): string
	{
		return self::EXTENSION;
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
