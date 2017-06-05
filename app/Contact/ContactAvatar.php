<?php declare(strict_types=1);

namespace App\Contact;

final class ContactAvatar
{

	/**
	 * @var string
	 */
	private $link;
	/**
	 * @var int
	 */
	private $size;


	public function __construct(string $link, int $size)
	{
		$this->link = $link;
		$this->size = $size;
	}


	public function getLink(): string
	{
		return $this->link;
	}


	public function getSize(): int
	{
		return $this->size;
	}

}
