<?php declare(strict_types=1);

namespace App\Contact;

final class Contact
{

	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $position;
	/**
	 * @var string
	 */
	private $address;
	/**
	 * @var ContactLink[]
	 */
	private $links = [];


	public function __construct(string $name, string $position, string $address)
	{
		$this->name = $name;
		$this->position = $position;
		$this->address = $address;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getPosition(): string
	{
		return $this->position;
	}


	public function getAddress(): string
	{
		return $this->address;
	}


	public function addLink(ContactLink $link): void
	{
		$this->links[] = $link;
	}


	/**
	 * @return ContactLink[]
	 */
	public function getLinks(): array
	{
		return $this->links;
	}

}
