<?php declare(strict_types = 1);

namespace App\BlogModule\Post;

interface PostContentParser
{

	public function parse(string $content): PostContent;


	public function getExtension(): string;
}
