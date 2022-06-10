<?php
/*
 * This file is part of the Minwork package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Source: https://github.com/minwork/array/edit/master/src/Arr.php
 */

/**
 * Pack of advanced array functions - specifically for associative arrays and arrays of objects
 *
 * @author Krzysztof Kalkhoff
 * @modificator Waris Agung Widodo
 *
 */
class Arr
{
  // Flags
  const FORCE_ARRAY_ALL = 1;
  const FORCE_ARRAY_PRESERVE_NULL = 2;
  const FORCE_ARRAY_PRESERVE_OBJECTS = 4;
  const FORCE_ARRAY_PRESERVE_ARRAY_OBJECTS = 8;

  const MAP_ARRAY_KEY_VALUE = 1;
  const MAP_ARRAY_VALUE_KEYS_LIST = 2;
  const MAP_ARRAY_KEYS_ARRAY_VALUE = 4;

  const UNPACK_ALL = 1;
  /**
   * Preserve arrays with highest nesting level (if they are not assoc) as element values instead of unpacking them
   */
  const UNPACK_PRESERVE_LIST_ARRAY = 2;
  /**
   * Preserve arrays with highest nesting level (if they are assoc) as element values instead of unpacking them
   */
  const UNPACK_PRESERVE_ASSOC_ARRAY = 4;
  /**
   * Preserve all arrays with highest nesting level as element values instead of unpacking them
   */
  const UNPACK_PRESERVE_ARRAY = 8;

  const AUTO_INDEX_KEY = '[]';
  const KEY_SEPARATOR = '.';

  /*--------------------------------------------------------------------------------------*\
   |                                        Common                                        |
   |    ******************************************************************************    |
   | Basic operations used by other methods                                               |
  \*--------------------------------------------------------------------------------------*/


  /**
   * Convert variable into normalized array of keys<br>
   * <br>
   * Transforms 'key1.key2.key3' strings into ['key1','key2','key3']<br>
   * <br>
   * When array is supplied, this function preserve only not empty strings and integers<br>
   * <pre>
   * ['', 'test', 5.5, null, 0] -> ['test', 0]
   * </pre>
   *
   * @param mixed $keys
   * @return array
   */
  public static function getKeysArray($keys, $delimiter = self::KEY_SEPARATOR)
  {
    if (is_string($keys)) {
      return empty($keys) ? [] : explode($delimiter, $keys);
    }
    return is_null($keys) ? [] : array_filter(array_values(self::forceArray($keys)), function ($value) {
      return $value !== null && $value !== '' && (is_string($value) || is_int($value));
    });
  }

  /**
   * Check if specified (nested) key(s) exists in array
   *
   * @param array $array
   * @param mixed $keys Keys needed to access desired array element (for possible formats see getKeysArray method)
   * @return bool
   * @see Arr::getKeysArray()
   */
  public static function has(array $array, $keys)
  {
    $keysArray = self::getKeysArray($keys);

    if (empty($keysArray)) {
      return false;
    }

    $tmp = $array;

    foreach ($keysArray as $key) {
      if (!array_key_exists($key, $tmp)) {
        return false;
      }
      $tmp = $tmp[$key];
    }

    return true;
  }

  /**
   * Check if array has list of specified keys
   *
   * @param array $array
   * @param mixed $keys Keys needed to access desired array element (for possible formats see getKeysArray method)
   * @param bool $strict If array must have all of specified keys
   * @return bool
   * @see Arr::getKeysArray()
   */
  public static function hasKeys(array $array, $keys, $strict = false)
  {
    foreach (self::getKeysArray($keys) as $key) {
      if (array_key_exists($key, $array) && !$strict) {
        return true;
      } elseif (!array_key_exists($key, $array) && $strict) {
        return false;
      }
    }
    return $strict ? true : false;
  }

  /**
   * Alias of Arr::getNestedElement
   *
   * @param array|ArrayAccess $array Array or object implementing array access to get element from
   * @param mixed $keys Keys needed to access desired array element (for possible formats see getKeysArray method)
   * @param mixed $default Default value if element was not found
   * @return null|mixed
   * @see Arr::getNestedElement()
   */
  public static function get($array, $keys, $default = null)
  {
    return self::getNestedElement($array, $keys, $default);
  }

