<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar;

use Ludicat\ApiGar\Adapter\AbonnementWsInterface;
use Ludicat\ApiGar\Model\Abonnement;
use Ludicat\ApiGar\Model\AbonnementFilter;
use Ludicat\ApiGar\Model\Etablissement;
use Ludicat\ApiGar\Model\ServiceProvider;
use Ludicat\ApiGar\Tool\ArrayConverter;

/**
 * Class Client
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Client
{
    /** @var AbonnementWsInterface */
    protected $adapter;
    
    /** @var ServiceProvider */
    protected $serviceProvider;

    /**
     * Client constructor
     *
     * @param AbonnementWsInterface $adapter
     * @param ServiceProvider $serviceProvider
     */
    public function __construct(
        AbonnementWsInterface $adapter,
        ServiceProvider $serviceProvider
    )
    {
        $this->adapter = $adapter;
        $this->serviceProvider = $serviceProvider;
    }

    /**
     * @param Abonnement $abonnement
     *
     * @return void
     */
    protected function setDefaults(Abonnement $abonnement)
    {
        if (!$abonnement->getIdDistributeurCom()) {
            $abonnement->setIdDistributeurCom(
                sprintf(
                    '%s_%s',
                    $this->serviceProvider->getSiret(),
                    $this->serviceProvider->getIsni()
                )
            );
        }
        
        if (!$abonnement->getIdRessource()) {
            $abonnement
                ->setIdRessource($this->serviceProvider->getIdRessource())
                ->setTypeIdRessource(Abonnement::TYPE_ID_RESSOURCE_ARK)
            ;
        }
    }

    /**
     * @param Abonnement $abonnement
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(Abonnement $abonnement)
    {
        $this->setDefaults($abonnement);
        
        return $this->adapter->create($abonnement);
    }

    /**
     * @param Abonnement $abonnement
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(Abonnement $abonnement)
    {
        $requested = clone $abonnement;
        $requested
            ->setUaiEtab([])
        ;

        return $this->adapter->update($requested);
    }

    /**
     * Please note that a success response is 204 "no content"
     * 
     * @param Abonnement $abonnement
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(Abonnement $abonnement)
    {
        return $this->adapter->delete($abonnement);
    }

    /**
     * @param AbonnementFilter|null $abonnementFilter
     * @param int $first
     * @param int $maxResult
     *
     * @return \Psr\Http\Message\ResponseInterface|Abonnement[]|array
     */
    public function getAbonnements(
        ?AbonnementFilter $abonnementFilter = null,
        int $first = 0,
        int $maxResult = 5000
    ) {
        $response = $this->adapter->getAbonnements($abonnementFilter, $first, $maxResult);
        if (200 !== $response->getStatusCode()) {
            return $response;
        }
        
        $arrayResponse = json_decode($response->getBody()->getContents(), true);
        $data = [];
        foreach ($arrayResponse['abonnements'] as $row) {
            $data[] = ArrayConverter::fromArray(Abonnement::class, $row);
        }
        
        return $data;
    }
    
    public function getEtablissements()
    {
        $response = $this->adapter->getEtablissements();
        if (200 !== $response->getStatusCode()) {
            return $response;
        }

        $xml = simplexml_load_string($response->getBody()->getContents(), "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $arrayResponse = json_decode($json, true);
        
        $data = [];
        foreach ($arrayResponse['etablissement'] as $row) {
            foreach ($row as $key => &$value) {
                if (empty($value)) {
                    unset($row[$key]);
                    
                    continue;
                }
                
                if ('idENT' == $key) {
                    $value = base64_decode($value);
                }
            }
            
            $data[] = ArrayConverter::fromArray(Etablissement::class, $row);
        }

        return $data;
    }
}
