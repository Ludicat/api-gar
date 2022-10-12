<?php
/**
 * @licence Proprietary
 */
namespace Test\Ludicat\ApiGar\Model\Tool;

use Ludicat\ApiGar\Tool\ArrayToXmlParser;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayToXmlParserTest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ArrayToXmlParserTest extends TestCase
{
    public function testFlatArrayToXml()
    {
        $test = [
            'A' => 'foo',
            'B' => 'bar',
        ];
        
        $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?>
<root><A>foo</A><B>bar</B></root>
', ArrayToXmlParser::convert($test, '<root />'));
    }
    
    public function testNestedArrayToXml()
    {
        $test = [
            'A' => 'foo',
            'B' => [
                'first',
                'second'
            ],
        ];

        $this->assertEquals(
            '<?xml version="1.0" encoding="UTF-8"?>
<root><A>foo</A><B>first</B><B>second</B></root>
',
            ArrayToXmlParser::convert($test, '<root />')
        );
    }
    
    public function testDeepArrayToXml()
    {
        $test = [
            'A' => 'foo',
            'B' => [
                'thing' => [
                    ['c' => 'alex', 'd' => 'bob',],
                    ['c' => 'carole', 'd' => 'david',],
                ],
            ],
        ];
        
        $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?>
<root><A>foo</A><B><thing><c>alex</c><d>bob</d></thing><thing><c>carole</c><d>david</d></thing></B></root>
', ArrayToXmlParser::convert($test, '<root />'));
    }
}