  /**
   * Get nested element of an array or object implementing array access
   *
   * @param array|ArrayAccess $array Array or object implementing array access to get element from
   * @param mixed $keys Keys needed to access desired array element (for possible formats see getKeysArray method)
   * @param mixed $default Default value if element was not found
   * @return null|mixed
   * @see Arr::getKeysArray()
   */
  public static function getNestedElement($array, $keys, $default = null)
  {
    $keys = self::getKeysArray($keys);
    foreach ($keys as $key) {
      if (!is_array($array) && !$array instanceof ArrayAccess) {
        return $default;
      }
      if (($array instanceof ArrayAccess && $array->offsetExists($key)) || array_key_exists($key, $array)) {
        $array = $array[$key];
      } else {
        return $default;
      }
    }
    return $array;
  }

  /**
   * Alias of Arr::setNestedElement
   *
   * @param array $array
   * @param mixed $keys Keys needed to access desired array element (for possible formats see getKeysArray method)
   * @param mixed $value Value to set
   * @return array Copy of an array with element set
   * @see Arr::setNestedElement()
   */
  public static function set(array $array, $keys, $value)
  {
    return self::setNestedElement($array, $keys, $value);
  }

  /**
   * Set array element specified by keys to the desired value (create missing keys if necessary)
   *
   * @param array $array
   * @param mixed $keys Keys needed to access desired array element (for possible formats see getKeysArray method)
   * @param mixed $value Value to set
   * @return array Copy of an array with element set
   * @see Arr::getKeysArray()
   */
  public static function setNestedElement(array $array, $keys, $value, $delimiter = self::KEY_SEPARATOR)
  {
    $result = $array;
    $keysArray = self::getKeysArray($keys, $delimiter);

    // If no keys specified then preserve array
    if (empty($keysArray)) {
      return $result;
    }

    $tmp = &$result;

    while (count($keysArray) > 0) {
      $key = array_shift($keysArray);
      if (!is_array($tmp)) {
        $tmp = [];
      }
      if ($key === self::AUTO_INDEX_KEY) {
        $tmp[] = null;
        end($tmp);
        $key = key($tmp);
      }
      $tmp = &$tmp[$key];
    }
    $tmp = $value;

    return $result;
  }

  /**
   * Remove element inside array at path specified by keys
   *
   * @param array $array
   * @param mixed $keys Keys needed to access desired array element (for possible formats see getKeysArray method)
   * @return array
   * @see Arr::getKeysArray()
   */
  public static function remove(array $array, $keys)
  {
    $result = $array;
    $keysArray = self::getKeysArray($keys);

    $tmp = &$result;

    while (count($keysArray) > 1) {
      $key = array_shift($keysArray);
      if (!is_array($tmp) || !array_key_exists($key, $tmp)) {
        return $result;
      }

      $tmp = &$tmp[$key];
    }
    $key = array_shift($keysArray);
    unset($tmp[$key]);

    return $result;
  }

  /**
   * Converts map of keys concatenated by dot and corresponding values to multidimensional array
   *
   * @param array $array
   * @return array
   */
  public static function pack(array $array, $delimiter = self::KEY_SEPARATOR)
  {
    $result = [];

    foreach ($array as $key => $value) {
      $result = self::setNestedElement($result, $key, $value, $delimiter);
    }

    return $result;
  }

  /**
   * Converts multidimensional array to map of keys concatenated by dot and corresponding values
   *
   * @param array $array
   * @param int $mode Modify behaviour of unpack (see description of Arr::UNPACK_ constants)
   * @return array
   */
  public static function unpack(array $array, $mode = self::UNPACK_ALL)
  {
    return self::_unpack($array, $mode);
  }

  private static function _unpack(array $array, $mode = self::UNPACK_ALL, array $keys = [])
  {
    $result = [];

    foreach ($array as $key => $value) {

      if (is_array($value) && !(
          // Check if value IS NOT a subject for preserve mode
          !self::isNested($value) && // Preserve mode only work for highest depth elements
          (
            ($mode === self::UNPACK_PRESERVE_LIST_ARRAY && !self::isAssoc($value, true)) ||
            ($mode === self::UNPACK_PRESERVE_ASSOC_ARRAY && self::isAssoc($value, true)) ||
            $mode === self::UNPACK_PRESERVE_ARRAY
          )
        )) {
        $keys[] = $key;
        $result += self::_unpack($value, $mode, $keys);
        array_pop($keys);
      } else {
        $result[implode(self::KEY_SEPARATOR, array_merge($keys, [$key]))] = $value;
      }
    }

    return $result;
  }

