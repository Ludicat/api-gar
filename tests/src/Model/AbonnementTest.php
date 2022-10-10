<?php
/**
 * @licence Proprietary
 */
namespace Test\Ludicat\ApiGar\Model\AbonnementTest;

use Ludicat\ApiGar\Model\Abonnement;
use PHPUnit\Framework\TestCase;

/**
 * Class AbonnementTest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class AbonnementTest extends TestCase
{
    /** @var Abonnement */
    protected $abonnement;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->abonnement = new Abonnement();
    }
    
    public function testGetSetPublicCible()
    {
        $result = $this->abonnement->getPublicCible();
        $this->assertIsArray($result);
        $this->assertCount(0, $result);
        
        $test = ['test'];
        $this->abonnement->setPublicCible($test);
        $result = $this->abonnement->getPublicCible();
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals($test, $result);
    }
    
    public function testHasPublicCible()
    {
        $test = ['test'];
        $this->abonnement->setPublicCible($test);
        
        $this->assertTrue($this->abonnement->hasPublicCible($test[0]));
        $this->assertFalse($this->abonnement->hasPublicCible('foo'));
    }
    
    public function testAddPublicCible()
    {
        $test = ['test'];
        $this->abonnement->addPublicCible($test[0]);
        $result = $this->abonnement->getPublicCible();
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals($test, $result);
        
        // Should not add
        $this->abonnement->addPublicCible($test[0]);
        $result = $this->abonnement->getPublicCible();
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals($test, $result);
        
        // This time should add as it's different
        $this->abonnement->addPublicCible('foo');
        $result = $this->abonnement->getPublicCible();
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $test[] = 'foo';
        $this->assertEquals($test, $result);
    }
    
    public function testRemovePublicCible()
    {
        $test = ['test', 'foo', 'bar'];
        $this->abonnement->setPublicCible($test);
        $this->abonnement->removePublicCible('foo');
        $result = $this->abonnement->getPublicCible();
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals(['test', 'bar'], $result);
    }
}
