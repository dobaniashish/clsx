<?php

use PHPUnit\Framework\TestCase;
use Dobaniashish\Clsx\Clsx;

final class AttrsTest extends TestCase
{
	public function testValueWithArray(): void
	{
		$attrs = Clsx::attrs([
			'class' => [
				'foo' => true,
				'bar' => false,
			],
		]);

		$this->assertEquals('class="foo"', $attrs);
	}

	public function testValueWithString(): void
	{
		$attrs = Clsx::attrs([
			'class' => 'foo',
		]);

		$this->assertEquals('class="foo"', $attrs);
	}

	public function testMultipleValueWithArray(): void
	{
		$attrs = Clsx::attrs([
			'class' => [
				'foo' => true,
				'bar' => false,
			],
			'style' => [
				'foo: bar;' => true,
				'baz: qux;' => false,
			],
		]);

		$this->assertEquals('class="foo" style="foo: bar;"', $attrs);
	}

	public function testMultipleValueWithString(): void
	{
		$attrs = Clsx::attrs([
			'class' => 'foo',
			'style' => 'foo: bar;',
		]);

		$this->assertEquals('class="foo" style="foo: bar;"', $attrs);
	}
}
