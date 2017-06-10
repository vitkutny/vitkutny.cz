<?php declare(strict_types=1);

namespace App\BlogModule\Controls;

interface PostListControlFactory
{

	public function create(): PostListControl;
}
