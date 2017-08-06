<?php declare(strict_types = 1);

namespace App\BlogModule\Post;

use DateTimeImmutable;
use Nette\Utils\Finder;
use SplFileInfo;


final class PostRepository
{

	private const DATETIME_PATTERN = '#^\d{4}-\d{2}-\d{2}#';

	/**
	 * @var string
	 */
	private $directory;
	/**
	 * @var array|PostContentParser[]
	 */
	private $postContentParsers = [];


	public function __construct(
		string $directory,
		PostContentParser ...$postContentParsers
	) {
		$this->directory = $directory;
		foreach ($postContentParsers as $postContentParser) {
			$this->postContentParsers[$postContentParser->getExtension()] = $postContentParser;
		}
	}


	public function getById(string $id): ?Post
	{
		foreach ($this->postContentParsers as $extension => $postContentParser) {
			$filename = sprintf('%s/%s.%s', $this->directory, $id, $extension);
			if (file_exists($filename)) {
				return $this->createPost(new SplFileInfo($filename), $postContentParser);
			}
		}

		return NULL;
	}


	public function findAll(): PostCollection
	{
		try {
			$files = iterator_to_array(Finder::findFiles('*')->in($this->directory));
		} catch (\UnexpectedValueException $exception) {
			$files = []; //failed to open dir
		}
		$posts = [];
		/** @var SplFileInfo $file */
		foreach ($files as $file) {
			$postContentParser = $this->postContentParsers[$file->getExtension()] ?? NULL;
			if ($postContentParser) {
				$posts[$file->getBasename()] = $this->createPost($file, $postContentParser);
			}
		}
		krsort($posts);

		return new PostCollection(...array_values($posts));
	}


	private function createPost(SplFileInfo $file, PostContentParser $postContentParser): Post
	{
		$id = $file->getBasename(sprintf('.%s', $file->getExtension()));
		$datetime = new DateTimeImmutable(preg_match(self::DATETIME_PATTERN, $id, $matches) ? current($matches) : 'now');
		$content = trim(implode(NULL, iterator_to_array($file->openFile())));

		return new Post($id, $datetime, $postContentParser->parse($content));
	}

}
