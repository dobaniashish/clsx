# clsx for PHP

[![](https://github.com/dobaniashish/clsx/workflows/PHPUnit/badge.svg)](https://github.com/dobaniashish/clsx/actions/workflows/phpunit.yml)

A PHP utility for constructing html attribute strings conditionally.

> [!NOTE]
> This package is for PHP. If you are looking for JavaScript/React.js, check out the original [lukeed/clsx](https://github.com/lukeed/clsx).

This package was inspired from [lukeed/clsx](https://github.com/lukeed/clsx) to bring similar functionality to PHP with an extra feature to merge all attributes in one function call.

## Installation

```
composer require dobaniashish/clsx
```

## Usage

This package provides three functions

- `Clsx::attrs` - Generates full attributes string.
- `Clsx::value` - Generates attribute values string.
- `Clsx::merge` - Merges two attributes array.

### Function `Clsx::attrs()`

Returns generated full attributes string.

#### Parameters

- `$attrs_array` (`array`) Attributes array.

#### Usage

```php
use Dobaniashish\Clsx\Clsx;

// String values.
Clsx::attrs(['foo' => 'bar', 'baz' => 'qux']);
//=> 'foo="bar" baz="qux"'

// Arrays values.
Clsx::attrs(['foo' => 'bar', 'baz' => ['qux', 'quux']]);
//=> 'foo="bar" baz="qux quux"'

// Arrays values with conditions.
Clsx::attrs([
	'foo' => 'bar',
	'baz' => [
		'qux' => true,
		'quux' => false,
	]
]);
//=> 'foo="bar" baz="qux"'

// Attribute names only.
Clsx::attrs(['foo', 'bar']);
//=> 'foo bar'

// Attribute names only with conditions.
Clsx::attrs(['foo' => true, 'bar' => false]);
//=> 'foo=""'

// Arrays values with all falsy conditions.
Clsx::attrs([
	'foo' => 'bar',
	'baz' => [
		'qux' => false,
		'quux' => false,
	]
]);
//=> 'foo="bar"'

// Arrays values with all falsy conditions but keep attribute name.
Clsx::attrs([
	'foo' => 'bar',
	'baz' => Clsx::value([
		'qux' => false,
		'quux' => false,
	]) ?: true
]);
//=> 'foo="bar" baz'
```

#### Example

```php
<?php
use Dobaniashish\Clsx\Clsx;

$button_attrs = [
	'id' => 'button-id',
	'class' => [
		'button',
		'button-success' => true,
	],
	"disabled" => false,
];
?>

<button <?php echo Clsx::attrs($button_attrs); ?>>Click!</button>
```

### Function `Clsx::value()`

Returns generated attribute value string.

#### Parameters

- `$value_array` (`array`) Attribute value array.

#### Usage

```php
use Dobaniashish\Clsx\Clsx;

// String values.
Clsx::value(['foo', 'bar']);
//=> 'foo bar'

// Arrays value with conditions.
Clsx::value(['foo' => true, 'bar' => true, 'baz' => false]);
//=> 'foo bar'
```

#### Example

```php
<?php
use Dobaniashish\Clsx\Clsx;

$button_classes = Clsx::value([
	'button',
	'button-success' => true,
]);
?>

<button class="<?php echo $button_classes; ?>">Click!</button>
```

### Function `Clsx::merge()`

Returns merged attributes array.

#### Parameters

- `$array1` (`array`) Attributes value array.
- `$array2` (`array`) Attributes value array 2.

#### Example Usage

```php
<?php
use Dobaniashish\Clsx\Clsx;

$button_attrs = [
	'id' => 'button-id',
	'class' => [
		'button',
	],
];

$button_attrs = Clsx::merge($button_attrs, [
	'class' => [
		'button-success' => true,
	],
]);
?>

<button <?php echo Clsx::attrs($button_attrs); ?>>Click!</button>
```

### Full Usage Example

```php
<?php
use Dobaniashish\Clsx\Clsx;

// Button statuses.
$button_status = 'success';
$button_size = 'large';
$button_disabled = false;
$button_hide_border = true;

// Button attributes array.
$button_attrs = [
	'id' => 'button-id',
	'class' => [
		'button',
		'button-success' => $button_status === 'success',
		'button-danger' => $button_status === 'danger',
		"button-{$button_size}" => !!$button_size,
	],
	"disabled" => $button_disabled,
	"style" => [
		'color: red;',
		'border: none;' => $button_hide_border,
	],
];

// Add directly to array.
$button_attrs['class']['button-danger'] = false;

// Merge new attribute array.
$button_attrs = Clsx::merge($button_attrs, [
	'class' => [
		// Pre process value.
		Clsx::value([
			'button-merged'
		])
	]
]);
?>

<button <?php echo Clsx::attrs($button_attrs); ?>>Click!</button>
```

#### Outputs

```html
<button
  id="button-id"
  class="button button-success button-large button-merged"
  style="color: red; border: none;"
>
  Click!
</button>
```

## Escaping

Attribute names and values are not escaped automatically. You have to manually escape them.

```php
Clsx::attrs([
	esc_name('foo') => esc_value('bar'),
	esc_name('baz') => esc_value(Clsx::value([
		'qux' => false,
		'quux' => false,
	])) ?: true
]);
```

## License

MIT © DobaniAshish
