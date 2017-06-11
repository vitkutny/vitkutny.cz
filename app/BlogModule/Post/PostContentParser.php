<?php declare(strict_types=1);

namespace App\BlogModule\Post;

use DOMDocument;
use Parsedown;


final class PostContentParser
{

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
		$title = '';
		$perex = '';
		$dom = new DOMDocument;
		$dom->loadHTML($html);
		if ($h1 = $dom->getElementsByTagName('h1')->item(0)) {
			$title = $h1->nodeValue;
			$h1->parentNode->removeChild($h1);
		}
		if ($p = $dom->getElementsByTagName('p')->item(0)) {
			$perex = $p->nodeValue;
			$p->parentNode->removeChild($p);
		}
		$content = $dom->saveHTML($dom->documentElement);
		$content = substr($content, strlen('<html><body>'), -strlen('</body></html>'));

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
}
