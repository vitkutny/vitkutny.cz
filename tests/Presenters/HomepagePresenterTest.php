<?php declare(strict_types = 1);

namespace Tests\Presenters;

use App\Presenters\HomepagePresenter;
use Nette\Application\IPresenterFactory;
use Nette\Application\Request;
use Nette\Application\Responses\TextResponse;
use Nette\Http\IRequest;
use PHPUnit\Framework\TestCase;
use Tests\BootstrapTest;
use Tests\ContactModule\ContactAvatarTest;
use Tests\ContactModule\ContactLinkTest;
use Tests\ContactModule\ContactTest;


final class HomepagePresenterTest extends TestCase
{

	private const NAME = 'Homepage';


	public function testCanSeeContact(): void
	{
		$request = new Request(self::NAME, IRequest::GET);
		$contact = ContactTest::createContact();
		$contact->setAvatar($avatar = ContactAvatarTest::createContactAvatar());
		$contact->addLink($link = ContactLinkTest::createContactLink());

		$presenter = $this->createPresenter();
		$presenter->injectContact($contact);
		/** @var TextResponse $response */
		$response = $presenter->run($request);

		$this->assertInstanceOf(TextResponse::class, $response);
		$source = (string) $response->getSource();
		$this->assertContains($contact->getName(), $source);
		$this->assertContains($contact->getPosition(), $source);
		$this->assertContains($contact->getAddress(), $source);
		$this->assertContains(sprintf('src="%s"', $avatar->getLink()), $source);
		$this->assertContains(sprintf('href="%s"', $link->getLink()), $source);
	}


	private function createPresenter(): HomepagePresenter
	{
		$container = BootstrapTest::createContainer();
		/** @var IPresenterFactory $presenterFactory */
		$presenterFactory = $container->getByType(IPresenterFactory::class);
		/** @var HomepagePresenter $presenter */
		$presenter = $presenterFactory->createPresenter(self::NAME);
		$presenter->autoCanonicalize = FALSE;

		return $presenter;
	}
}
