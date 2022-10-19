<?php
/**
 * @licence Proprietary
 */
namespace Test\Ludicat\ApiGar\Model\AbonnementTest;

use Ludicat\ApiGar\Model\AbonnementFilter;
use Ludicat\ApiGar\Model\Filtre;
use Ludicat\ApiGar\Model\FiltreParDate;
use PHPUnit\Framework\TestCase;

/**
 * Class AbonnementFilterTest
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class AbonnementFilterTest extends TestCase
{
    /** @var AbonnementFilter */
    protected $abonnementFilter;

    public function setUp(): void
    {
        parent::setUp();

        $this->abonnementFilter = new AbonnementFilter();
    }
    
    public function testAddFilter()
    {
        $this->assertCount(0, $this->abonnementFilter->getFiltre());
        $this->abonnementFilter->addFiltre(new Filtre('a', 'foo'));
        $this->assertCount(1, $this->abonnementFilter->getFiltre());
        $this->abonnementFilter->setFiltre([]);
        $this->assertCount(0, $this->abonnementFilter->getFiltre());
    }
    
    public function testAddFilterParDate()
    {
        $this->assertCount(0, $this->abonnementFilter->getFiltreParDate());
        $this->abonnementFilter->addFiltreParDate(new FiltreParDate('A', 'foo', 'bar'));
        $this->assertCount(1, $this->abonnementFilter->getFiltreParDate());
        $this->abonnementFilter->setFiltreParDate([]);
        $this->assertCount(0, $this->abonnementFilter->getFiltreParDate());
    }
}
