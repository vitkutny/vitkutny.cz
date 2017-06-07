<?php declare(strict_types=1);

namespace App\Contact;

final class ContactAvatar
{

	/**
	 * @var string
	 */
	private $link;


	public function __construct(string $link)
	{
		$this->link = $link;
	}


	public function getLink(): string
	{
		return $this->link;
	}

}
