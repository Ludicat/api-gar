<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Tool;

/**
 * Class NameConverter
 *
 * Provide method to transform method names
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class NameConverter
{
    /**
     * Column names are given uppercase with underscore separator.
     * This method allow us to convert it to camelCase
     *
     * @param string $string
     * @param bool $capitalizeFirstCharacter
     *
     * @return string|string[]
     */
    public static function snakeCaseToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace('_', '', ucwords(strtolower($string), '_'));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public static function camelCaseToSnakeCase($input)
    {
        preg_match_all('/([A-Za-z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)/', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }
}
