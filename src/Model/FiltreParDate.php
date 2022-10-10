<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Model;

/**
 * Class FiltreParDate
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class FiltreParDate
{
    public const DATE_NAME_DATE_CREATION = 'dateCreation';
    public const DATE_NAME_DATE_MODIFICATION = 'dateModification';
    public const DATE_NAME_DEBUT_VALIDITE = 'debutValidite';
    public const DATE_NAME_FIN_VALIDITE = 'finValidite';

    /**
     * FiltreParDate constructor
     *
     * @param string $dateName
     * @param string $dateAvant
     * @param string $dateApres
     */
    public function __construct(
        string $dateName,
        string $dateAvant,
        string $dateApres
    )
    {
        $this
            ->setDateName($dateName)
            ->setDateAvant($dateAvant)
            ->setDateApres($dateApres)
        ;
    }

    /** @var string */
    protected $dateName;
    
    /** @var string */
    protected $dateAvant;
    
    /** @var string */
    protected $dateApres;

    /**
     * @return string
     */
    public function getDateName(): string
    {
        return $this->dateName;
    }

    /**
     * @param string $dateName
     *
     * @return $this
     */
    public function setDateName(string $dateName): FiltreParDate
    {
        $this->dateName = $dateName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateAvant(): string
    {
        return $this->dateAvant;
    }

    /**
     * @param string $dateAvant
     *
     * @return $this
     */
    public function setDateAvant(string $dateAvant): FiltreParDate
    {
        $this->dateAvant = $dateAvant;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateApres(): string
    {
        return $this->dateApres;
    }

    /**
     * @param string $dateApres
     *
     * @return $this
     */
    public function setDateApres(string $dateApres): FiltreParDate
    {
        $this->dateApres = $dateApres;

        return $this;
    }
}
