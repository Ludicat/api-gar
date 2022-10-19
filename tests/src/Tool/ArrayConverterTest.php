<?php
/**
 * @licence Proprietary
 */
namespace Test\Ludicat\ApiGar\Model\Tool;

use Ludicat\ApiGar\Model\Abonnement;
use Ludicat\ApiGar\Model\Filtre;
use Ludicat\ApiGar\Tool\ArrayConverter;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayConverterTest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ArrayConverterTest extends TestCase
{
    public function testFromArray()
    {
        /** @var Abonnement $model */
        $model = ArrayConverter::fromArray(Abonnement::class, [
            'idRessource' => 'A',
            'idAbonnement' => 'foo',
        ]);
        
        $this->assertInstanceOf(Abonnement::class, $model);
        $this->assertEquals('A', $model->getIdRessource());
        $this->assertEquals('foo', $model->getIdAbonnement());
    }
    
    public function testFromArraySnakeCase()
    {
        /** @var Abonnement $model */
        $model = ArrayConverter::fromArray(Abonnement::class, [
            'ID_RESSOURCE' => 'A',
            'ID_ABONNEMENT' => 'foo',
        ]);
        
        $this->assertInstanceOf(Abonnement::class, $model);
        $this->assertEquals('A', $model->getIdRessource());
        $this->assertEquals('foo', $model->getIdAbonnement());
    }
    
    public function testToArray()
    {
        $filtre = new Filtre('A', 'foo');
        
        $array = ArrayConverter::toArray($filtre);
        $this->assertIsArray($array);
        $this->assertCount(2, $array);
        $this->assertArrayHasKey('filtreNom', $array);
        $this->assertArrayHasKey('filtreValeur', $array);
        $this->assertEquals('A', $array['filtreNom']);
        $this->assertEquals('foo', $array['filtreValeur']);
    }
}
