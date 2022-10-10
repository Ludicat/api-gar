<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Model;

/**
 * Class ServiceProvider
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ServiceProvider
{
    public const ISNI_NONE = '0000000000000000';
    
    /**
     * ServiceProvider constructor
     *
     * @param string $siret
     * @param string $isni
     * @param string|null $idRessource
     */
    public function __construct(
        string $siret,
        string $isni = self::ISNI_NONE,
        ?string $idRessource = null
    ) {
        $this->siret = $siret;
        $this->isni = $isni;
        $this->idRessource = $idRessource;
    }

    /**
     * Your company siret number.
     * 9 characters length
     * 
     * @var string|null
     */
    protected $siret;

    /**
     * A number prefixed with 0.
     * 16 character length
     * 
     * @var string|null
     */
    protected $isni;

    /**
     * Your ark number
     * 
     * @var string|null
     */
    protected $isResource;

    /**
     * @return string|null
     */
    public function getSiret(): ?string
    {
        return $this->siret;
    }

    /**
     * @param string|null $siret
     *
     * @return $this
     */
    public function setSiret(?string $siret): ServiceProvider
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsni(): ?string
    {
        return $this->isni;
    }

    /**
     * @param string|null $isni
     *
     * @return $this
     */
    public function setIsni(?string $isni): ServiceProvider
    {
        $this->isni = $isni;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIdRessource(): ?string
    {
        return $this->idRessource;
    }

    /**
     * @param string|null $idRessource
     *
     * @return $this
     */
    public function setIdRessource(?string $idRessource): ServiceProvider
    {
        $this->idRessource = $idRessource;

        return $this;
    }
}
