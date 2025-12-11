<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Adapter;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Http\Client\HttpClient;
use Http\Adapter\Guzzle7\Client as GuzzleClient;
use Ludicat\ApiGar\Model\Abonnement;
use Ludicat\ApiGar\Model\AbonnementFilter;
use Ludicat\ApiGar\Tool\ArrayConverter;
use Ludicat\ApiGar\Tool\ArrayToXmlParser;

/**
 * Class GuzzleAdapter
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class GuzzleAdapter extends AbstractAbonnementWs
{
    /**
     * @return HttpClient
     */
    protected function getClient()
    {
        if (!$this->client) {
            $config = [
                'base_uri' => $this->getBaseUri(),
                RequestOptions::CERT => $this->pemFilePath,
                RequestOptions::SSL_KEY => [
                    $this->keyFilePath,
                    $this->keyPassword
                ],
            ];
            // Add verify if needed only
            if ($this->haricaFilePath) {
                $config[RequestOptions::VERIFY] = $this->haricaFilePath;
            }

            $this->client = GuzzleClient::createWithConfig($config);
        }
        
        return $this->client;
    }

    /**
     * @param Abonnement $abonnement
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \ReflectionException
     */
    public function create(Abonnement $abonnement)
    {
        $xml = ArrayToXmlParser::convert(
            ArrayConverter::toArray($abonnement)
        );
        
        $request = new Request(
            'PUT', // Yes PUT is on purpose
            sprintf('%s%s',
                $this->getBaseUri(),
                sprintf(static::PATH_CREATE, $abonnement->getIdAbonnement())
            ),
            $this->getHeaders(),
            $xml
        );
        
        return $this->getClient()->sendRequest($request);
    }

    /**
     * @param Abonnement $abonnement
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \ReflectionException
     */
    public function update(Abonnement $abonnement)
    {
        $xml = ArrayToXmlParser::convert(
            ArrayConverter::toArray($abonnement)
        );

        $request = new Request(
            'POST', // Yes POST is on purpose
            sprintf(
                '%s%s',
                $this->getBaseUri(),
                sprintf(static::PATH_CREATE, $abonnement->getIdAbonnement())
            ),
            $this->getHeaders(),
            $xml
        );

        return $this->getClient()->sendRequest($request);
    }

    /**
     * @param Abonnement $abonnement
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function delete(Abonnement $abonnement)
    {
        $request = new Request(
            'DELETE',
            sprintf(
                '%s%s',
                $this->getBaseUri(),
                sprintf(static::PATH_CREATE, $abonnement->getIdAbonnement())
            ),
            $this->getHeaders()
        );

        return $this->getClient()->sendRequest($request);
    }

    /**
     * @param AbonnementFilter|null $abonnementFilter
     * @param int $first
     * @param int $maxResult
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getAbonnements(
        ?AbonnementFilter $abonnementFilter = null,
        int $first = 0,
        int $maxResult = 5000
    ) {
        if (!$abonnementFilter) {
            $abonnementFilter = new AbonnementFilter();
            $abonnementFilter
                ->setTriPar(AbonnementFilter::TRI_PAR_ID_ABONNEMENT)
                ->setTri(AbonnementFilter::TRI_ASC)
            ;
        }
        $xml = ArrayToXmlParser::convert(
            ArrayConverter::toArray($abonnementFilter),
            '<filtres xmlns="http://www.atosworldline.com/wsabonnement/v1.0/" />'
        );
        
        $request = new Request(
            'GET',
            sprintf(
                '%s%s?%s',
                $this->getBaseUri(),
                static::PATH_ABONNEMENTS,
                http_build_query([
                    'debut' => $first,
                    'fin' => $maxResult,
                ])
            ),
            $this->getHeaders(),
            $xml
        );

        return $this->getClient()->sendRequest($request);
    }

    /**
     * @param AbonnementFilter|null $abonnementFilter
     * @param int $first
     * @param int $maxResult
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getEtablissements()
    {
        $request = new Request(
            'GET',
            static::PATH_ETABLISSEMENTS,
            $this->getHeaders()
        );

        return $this->getClient()->sendRequest($request);
    }
}
