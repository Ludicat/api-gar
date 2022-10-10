<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Model;

/**
 * Class Filter
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class AbonnementFilter
{
    public const TRI_PAR_ID_ABONNEMENT = 'idAbonnement'; // Default
    public const TRI_PAR_ID_RESSOURCE = 'idRessource';
    public const TRI_PAR_TYPE_ID_RESSOURCE = 'typeIdRessource';
    public const TRI_PAR_LIBELLE_RESSOURCE = 'libelleRessource';
    public const TRI_PAR_ID_DEBUT_VALIDITE = 'debutValidite';
    public const TRI_PAR_ID_FIN_VALIDITE = 'finValidite';
    public const TRI_PAR_ID_CATEGORY_AFFECTATION = 'categorieAffectation';
    public const TRI_PAR_ID_TYPE_AFFECTATION = 'typeAffectation';
    public const TRI_PAR_ID_PUBLIC_CIBLE = 'publicCible';
    public const TRI_PAR_ID_CORE_PROJECT_RESSOURCE = 'codeProjetRessource';
    
    public const TRI_ASC = 'ASC';
    public const TRI_DSC = 'DSC';
    
    public const ABO_SUPPR_INCUDED = true;
    public const ABO_SUPPR_EXCLUDED = false; // Default
    
    public function __construct()
    {
        $this
            ->setFiltre([])
            ->setFiltreParDate([])
        ;
    }

    /** @var array|Filtre[] */
    protected $filtre;
    
    /** @var array|FiltreParDate[] */
    protected $filtreParDate;

    /** @var string|null */
    protected $triPar;

    /** @var string|null */
    protected $tri;
    
    /** @var bool|null */
    protected $aboSuppr;

    /**
     * @return array|Filtre[]
     */
    public function getFiltre(): array
    {
        return $this->filtre;
    }

    /**
     * @param array|Filtre[] $filtre
     *
     * @return $this
     */
    public function setFiltre(array $filtre): AbonnementFilter
    {
        $this->filtre = $filtre;

        return $this;
    }

    /**
     * @param Filtre $filtre
     *
     * @return $this
     */
    public function addFiltre(Filtre $filtre): AbonnementFilter
    {
        $this->filtre[] = $filtre;

        return $this;
    }

    /**
     * @return array|FiltreParDate[]
     */
    public function getFiltreParDate(): array
    {
        return $this->filtreParDate;
    }

    /**
     * @param array|FiltreParDate[] $filtreParDate
     *
     * @return $this
     */
    public function setFiltreParDate(array $filtreParDate): AbonnementFilter
    {
        $this->filtreParDate = $filtreParDate;

        return $this;
    }

    /**
     * @param FiltreParDate $filtreParDate
     *
     * @return $this
     */
    public function addFiltreParDate(FiltreParDate $filtreParDate): AbonnementFilter
    {
        $this->filtreParDate[] = $filtreParDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTriPar(): ?string
    {
        return $this->triPar;
    }

    /**
     * @param string|null $triPar
     *
     * @return $this
     */
    public function setTriPar(?string $triPar): AbonnementFilter
    {
        $this->triPar = $triPar;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTri(): ?string
    {
        return $this->tri;
    }

    /**
     * @param string|null $tri
     *
     * @return $this
     */
    public function setTri(?string $tri): AbonnementFilter
    {
        $this->tri = $tri;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAboSuppr(): ?bool
    {
        return $this->aboSuppr;
    }

    /**
     * @param bool|null $aboSuppr
     *
     * @return $this
     */
    public function setAboSuppr(?bool $aboSuppr): AbonnementFilter
    {
        $this->aboSuppr = $aboSuppr;

        return $this;
    }
}
