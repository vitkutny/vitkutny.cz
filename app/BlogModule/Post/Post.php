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


	public function __construct(string $id, DateTimeImmutable $datetime, string $title, string $perex, string $content)
	{
		$this->id = $id;
		$this->datetime = $datetime;
		$this->title = $title;
		$this->perex = $perex;
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


	public function __toString(): string
	{
		return $this->getId();
	}
}
