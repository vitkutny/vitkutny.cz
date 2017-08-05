<?php declare(strict_types = 1);

namespace App\BlogModule\Post;

final class PostContent
{

	/**
	 * @var string
	 */
	private $title;
	/**
	 * @var string
	 */
	private $perex;
	/**
	 * @var string
	 */
	private $content;


	public function __construct(string $title, string $perex, string $content)
	{
		$this->title = $title;
		$this->perex = $perex;
		$this->content = $content;
	}


	public function getTitle(): string
	{
		return $this->title;
	}


	public function getPerex(): string
	{
		return $this->perex;
	}


	public function getContent(): string
	{
		return $this->content;
	}

}