  /*--------------------------------------------------------------------------------------*\
   |                                      Validation                                      |
   |    ******************************************************************************    |
   | Flexible check method and various specific checks                                    |
  \*--------------------------------------------------------------------------------------*/

  /**
   * Check if every element of an array meets specified condition
   *
   * @param array $array
   * @param mixed|callable $condition Can be either single value to compare every array value to or callable (which takes value as first argument and key as second) that performs check
   * @param bool $strict In case $condition is callable check if it result is exactly <code>true</code> otherwise if it is equal both by value and type to supplied $condition
   * @return bool
   */
  public static function check(array $array, $condition, $strict = false)
  {
    if (is_callable($condition)) {
      try {
        $reflection = is_array($condition) ?
          new ReflectionMethod($condition[0], $condition[1]) :
          new ReflectionMethod($condition);

        $paramsCount = $reflection->getNumberOfParameters();
      } catch (Throwable $e) {
        try {
          $reflection = new ReflectionFunction($condition);
          $paramsCount = $reflection->getNumberOfParameters();
        } catch (Throwable $exception) { // @codeCoverageIgnore
          $paramsCount = 2; // @codeCoverageIgnore
        }
      }
    }

    foreach ($array as $key => $value) {
      if (is_callable($condition)) {
        /** @var int $paramsCount */
        $result = $paramsCount == 1 ? call_user_func($condition, $value) : call_user_func($condition, $value, $key);

        if ($strict ? $result !== true : !$result) {
          return false;
        }
      } else {
        if ($strict ? $value !== $condition : $value != $condition) {
          return false;
        }
      }
    }

    return true;
  }

  /**
   * Recursively check if all of array values match empty condition
   *
   * @param array $array
   * @return boolean
   */
  public static function isEmpty($array)
  {
    if (is_array($array)) {
      foreach ($array as $v) {
        if (!self::isEmpty($v)) {
          return false;
        }
      }
    } elseif (!empty($array)) {
      return false;
    }

    return true;
  }

  /**
   * Check if array is associative
   *
   * @param array $array
   * @param bool $strict
   * <p>If <i>false</i> then this function will match any array that doesn't contain integer keys.</p>
   * <p>If <i>true</i> then this function match only arrays with sequence of integers starting from zero (range from 0 to elements_number - 1) as keys.</p>
   *
   * @return boolean
   */
  public static function isAssoc(array $array, $strict = false)
  {
    if (empty($array)) {
      return false;
    }

    if ($strict) {
      return array_keys($array) !== range(0, count($array) - 1);
    } else {
      foreach (array_keys($array) as $key) {
        if (!is_int($key)) {
          return true;
        }
      }
      return false;
    }
  }

  /**
   * Check if array contain only numeric values
   *
   * @param array $array
   * @return bool
   */
  public static function isNumeric(array $array)
  {
    return self::check($array, 'is_numeric');
  }

  /**
   * Check if array values are unique
   *
   * @param array $array
   * @param bool $strict If it should also compare type
   * @return bool
   */
  public static function isUnique(array $array, $strict = false)
  {
    if ($strict) {
      foreach ($array as $key => $value) {
        $keys = array_keys($array, $value, true);
        if (count($keys) > 1 || $keys[0] !== $key) {
          return false;
        }
      }
      return true;
    }
    return array_unique(array_values($array), SORT_REGULAR) === array_values($array);
  }

  /**
   * Check if any element of an array is also an array
   *
   * @param array $array
   * @return bool
   */
  public static function isNested(array $array)
  {
    if (isset($array['type'])) return false;
    foreach ($array as $element) {
      if (is_array($element)) {
        return true;
      }
    }

    return false;
  }

  /**
   * Check if every element of an array is array
   *
   * @param array $array
   * @return bool
   */
  public static function isArrayOfArrays(array $array)
  {
    // If empty array
    if (count($array) === 0) {
      return false;
    }
    foreach ($array as $element) {
      if (!is_array($element)) {
        return false;
      }
    }
    return true;
  }

