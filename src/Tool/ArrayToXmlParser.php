<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Tool;

/**
 * Class ObjectToXmlParser
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ArrayToXmlParser
{
    /**
     * @param array $array
     *
     * @return string
     */
    public static function convert(
        array $array,
        $root = '<abonnement xmlns="http://www.atosworldline.com/wsabonnement/v1.0/" />'
    ): string
    {
        $xml = new \SimpleXMLElement(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
$root
XML
);
        array_walk($array, function($value, $key) use ($xml) {
            static::addChild($xml, $value, $key);
        });
        
        return $xml->asXML();
    }

    /**
     * @param \SimpleXMLElement $xml
     * @param $value
     * @param $key
     *
     * @return \SimpleXMLElement|void|null
     */
    public static function addChild(\SimpleXMLElement $xml, $value, $key)
    {
        if (!$value) {
            return;
        }
        
        if (!is_array($value)) {
            return $xml->addChild($key, $value);
        }

        foreach ($value as $subKey => $subValue) {
            // Recursive
            if (is_array($subValue)) {
                $subXml = $xml->addChild($key);
                static::addChild($subXml, $subValue, $subKey);
            } elseif (is_numeric($subKey)) {
                $xml->addChild($key, $subValue);
            } else {
                $xml->addChild($subKey, $subValue);
            }
        }
    }
}
