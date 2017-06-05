<?php declare(strict_types=1);

namespace App\Contact;

final class ContactLink
{

	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $link;
	/**
	 * @var string
	 */
	private $icon;


	public function __construct(string $name, string $link, string $icon)
	{
		$this->name = $name;
		$this->link = $link;
		$this->icon = $icon;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getLink(): string
	{
		return $this->link;
	}


	public function getIcon(): string
	{
		return $this->icon;
	}

}
