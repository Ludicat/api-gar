<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Model;

/**
 * Class Filtre
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Filtre
{
    public const FILTRE_ID_DISTRIBUTEUR_COM = 'idDistributeurCom';
    public const FILTRE_UAI_ETAB = 'uaiEtab';
    public const FILTRE_ID_ABONNEMENT = 'idAbonnement';
    public const FILTRE_TYPE_AFFECTATION = 'typeAffectation';
    public const FILTRE_CATEGORY_AFFECTATION = 'categorieAffectation';
    public const FILTRE_PUBLIC_CIBLE = 'publicCible';
    public const FILTRE_CODE_PROJECT_RESSOURCE = 'codeProjetRessource';

    /**
     * Filtre constructor
     *
     * @param string $filtreNom
     * @param $filtreValeur
     */
    public function __construct(
        string $filtreNom,
        $filtreValeur
    )
    {
        $this->filtreNom = $filtreNom;
        $this->filtreValeur = $filtreValeur;
    }

    /** @var string|null */
    protected $filtreNom;
    
    /** @var mixed|null */
    protected $filtreValeur;

    /**
     * @return string|null
     */
    public function getFiltreNom(): ?string
    {
        return $this->filtreNom;
    }

    /**
     * @param string|null $filtreNom
     *
     * @return $this
     */
    public function setFiltreNom(?string $filtreNom): Filtre
    {
        $this->filtreNom = $filtreNom;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getFiltreValeur()
    {
        return $this->filtreValeur;
    }

    /**
     * @param mixed|null $filtreValeur
     *
     * @return $this
     */
    public function setFiltreValeur($filtreValeur): Filtre
    {
        $this->filtreValeur = $filtreValeur;

        return $this;
    }
}
