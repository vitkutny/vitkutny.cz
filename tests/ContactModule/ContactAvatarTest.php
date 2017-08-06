<?php declare(strict_types = 1);

namespace Tests\ContactModule;

use App\ContactModule\ContactAvatar;
use PHPUnit\Framework\TestCase;


final class ContactAvatarTest extends TestCase
{

	private const LINK = 'link';


	public static function createAvatar(): ContactAvatar
	{
		return new ContactAvatar(self::LINK);
	}


	public function test(): void
	{
		$avatar = $this->createAvatar();
		$this->assertSame(self::LINK, $avatar->getLink());
	}

}
