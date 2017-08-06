<?php declare(strict_types = 1);

namespace Tests\ContactModule;

use App\ContactModule\ContactLink;
use PHPUnit\Framework\TestCase;


final class ContactLinkTest extends TestCase
{

	private const NAME = 'name';
	private const LINK = 'link';
	private const ICON = 'icon';


	public static function createContactLink(): ContactLink
	{
		return new ContactLink(self::NAME, self::LINK, self::ICON);
	}


	public function test(): void
	{
		$link = self::createContactLink();
		$this->assertSame(self::NAME, $link->getName());
		$this->assertSame(self::LINK, $link->getLink());
		$this->assertSame(self::ICON, $link->getIcon());
	}
}
