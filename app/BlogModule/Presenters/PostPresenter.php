<?php declare(strict_types=1);

namespace App\BlogModule\Presenters;

use App\BlogModule\Controls\PostInfoControl;
use App\BlogModule\Controls\PostInfoControlFactory;
use App\BlogModule\Post\Post;
use App\BlogModule\Post\PostRepository;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\Template;


final class PostPresenter extends Presenter
{

	use BasePresenter;

	/**
	 * @var PostRepository
	 */
	private $postRepository;
	/**
	 * @var Post
	 */
	private $post;
	/**
	 * @var PostInfoControlFactory
	 */
	private $postInfoControlFactory;


	public function __construct(
		PostRepository $postRepository,
		PostInfoControlFactory $postInfoControlFactory
	) {
		parent::__construct();
		$this->postRepository = $postRepository;
		$this->postInfoControlFactory = $postInfoControlFactory;
	}


	public function actionDefault(Post $post): void
	{
		$this->post = $post;
	}


	public function renderDefault(): void
	{
		/**
		 * @var Template $template
		 */
		$template = $this->getTemplate();
		$template->add('post', $this->post);
	}


	protected function createComponentPostInfo(): PostInfoControl
	{
		return $this->postInfoControlFactory->create();
	}
}
