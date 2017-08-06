<?php declare(strict_types = 1);

namespace Tests\ContactModule;

use App\ContactModule\Contact;
use PHPUnit\Framework\TestCase;


final class ContactTest extends TestCase
{

	private const NAME = 'name';
	private const POSITION = 'position';
	private const ADDRESS = 'address';


	public static function createContact(): Contact
	{
		return new Contact(self::NAME, self::POSITION, self::ADDRESS);
	}


	public function test(): void
	{
		$contact = self::createContact();
		$this->assertEquals(self::NAME, $contact->getName());
		$this->assertEquals(self::POSITION, $contact->getPosition());
		$this->assertEquals(self::ADDRESS, $contact->getAddress());
		$this->assertNull($contact->getAvatar());
		$this->assertEmpty($contact->getLinks());

		$contact->setAvatar($avatar = ContactAvatarTest::createContactAvatar());
		$this->assertSame($avatar, $contact->getAvatar());

		$contact->addLink($link = ContactLinkTest::createContactLink());
		$this->assertSame([$link], $contact->getLinks());
	}
}
