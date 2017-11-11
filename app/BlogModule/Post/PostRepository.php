<?php declare(strict_types = 1);

namespace App\BlogModule\Post;

use DateTimeImmutable;
use Nette\Utils\Finder;
use SplFileInfo;


final class PostRepository
{

	private const BASENAME_PATTERN = '[a-z-]+';
	private const DATE_PATTERN = '\d{4}/\d{2}/\d{2}';
	private const FILE_PATTERN = '(?<id>(?<date>' . self::DATE_PATTERN . ')/' . self::BASENAME_PATTERN . ')';
	public const ROUTE_PATTERN = self::DATE_PATTERN . '/' . self::BASENAME_PATTERN;

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
			$files = iterator_to_array(Finder::findFiles('*/*/*/*')->from($this->directory));
		} catch (\UnexpectedValueException $exception) {
			$files = []; //failed to open dir
		}
		$posts = [];
		/** @var SplFileInfo $file */
		foreach ($files as $file) {
			$postContentParser = $this->postContentParsers[$file->getExtension()] ?? NULL;
			if ($postContentParser) {
				$post = $this->createPost($file, $postContentParser);
				if ($post) {
					$posts[$post->getId()] = $post;
				}
			}
		}
		krsort($posts);

		return new PostCollection(...array_values($posts));
	}


	private function createPost(SplFileInfo $file, PostContentParser $postContentParser): ?Post
	{
		$pattern = sprintf('#%s.%s$#', self::FILE_PATTERN, preg_quote($postContentParser->getExtension(), '#'));
		if ( ! preg_match($pattern, $file->getPathname(), $matches)) {
			return NULL;
		}

		return new Post(
			$matches['id'],
			new DateTimeImmutable($matches['date']),
			$postContentParser->parse(trim(implode(NULL, iterator_to_array($file->openFile()))))
		);
	}

}
