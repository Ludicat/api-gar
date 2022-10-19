<?php
/**
 * @licence Proprietary
 */
namespace Test\Ludicat\ApiGar\Model\Tool;

use Ludicat\ApiGar\Tool\NameConverter;
use PHPUnit\Framework\TestCase;

/**
 * Class NameCOnverterTest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class NameConverterTest extends TestCase
{
    public function testSnakeCaseToCamelCase()
    {
        foreach ([
            'A' => 'a',
            'A_FOO' => 'aFoo',
            'A_FOO_BAR' => 'aFooBar',
            'A_FOOBAR' => 'aFoobar',
        ] as $name => $expectation) {
            $this->assertEquals($expectation, NameConverter::snakeCaseToCamelCase($name));
        }
    }
    
    public function testSnakeCaseToCamelCaseAndCapitalize()
    {
        foreach ([
            'A' => 'A',
            'A_FOO' => 'AFoo',
            'A_FOO_BAR' => 'AFooBar',
            'A_FOOBAR' => 'AFoobar',
        ] as $name => $expectation) {
            $this->assertEquals($expectation, NameConverter::snakeCaseToCamelCase($name, true));
        }
    }
    
    public function testCamelCaseToSnakeCase()
    {
        foreach (
            [
                'simpleTest' => 'simple_test',
                'easy' => 'easy',
                'HTML' => 'html',
                'simpleXML' => 'simple_xml',
                'PDFLoad' => 'pdf_load',
                'startMIDDLELast' => 'start_middle_last',
                'AString' => 'a_string',
                'Some4Numbers234' => 'some4_numbers234',
                'TEST123String' => 'test123_string',
                'a' => 'a',
                'aFoo' => 'a_foo',
            ] as $name => $expectation
        ) {
            $this->assertEquals($expectation, NameConverter::camelCaseToSnakeCase($name, true));
        }
    }
}
