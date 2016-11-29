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


class MbString
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
    protected $encoding;

    /**
     * MbString constructor.
     * @param string $string
     * @param string $encoding
     */
    public function __construct($string, $encoding = self::ENCODING_UTF_8)
    {
        $this->string = $string;
        $this->encoding = $encoding;
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
     * Changes the string encoding
     * @param $encoding
     */
    public function setEncoding($encoding)
    {
        $this->string = mb_convert_encoding($this->string, $encoding, $this->encoding);
        $this->encoding = $encoding;
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
        return mb_substr($this->string, $index, 1, $this->encoding);
    }

    /**
     * Replace char by index
     * @param int $index
     * @param string $char
     */
    public function setChar($index, $char)
    {
        $this->string = mb_substr($this->string, 0, $index, $this->encoding)
            . mb_substr($char, 0, 1, $this->encoding)
            . mb_substr($this->string, $index + 1, $this->mbStrLen() - ($index + 1), $this->encoding);
    }

    /**
     * Remove char by index
     * @param int $index
     */
    public function removeChar($index)
    {
        $this->string = mb_substr($this->string, 0, $index, $this->encoding) . mb_substr($this->string, $index + 1, $this->mbStrLen() - ($index + 1), $this->encoding);
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
        return $this->string = mb_convert_case($this->string, MB_CASE_UPPER, $this->encoding);
    }

    /**
     * @return string
     */
    public function toLowerCase()
    {
        return $this->string = mb_convert_case($this->string, MB_CASE_LOWER, $this->encoding);
    }

    /**
     * @return string
     */
    public function toTitleCase()
    {
        return $this->string = mb_convert_case($this->string, MB_CASE_TITLE, $this->encoding);
    }

    /**
     * @return string
     */
    public function toCamelCase()
    {
        return $this->string = str_replace(" ", "", $this->toTitleCase());
    }

    /**
     * @return string
     */
    public function toSnakeCase()
    {
        return $this->string = str_replace(" ", "_", $this->toLowerCase());
    }
}