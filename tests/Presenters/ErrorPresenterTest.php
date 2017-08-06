<?php declare(strict_types = 1);

namespace Tests\Presenters;

use App\Presenters\ErrorPresenter;
use Exception;
use Nette\Application\IPresenterFactory;
use Nette\Application\Request;
use Nette\Application\Responses\TextResponse;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use PHPUnit\Framework\TestCase;
use Tests\BootstrapTest;


final class ErrorPresenterTest extends TestCase
{

	private const NAME = 'Error';


	public function testCanSeePageNotFound(): void
	{
		$request = new Request(self::NAME, IRequest::GET, ['exception' => new Exception('', IResponse::S404_NOT_FOUND)]);
		/** @var TextResponse $response */
		$response = $this->createPresenter()->run($request);

		$this->assertInstanceOf(TextResponse::class, $response);
		$source = (string) $response->getSource();
		$this->assertContains('Page Not Found', $source);
		$this->assertContains('error 404', $source);
	}


	public function testCanSeeServerError(): void
	{
		$request = new Request(self::NAME, IRequest::GET, ['exception' => new Exception('', IResponse::S500_INTERNAL_SERVER_ERROR)]);
		/** @var TextResponse $response */
		$response = $this->createPresenter()->run($request);

		$this->assertInstanceOf(TextResponse::class, $response);
		$source = (string) $response->getSource();
		$this->assertContains('Server Error', $source);
		$this->assertContains('error 500', $source);
	}


	public function testCanSeeDefaultError(): void
	{
		$request = new Request(self::NAME, IRequest::GET, ['exception' => new Exception]);
		/** @var TextResponse $response */
		$response = $this->createPresenter()->run($request);

		$this->assertInstanceOf(TextResponse::class, $response);
		$source = (string) $response->getSource();
		$this->assertContains('Server Error', $source);
		$this->assertContains('error 500', $source);
	}


	private function createPresenter(): ErrorPresenter
	{
		$container = BootstrapTest::createContainer();
		/** @var IPresenterFactory $presenterFactory */
		$presenterFactory = $container->getByType(IPresenterFactory::class);
		/** @var ErrorPresenter $presenter */
		$presenter = $presenterFactory->createPresenter(self::NAME);
		$presenter->autoCanonicalize = FALSE;

		return $presenter;
	}
}