  /*--------------------------------------------------------------------------------------*\
   |                                      Manipulation                                    |
   |    ******************************************************************************    |
   | Well known methods (like map, filter, group etc.) in 2 variants: regular and objects |
  \*--------------------------------------------------------------------------------------*/

  /**
   * Applies a callback to the elements of given array
   *
   * @param array $array
   * @param callable $callback Callback to run for each element of array
   * @param int $mode Determines callback arguments order and format<br>
   *   <br>
   *   MAP_ARRAY_KEY_VALUE -> callback($key, $value)<br>
   *   MAP_ARRAY_VALUE_KEYS_LIST -> callback($value, $key1, $key2, ...)<br>
   *   MAP_ARRAY_KEYS_ARRAY_VALUE -> callback(array $keys, $value)
   * @return array
   */
  public static function map($array, $callback, $mode = self::MAP_ARRAY_KEY_VALUE)
  {
    // If has old arguments order then swap and issue warning
    if (is_callable($array) && is_array($callback)) {
      $tmp = $array;
      $array = $callback;
      $callback = $tmp;
      trigger_error('Supplying callback as first argument to Arr::map method is deprecated and will trigger error in next major release. Please use new syntax -> Arr::map(array $array, callback $callback, int $mode)', E_USER_DEPRECATED);
    }
    $result = [];

    switch ($mode) {
      case self::MAP_ARRAY_KEY_VALUE:
        foreach ($array as $key => $value) {
          $result[$key] = $callback($key, $value);
        }
        break;
      case self::MAP_ARRAY_VALUE_KEYS_LIST:
        foreach (self::unpack($array) as $dotKeys => $value) {
          $keys = self::getKeysArray($dotKeys);
          $result = self::setNestedElement($result, $keys, $callback($value, ...$keys));
        }
        break;
      case self::MAP_ARRAY_KEYS_ARRAY_VALUE:
        foreach (self::unpack($array) as $dotKeys => $value) {
          $keys = self::getKeysArray($dotKeys);
          $result = self::setNestedElement($result, $keys, $callback($keys, $value));
        }
        break;
    }

    return $result;
  }

  /**
   * Map array of object to values returned from objects method
   *
   * This method leaves values other than objects intact
   *
   * @param array $objects Array of objects
   * @param string $method Object method name
   * @param mixed ...$args Method arguments
   * @return array
   */
  public static function mapObjects(array $objects, $method, ...$args)
  {
    $return = [];

    foreach ($objects as $key => $value) {
      if (is_object($value)) {
        $return[$key] = $value->$method(...$args);
      } else {
        $return[$key] = $value;
      }
    }

    return $return;
  }

  /**
   * Filter array values by preserving only those which keys are present in array obtained from $keys variable
   *
   * @param array $array
   * @param mixed $keys Keys needed to access desired array element (for possible formats see getKeysArray method)
   * @param bool $exclude If values matching $keys should be excluded from returned array
   * @return array
   * @see Arr::getKeysArray()
   */
  public static function filterByKeys(array $array, $keys, $exclude = false)
  {
    if (is_null($keys)) {
      return $array;
    }
    $keysArray = self::getKeysArray($keys);
    if (empty($keysArray)) {
      return $exclude ? $array : [];
    }
    return $exclude ? array_diff_key($array, array_flip($keysArray)) : array_intersect_key($array, array_flip($keysArray));
  }

  /**
   * Filter objects array using return value of specified method.<br>
   * <br>
   * This method also filter values other than objects by standard boolean comparison
   *
   * @param array $objects Array of objects
   * @param string $method Object method name
   * @param mixed ...$args Method arguments
   * @return array
   */
  public static function filterObjects(array $objects, $method, ...$args)
  {
    $return = [];

    foreach ($objects as $key => $value) {
      if (is_object($value)) {
        if ($value->$method(...$args)) {
          $return[$key] = $value;
        }
      } elseif ($value) {
        $return[$key] = $value;
      }
    }

    return $return;
  }

