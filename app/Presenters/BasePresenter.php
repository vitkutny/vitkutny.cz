<?php declare(strict_types = 1);

namespace App\Presenters;

use App\ContactModule;
use App\DisqusModule;


trait BasePresenter
{

	use ContactModule\Presenters\BasePresenter;
	use DisqusModule\Presenters\BasePresenter;
}
