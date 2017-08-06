<?php declare(strict_types = 1);

namespace Tests\Presenters;

use App\BlogModule\Post\PostRepository;
use App\Presenters\HomepagePresenter;
use Nette\Application\IPresenterFactory;
use Nette\Application\Request;
use Nette\Application\Responses\TextResponse;
use Nette\DI\Container;
use Nette\Http\IRequest;
use PHPUnit\Framework\TestCase;
use Tests\BlogModule\Post\PostRepositoryTest;
use Tests\BootstrapTest;
use Tests\ContactModule\ContactAvatarTest;
use Tests\ContactModule\ContactLinkTest;
use Tests\ContactModule\ContactTest;


final class HomepagePresenterTest extends TestCase
{

	private const NAME = 'Homepage';


	public function testCanSeeContact(): void
	{
		$contact = ContactTest::createContact();
		$contact->setAvatar($avatar = ContactAvatarTest::createContactAvatar());
		$contact->addLink($link = ContactLinkTest::createContactLink());

		$presenter = $this->createPresenter();
		$presenter->injectContact($contact);
		/** @var TextResponse $response */
		$response = $presenter->run(new Request(self::NAME, IRequest::GET));

		$this->assertInstanceOf(TextResponse::class, $response);
		$source = (string) $response->getSource();
		$this->assertContains($contact->getName(), $source);
		$this->assertContains($contact->getPosition(), $source);
		$this->assertContains($contact->getAddress(), $source);
		$this->assertContains(sprintf('src="%s"', $avatar->getLink()), $source);
		$this->assertContains(sprintf('href="%s"', $link->getLink()), $source);
	}


	public function testCanSeePosts(): void
	{
		$container = BootstrapTest::createContainer();
		$serviceName = current($container->findByType(PostRepository::class));
		$this->assertInternalType('string', $serviceName);
		$container->removeService($serviceName);
		$container->addService($serviceName, $postRepository = PostRepositoryTest::createPostRepository());

		$presenter = $this->createPresenter($container);
		/** @var TextResponse $response */
		$response = $presenter->run(new Request(self::NAME, IRequest::GET));

		$this->assertInstanceOf(TextResponse::class, $response);
		$source = (string) $response->getSource();

		$posts = $postRepository->findAll();
		$this->assertGreaterThan(0, iterator_count($posts));
		foreach ($posts as $post) {
			$this->assertContains(sprintf('href="%s"', $presenter->link(':Blog:Post:', ['post' => $post])), $source);
			$this->assertContains($post->getTitle(), $source);
			$this->assertContains($post->getPerex(), $source);
		}
	}


	private function createPresenter(Container $container = NULL): HomepagePresenter
	{
		if ( ! $container) {
			$container = BootstrapTest::createContainer();
		}
		/** @var IPresenterFactory $presenterFactory */
		$presenterFactory = $container->getByType(IPresenterFactory::class);
		/** @var HomepagePresenter $presenter */
		$presenter = $presenterFactory->createPresenter(self::NAME);
		$presenter->autoCanonicalize = FALSE;

		return $presenter;
	}
}