  /**
   * Group array of arrays by value of element with specified key<br>
   * <br>
   * <u>Example</u><br><br>
   * <pre>
   * Arr::group([
   *   'a' => [ 'key1' => 'test1', 'key2' => 1 ],
   *   'b' => [ 'key1' => 'test1', 'key2' => 2 ],
   *   2 => [ 'key1' => 'test2', 'key2' => 3 ]
   * ], 'key1')
   * </pre>
   * will produce
   * <pre>
   * [
   *   'test1' => [
   *     'a' => [ 'key1' => 'test1', 'key2' => 1 ],
   *     'b' => [ 'key1' => 'test1', 'key2' => 2 ]
   *   ],
   *   'test2' => [
   *     2 => [ 'key1' => 'test2', 'key2' => 3 ]
   *   ],
   * ]
   * </pre>
   * <br>
   * If key does not exists in one of the arrays, this array will be excluded from result
   * @param array $array Array of arrays
   * @param string|int $key Key on which to group arrays
   * @return array
   */
  public static function group(array $array, $key)
  {
    $return = [];

    // If not array of arrays return untouched
    if (!self::isArrayOfArrays($array)) {
      return $array;
    }

    foreach ($array as $k => $v) {
      if (array_key_exists($key, $v)) {
        $return[$v[$key]][$k] = $v;
      }

    }

    return $return;
  }

  /**
   * Group array of objects by value returned from specified method<br>
   * <br>
   * <u>Example</u><br>
   * Let's say we have a list of Foo objects [Foo1, Foo2, Foo3] and all of them have method bar which return string.<br>
   * If method bar return duplicate strings then all keys will contain list of corresponding objects like this:<br>
   * <pre>
   * ['string1' => [Foo1], 'string2' => [Foo2, Foo3]]
   * </pre>
   *
   * @param array $objects Array of objects
   * @param string $method Object method name
   * @param mixed ...$args Method arguments
   * @return array
   */
  public static function groupObjects(array $objects, $method, ...$args)
  {
    $return = [];

    foreach ($objects as $key => $object) {
      if (is_object($object)) {
        $return[$object->$method(...$args)][$key] = $object;
      }
    }

    return $return;
  }

  /**
   * Order associative array according to supplied keys order
   * Keys that are not present in $keys param will be appended to the end of an array preserving supplied order.
   * @param array $array
   * @param mixed $keys Keys needed to access desired array element (for possible formats see getKeysArray method)
   * @param bool $appendUnmatched If values not matched by supplied keys should be appended to the end of an array
   * @return array
   * @see Arr::getKeysArray()
   */
  public static function orderByKeys(array $array, $keys, $appendUnmatched = true)
  {
    $return = [];

    foreach (self::getKeysArray($keys) as $key) {
      if (array_key_exists($key, $array)) {
        $return[$key] = $array[$key];
      }
    }

    return $appendUnmatched ? $return + self::filterByKeys($array, $keys, true) : $return;
  }

  /**
   * Sort array of arrays using value specified by key(s)
   *
   * @param array $array Array of arrays
   * @param mixed $keys Keys in format specified by getKeysArray method or null to perform sort using 0-depth keys
   * @param bool $assoc If sorting should preserve main array keys (default: true)
   * @return array New sorted array
   * @see Arr::getKeysArray()
   */
  public static function sortByKeys(array $array, $keys = null, $assoc = true)
  {
    $return = $array;
    $method = $assoc ? 'uasort' : 'usort';

    $method($return, function ($a, $b) use ($keys) {
      if (self::getNestedElement($a, $keys) == self::getNestedElement($b, $keys)) return 0;
      if (self::getNestedElement($a, $keys) < self::getNestedElement($b, $keys)) return -1;
      if (self::getNestedElement($a, $keys) > self::getNestedElement($b, $keys)) return 1;
      return -1;
    });

    return $return;
  }

  /**
   * Sort array of objects using result of calling supplied method name on object as value to compare
   *
   * @param array $objects Array of objects
   * @param string $method Name of a method called for every array element (object) in order to obtain value to compare
   * @param mixed ...$args Arguments for method
   * @return array New sorted array
   */
  public static function sortObjects(array $objects, $method, ...$args)
  {
    $result = $objects;

    uasort($result, function ($a, $b) use ($method, $args) {
      if ($a->$method(...$args == $b->$method(...$args))) return 0;
      if ($a->$method(...$args < $b->$method(...$args))) return -1;
      if ($a->$method(...$args > $b->$method(...$args))) return 1;
      return -1;
    });

    return $result;
  }

