<?php declare(strict_types = 1);

namespace App\BlogModule\Post;

use DateTimeImmutable;
use Nette\Utils\Finder;
use SplFileInfo;


final class PostRepository
{

	private const FILE_FORMAT = '%s.md';
	private const FILE_NAME_FORMAT = '%s/' . self::FILE_FORMAT;
	private const FILE_DATETIME_PATTERN = '#^\d{4}-\d{2}-\d{2}#';

	/**
	 * @var string
	 */
	private $directory;
	/**
	 * @var PostContentParser
	 */
	private $postContentParser;


	public function __construct(
		string $directory,
		PostContentParser $postContentParser
	) {
		$this->directory = $directory;
		$this->postContentParser = $postContentParser;
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
		try {
			$file = (new SplFileInfo($filename))->openFile();
		} catch (\RuntimeException $exception) {
			return NULL;
		}
		if ( ! $content = trim(implode(NULL, iterator_to_array($file)))) {
			return NULL;
		}

		return new Post(
			basename($filename, sprintf(self::FILE_FORMAT, NULL)),
			new DateTimeImmutable(preg_match(self::FILE_DATETIME_PATTERN, $filename, $matches) ? current($matches) : 'now'),
			$this->postContentParser->parseMarkdown($content)
		);
	}

}
