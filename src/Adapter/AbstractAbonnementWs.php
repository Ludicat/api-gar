<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Adapter;

use GuzzleHttp\RequestOptions;
use Http\Client\HttpClient;

/**
 * Class AbstractAbonnementWs
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
abstract class AbstractAbonnementWs implements AbonnementWsInterface
{
    public const PATH_CREATE = '/%s';
    public const PATH_UPDATE = '/%s';
    public const PATH_DELETE = '/%s';
    public const PATH_ABONNEMENTS = '/abonnements';
    public const PATH_ETABLISSEMENTS = '/etablissements/etablissements.xml';
    
    /** @var HttpClient */
    protected $client;

    /** @var string */
    protected $pemFilePath;

    /** @var string */
    protected $keyFilePath;

    /** @var string */
    protected $haricaFilePath;

    /** @var string */
    protected $keyPassword;

    /** @var string */
    protected $baseUri;

    /**
     * @return HttpClient
     */
    abstract protected function getClient();

    /**
     * AbstractAbonnementWs constructor
     *
     * @param string $pemFilePath
     * @param string|null $pemPassword
     * @param string $baseUrl
     */
    public function __construct(
        string $pemFilePath,
        string $keyFilePath,
        string $haricaFilePath = null,
        string $keyPassword = null,
        string $baseUrl = AbonnementWsInterface::ENDPOINT_DEV
    ) {
        $this->pemFilePath = $pemFilePath;
        $this->keyFilePath = $keyFilePath;
        $this->haricaFilePath = $haricaFilePath;
        $this->keyPassword = $keyPassword;
        $this->baseUri = $baseUrl;
    }
    
    protected function getHeaders()
    {
        return [
            'Content-type' => 'application/xml;charset=utf-8',
            'Accept' => 'application/json',
        ];
    }

    /**
     * @return string
     */
    protected function getBaseUri()
    {
        return $this->baseUri;
    }
}
