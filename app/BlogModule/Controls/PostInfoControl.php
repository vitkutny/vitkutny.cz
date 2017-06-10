<?php declare(strict_types=1);

namespace App\BlogModule\Controls;

use App\BlogModule\Post\Post;
use Nette\Application\UI\Control;


final class PostInfoControl extends Control
{

	public function render(Post $post): void
	{
		$template = $this->getTemplate();
		$template->post = $post;
		$template->setFile(__DIR__ . '/templates/postInfo.latte');
		$template->render();
	}
}
