<?php
/**
 * @file: MbString.php
 * @author Alex Maystrenko <ashterix69@gmail.com>
 *
 * Class - MbString
 *
 * Created by PhpStorm.
 * Date: 29.11.2016
 * Time: 15:34
 */

namespace UfoCms\Helpers\Components;


use UfoCms\Helpers\Exceptions\HelperContextException;

class MbString implements \ArrayAccess, \Countable
{
    const ENCODING_UTF_8 = 'UTF-8';
    const ENCODING_WINDOWS_1251 = 'WINDOWS-1251';

    /**
     * @var string
     */
    protected $string;

    /**
     * @var string
     */
    protected $encoding = self::ENCODING_UTF_8;

    /**
     * MbString constructor.
     * @param string $string
     * @param string $encoding
     */
    public function __construct($string, $encoding = self::ENCODING_UTF_8)
    {
        $this->string = $string;
        $this->setEncoding($encoding);
    }

    /**
     * Changes the string encoding
     * @param $encoding
     * @throws HelperContextException
     */
    public function setEncoding($encoding)
    {
        if (false === in_array($encoding, static::getEncodingList())) {
            throw new HelperContextException($encoding . ' - is not supported by the encoding. Use MbString::getEncodingList() for get encodings list.');
        }
        $this->string = mb_convert_encoding($this->string, $encoding, $this->encoding);
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->string;
    }

    /**
     * The length of the string in characters
     * @return int
     */
    public function mbStrLen()
    {
        return mb_strlen($this->string, $this->encoding);
    }

    /**
     * Data size in bytes
     * @return int
     */
    public function biteSize()
    {
        return strlen($this->string);
    }

    /**
     * Returns a string encoding
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Get lists the supported encodings
     * @return array
     */
    public static function getEncodingList()
    {
        return mb_list_encodings();
    }

    /**
     * Get char by index
     * @param int $index
     * @return string
     */
    public function getChar($index)
    {
        $res = null;
        if ($this->offsetExists($index)) {
            $res = mb_substr($this->string, $index, 1, $this->encoding);
        }
        return $res;
    }

    /**
     * Replace char by index
     * @param int $index
     * @param string $char
     * @return $this
     */
    public function setChar($index, $char)
    {
        $this->string = mb_substr($this->string, 0, $index, $this->encoding)
            . mb_substr($char, 0, 1, $this->encoding)
            . mb_substr($this->string, $index + 1, $this->mbStrLen() - ($index + 1), $this->encoding);

        return $this;
    }

    /**
     * Remove char by index
     * @param int $index
     * @return $this
     */
    public function removeChar($index)
    {
        $this->string = mb_substr($this->string, 0, $index, $this->encoding) . mb_substr($this->string, $index + 1, $this->mbStrLen() - ($index + 1), $this->encoding);
        return $this;
    }

    /**
     * @return string
     */
    public function ucFirst()
    {
        $this->setChar(0, mb_strtoupper($this->getChar(0), $this->encoding));
        return $this->string;
    }

    /**
     * @return string
     */
    public function lcFirst()
    {
        $this->setChar(0, mb_strtolower($this->getChar(0), $this->encoding));
        return $this->string;
    }

    /**
     * @return string
     */
    public function toUpperCase()
    {
        return mb_convert_case($this->string, MB_CASE_UPPER, $this->encoding);
    }

    /**
     * @return string
     */
    public function toLowerCase()
    {
        return mb_convert_case($this->string, MB_CASE_LOWER, $this->encoding);
    }

    /**
     * @return string
     */
    public function toTitleCase()
    {
        return mb_convert_case($this->string, MB_CASE_TITLE, $this->encoding);
    }

    /**
     * @return string
     */
    public function toCamelCase()
    {
        return str_replace(" ", "", $this->toTitleCase());
    }

    /**
     * @return string
     */
    public function toSnakeCase()
    {
        return str_replace(" ", "_", $this->toLowerCase());
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return ($offset < $this->mbStrLen());
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->getChar($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->setChar($offset, $value);
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->removeChar($offset);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->mbStrLen();
    }
}