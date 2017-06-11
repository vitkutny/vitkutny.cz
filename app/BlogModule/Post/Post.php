<?php declare(strict_types=1);

namespace App\BlogModule\Post;

use DateTimeImmutable;


final class Post
{

	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var DateTimeImmutable
	 */
	private $datetime;
	/**
	 * @var PostContent
	 */
	private $content;


	public function __construct(string $id, DateTimeImmutable $datetime, PostContent $content)
	{
		$this->id = $id;
		$this->datetime = $datetime;
		$this->content = $content;
	}


	public function getId(): string
	{
		return $this->id;
	}


	public function getDatetime(): DateTimeImmutable
	{
		return $this->datetime;
	}


	public function getTitle(): string
	{
		return $this->content->getTitle();
	}


	public function getPerex(): string
	{
		return $this->content->getPerex();
	}


	public function getContent(): string
	{
		return $this->content->getContent();
	}


	public function __toString(): string
	{
		return $this->getId();
	}
}
