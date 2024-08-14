<?php

use PHPUnit\Framework\TestCase;
use Dobaniashish\Clsx\Clsx;

final class ValueTest extends TestCase
{
	public function testValueWithArray(): void
	{
		$value = Clsx::value([
			'foo' => true,
			'bar' => true,
			'baz' => false,
		]);

		$this->assertEquals('foo bar', $value);
	}

	public function testValueWithString(): void
	{
		$value = Clsx::value([
			'foo',
		]);

		$this->assertEquals('foo', $value);
	}
}
