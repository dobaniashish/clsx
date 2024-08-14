<?php

use PHPUnit\Framework\TestCase;
use Dobaniashish\Clsx\Clsx;

final class MergeTest extends TestCase
{
	public function testValueWithArray(): void
	{
		$expecter_attrs = [
			'class' => [
				'foo' => true,
				'bar' => false,
				'baz' => true,
			]
		];

		$attrs = [
			'class' => [
				'foo' => true,
				'bar' => false,
			],
		];

		$attrs = Clsx::merge($attrs, [
			'class' => [
				'baz' => true,
			],
		]);

		$this->assertEquals($expecter_attrs, $attrs);
	}
}
