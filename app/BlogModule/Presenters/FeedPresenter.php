<?php declare(strict_types = 1);

namespace App\BlogModule\Presenters;

use App\BlogModule\Post\PostRepository;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\Template;


final class FeedPresenter extends Presenter
{

	/**
	 * @var PostRepository
	 */
	private $postRepository;


	public function __construct(
		PostRepository $postRepository
	) {
		parent::__construct();
		$this->postRepository = $postRepository;
	}


	public function renderDefault(): void
	{
		/**
		 * @var Template $template
		 */
		$template = $this->getTemplate();
		$template->setParameters([
			'posts' => $this->postRepository->findAll(),
		]);
	}
}
