<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Adapter;

use Ludicat\ApiGar\Model\Abonnement;
use Ludicat\ApiGar\Model\AbonnementFilter;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface AbonnementWsInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface AbonnementWsInterface
{
    public const ENDPOINT_DEV = 'https://abonnement.partenaire.test-gar.education.fr';
    public const ENDPOINT_PROD = 'https://abonnement.gar.education.fr';

    /**
     * Perform PUT (?!) call
     *
     * @param Abonnement $abonnement
     *
     * @return ResponseInterface
     */
    function create(Abonnement $abonnement);

    /**
     * Perform POST (?!) call
     *
     * @param Abonnement $abonnement
     *
     * @return ResponseInterface
     */
    function update(Abonnement $abonnement);

    /**
     * Perform DELETE call
     *
     * @param Abonnement $abonnement
     *
     * @return ResponseInterface
     */
    function delete(Abonnement $abonnement);

    /**
     * Perform GET call to fetch an abonnement list
     *
     * @param AbonnementFilter|null $abonnementFilter
     * @param int $first
     * @param int $maxResult
     *
     * @return ResponseInterface
     */
    function getAbonnements(
        ?AbonnementFilter $abonnementFilter = null,
        int $first = 0,
        int $maxResult = 5000
    );

    /**
     * Perform a GET call to fetch all etablissement list
     * 
     * @return ResponseInterface
     */
    function getEtablissements();
}
