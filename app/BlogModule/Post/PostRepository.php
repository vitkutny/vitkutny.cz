<?php declare(strict_types=1);

namespace App\BlogModule\Post;

use DateTimeImmutable;
use Nette\Utils\Finder;
use Parsedown;
use SplFileInfo;


final class PostRepository
{

	private const FILE_FORMAT = '%s.md';
	private const FILE_NAME_FORMAT = '%s/' . self::FILE_FORMAT;

	/**
	 * @var string
	 */
	private $directory;
	/**
	 * @var Parsedown
	 */
	private $parsedown;


	public function __construct(
		string $directory,
		Parsedown $parsedown
	) {
		$this->directory = $directory;
		$this->parsedown = $parsedown;
	}


	public function getById(string $id): ?Post
	{
		return $this->createPost(sprintf(self::FILE_NAME_FORMAT, $this->directory, $id));
	}


	public function findAll(): PostCollection
	{
		$posts = [];
		try {
			$files = iterator_to_array(Finder::findFiles(sprintf(self::FILE_FORMAT, '*'))->in($this->directory));
		} catch (\UnexpectedValueException $exception) {
			$files = [];
		}
		foreach (array_reverse($files) as $file) {
			if ($post = $this->createPost((string) $file)) {
				$posts[] = $post;
			}
		}

		return new PostCollection(...$posts);
	}


	private function createPost(string $filename): ?Post
	{
		$basename = basename($filename, sprintf(self::FILE_FORMAT, NULL));
		try {
			$datetime = new DateTimeImmutable(substr($basename, 0, 10));
		} catch (\Exception $exception) {
			return NULL;
		}
		try {
			$file = (new SplFileInfo($filename))->openFile();
		} catch (\RuntimeException $exception) {
			return NULL;
		}
		$title = '';
		$perex = '';
		$dom = new \DOMDocument;
		$dom->loadHTML($this->parsedown->text(implode(NULL, iterator_to_array($file))));
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

		return new Post(
			$basename,
			$datetime,
			utf8_decode($title),
			utf8_decode($perex),
			utf8_decode($content)
		);
	}

}
