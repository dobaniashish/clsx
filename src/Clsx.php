<?php

namespace Dobaniashish\Clsx;

class Clsx
{
	/**
	 * Converts html attributes array to string with conditions similar to classnames/clsx package for react.
	 *
	 * @param array $attrs_array Attributes array.
	 * @return string Generated Attributes string.
	 */
	public static function attrs($attrs_array)
	{
		$attrs = array();

		// Parse values.
		foreach ($attrs_array as $name => $value) {

			if (is_array($value)) {
				$value = self::value($value);
			}

			// If we dont add true value.
			if (is_numeric($name)) {
				$name = $value;
				$value = true;
			}

			if ($value === true) {
				$attrs[] = $name;
			} elseif ($value) {
				$attrs[] = "{$name}=\"{$value}\"";
			}
		}

		return implode(' ', $attrs);
	}

	/**
	 * Convert html attribute value array to string with conditions
	 *
	 * @param array $value_array Attribute value array.
	 * @return string Generated attribute value string.
	 */
	public static function value($value_array)
	{
		$value = array();

		foreach ($value_array as $k => $v) {
			if (is_numeric($k)) {
				$value[] = $v;
			} elseif ($v) {
				$value[] = $k;
			}
		}

		return implode(' ', $value);
	}

	/**
	 * Merge attributes array
	 *
	 * @param array $array1 Attributes value array.
	 * @param array $array2 Attributes value array.
	 * @return array Merged attributes array.
	 */
	public static function merge(array $array1, array $array2)
	{
		$merged = $array1;

		foreach ($array2 as $key => $value) {
			if (is_numeric($key)) {
				if (!in_array($value, $merged, true)) {
					$merged[] = $value;
				}
			} elseif (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
				$merged[$key] = self::merge($merged[$key], $value);
			} else {
				$merged[$key] = $value;
			}
		}

		return $merged;
	}
}
