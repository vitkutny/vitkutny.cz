<?php declare(strict_types = 1);

namespace Tests\BlogModule\Presenters;

use App\BlogModule\Presenters\PostPresenter;
use Nette\Application\BadRequestException;
use Nette\Application\IPresenterFactory;
use Nette\Application\Request;
use Nette\Application\Responses\TextResponse;
use Nette\Http\IRequest;
use PHPUnit\Framework\TestCase;
use Tests\BlogModule\Post\PostTest;
use Tests\BootstrapTest;


final class PostPresenterTest extends TestCase
{

	private const NAME = 'Blog:Post';


	public function testCanSeePost(): void
	{
		$post = PostTest::createPost();
		$request = new Request(self::NAME, IRequest::GET, ['post' => $post]);
		/** @var TextResponse $response */
		$response = $this->createPresenter()->run($request);
		$this->assertInstanceOf(TextResponse::class, $response);
		$source = (string) $response->getSource();
		$this->assertContains($post->getTitle(), $source);
		$this->assertContains($post->getPerex(), $source);
		$this->assertContains($post->getDatetime()->format('Y-m-d'), $source);
		$this->assertContains($post->getContent(), $source);
	}


	public function testCannotSeePost(): void
	{
		$request = new Request(self::NAME, IRequest::GET);
		$this->expectException(BadRequestException::class);
		$this->createPresenter()->run($request);
	}


	private function createPresenter(): PostPresenter
	{
		$container = BootstrapTest::createContainer();
		/** @var IPresenterFactory $presenterFactory */
		$presenterFactory = $container->getByType(IPresenterFactory::class);
		/** @var PostPresenter $presenter */
		$presenter = $presenterFactory->createPresenter(self::NAME);
		$presenter->autoCanonicalize = FALSE;

		return $presenter;
	}

}