  /**
   * Sum associative arrays by their keys into one array
   *
   * @param array ...$arrays Can be either list of an arrays or single array of arrays
   * @return array
   */
  public static function sum(array ...$arrays)
  {
    $return = [];

    foreach ($arrays as $array) {
      foreach ($array as $key => $value) {
        $return[$key] = (isset($return[$key]) ? $return[$key] : 0) + floatval($value);
      }
    }

    return $return;
  }

  /**
   * Compute difference between two or more arrays of objects
   *
   * @param array $array1
   * @param array $array2
   * @param array[] $arrays
   * @return array
   */
  public static function diffObjects(array $array1, array $array2, array ...$arrays)
  {
    $arguments = $arrays;
    array_unshift($arguments, $array1, $array2);
    array_push($arguments, function ($obj1, $obj2) {
      return strcmp(spl_object_hash($obj1), spl_object_hash($obj2));
    });

    return array_udiff(...$arguments);
  }

  /**
   * Compute intersection between two or more arrays of objects
   *
   * @param array $array1
   * @param array $array2
   * @param array[] $arrays
   * @return array
   */
  public static function intersectObjects(array $array1, array $array2, array ...$arrays)
  {
    $arguments = $arrays;
    array_unshift($arguments, $array1, $array2);
    array_push($arguments, function ($obj1, $obj2) {
      return strcmp(spl_object_hash($obj1), spl_object_hash($obj2));
    });

    return array_uintersect(...$arguments);
  }

  /**
   * Flatten array of arrays to a n-depth array
   *
   * @param array $array
   * @param int|null $depth How many levels of nesting will be flatten. By default every nested array will be flatten.
   * @param bool $assoc If this param is set to true, this method will try to preserve as much string keys as possible.
   * In case of conflicting key name, value will be added with automatic numeric key.<br>
   * <br>
   * <i>Warning:</i> This method may produce unexpected results when array has numeric keys and $assoc param is set to true
   * @return array
   */
  public static function flatten(array $array, $depth = null, $assoc = false)
  {
    $return = [];

    $addElement = function ($key, $value) use (&$return, $assoc) {
      if (!$assoc || array_key_exists($key, $return)) {
        $return[] = $value;
      } else {
        $return[$key] = $value;
      }
    };

    foreach ($array as $key => $value) {
      if (is_array($value) && (is_null($depth) || $depth >= 1)) {
        foreach (self::flatten($value, is_null($depth) ? $depth : $depth - 1, $assoc) as $k => $v) {
          $addElement($k, $v);
        }
      } else {
        $addElement($key, $value);
      }
    }

    return $return;
  }

  /**
   * Flatten single element arrays (also nested single element arrays)<br>
   * Let's say we have an array like this:<br>
   * <pre>
   * ['foo' => ['bar'], 'foo2' => ['bar2', 'bar3' => ['foo4']]
   * </pre>
   * then we have result:<br>
   * <pre>
   * ['foo' => 'bar', 'foo2' => ['bar2', 'bar3' => 'foo4']]
   * </pre>
   *
   * @param array $array
   * @return array
   */
  public static function flattenSingle(array $array)
  {
    $return = [];

    foreach ($array as $key => $value) {
      if (is_array($value)) {
        if (count($value) === 1) {
          $return[$key] = reset($value);
        } else {
          $return[$key] = self::flattenSingle($value);
        }
      } else {
        $return[$key] = $value;
      }
    }

    return $return;
  }

  /*--------------------------------------------------------------------------------------*\
   |                                        Utility                                       |
   |    ******************************************************************************    |
   | Other useful methods                                                                 |
  \*--------------------------------------------------------------------------------------*/

  /**
   * Create multidimensional array using either first param as config of keys and values
   * or separate keys and values arrays
   *
   * @param array $keys If values are not specified, array will be created from this param keys (optionally dot formatted) and values. Otherwise it is used as array of keys (both dot and array notation possible)
   * @param array|null $values [optional] Values for new array
   * @return array
   */
  public static function createMulti(array $keys, $values = null)
  {
    if (is_null($values)) {
      $values = array_values($keys);
      $keys = array_keys($keys);
    }

    if (count($keys) !== count($values)) {
      throw new InvalidArgumentException('Keys and values arrays must have same amount of elements');
    }

    // Reset array indexes
    $keys = array_values($keys);
    $values = array_values($values);

    $array = [];

    foreach ($keys as $index => $key) {
      $array = self::setNestedElement($array, $key, $values[$index]);
    }

    return $array;
  }

  /**
   * Make variable an array (according to flag settings)
   *
   * @param mixed $var
   * @param int $flag Set flag(s) to preserve specific values from being converted to array (see Arr::FORCE_ARRAY_ constants)
   * @return array
   */
  public static function forceArray($var, $flag = self::FORCE_ARRAY_ALL)
  {
    if (!is_array($var)) {
      if ($flag & self::FORCE_ARRAY_ALL) {
        return [$var];
      }
      if (is_object($var)) {
        if ($flag & self::FORCE_ARRAY_PRESERVE_OBJECTS) {
          return $var;
        }
        if (($flag & self::FORCE_ARRAY_PRESERVE_ARRAY_OBJECTS) && $var instanceof ArrayAccess) {
          return $var;
        }
      }
      if (is_null($var) && ($flag & self::FORCE_ARRAY_PRESERVE_NULL)) {
        return $var;
      }

      return [$var];
    }
    return $var;
  }


  /**
   * Get nesting depth of an array.<br>
   * <br>
   * Depth is calculated by counting amount of nested arrays - each nested array increase depth by one.
   * Nominal depth of an array is 1.
   *
   * @param array $array
   * @return int
   */
  public static function getDepth(array $array)
  {
    $depth = 0;
    $queue = [$array];

    do {
      ++$depth;
      $current = $queue;
      $queue = [];
      foreach ($current as $element) {
        foreach ($element as $value) {
          if (is_array($value)) {
            $queue[] = $value;
          }
        }
      }
    } while(!empty($queue));

    return $depth;
  }

  /**
   * Copy array and clone every object inside it
   *
   * @param array $array
   * @return array
   */
  public static function _clone(array $array)
  {
    $cloned = [];
    foreach ($array as $key => $value) {
      if (is_array($value)) {
        $cloned[$key] = self::_clone($value);
      } elseif (is_object($value)) {
        $cloned[$key] = clone $value;
      } else {
        $cloned[$key] = $value;
      }
    }
    return $cloned;
  }

  /**
   * Get random array value(s)
   *
   * @param array $array
   * @param int $count If equal to 1 than directly returns value or array of values otherwise
   * @return mixed
   * @throws InvalidArgumentException
   */
  public static function random(array $array, $count = 1)
  {
    if (empty($array)) {
      return null;
    }

    if ($count > ($arrayCount = count($array)) || $count < 1) {
      throw new InvalidArgumentException("Count must be a number between 1 and $arrayCount");
    }

    return $count == 1 ? $array[array_rand($array)] : array_intersect_key($array, array_flip(array_rand($array, $count)));
  }

  /**
   * Shuffle array preserving keys and returning new shuffled array
   *
   * @param array $array
   * @return array
   */
  public static function shuffle(array $array)
  {
    $return = [];
    $keys = array_keys($array);

    shuffle($keys);

    foreach ($keys as $key) {
      $return[$key] = $array[$key];
    }

    return $return;
  }

  /**
   * Gets array elements with index matching condition $An + $B (preserving original keys)
   *
   * @param array $array
   * @param int $A
   * @param int $B
   * @return array
   * @see Arr::even()
   * @see Arr::odd()
   */
  public static function nth(array $array, $A = 1, $B = 0)
  {
    $keys = [];

    for ($i = $B; $i < count($array); $i += $A) {
      $keys[] = $i;
    }
    return self::filterByKeys($array, self::filterByKeys(array_keys($array), $keys));
  }

  /**
   * Get even array values - alias for <i>nth</i> method with $A = 2
   *
   * @param array $array
   * @return array
   */
  public static function even(array $array)
  {
    return self::nth($array, 2);
  }

  /**
   * Get odd array values - alias for <i>nth</i> method with $A = 2 and $B = 1
   *
   * @param array $array
   * @return array
   */
  public static function odd(array $array)
  {
    return self::nth($array, 2, 1);
  }

  public static function modify($keys, $array, $new_value) {
    return self::createMulti($keys, ['a', 'b', 'c']);
  }
}