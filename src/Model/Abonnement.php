<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Model;

/**
 * Class Abonnement
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Abonnement
{
    public const TYPE_ETABL = 'ETABL';
    public const TYPE_INDIV = 'INDIV';
    
    public const TYPE_ID_RESSOURCE_ARK = 'ark';
    
    public const UNLIMITED_LICENCE = 'ILLIMITE';
    
    public const CATEGORY_TRANSFERABLE = 'transferable';
    public const CATEGORY_NON_TRANSFERABLE = 'non transferable';
    
    public const PUBLIC_CIBLE_ELEVE = 'ELEVE';
    public const PUBLIC_CIBLE_ENSEIGNANT = 'ENSEIGNANT';
    public const PUBLIC_CIBLE_DOCUMENTALISTE = 'DOCUMENTALISTE';
    public const PUBLIC_CIBLE_AUTRE_PERSONNEL = 'AUTRE PERSONNEL';

    /**
     * @return string[]|array
     */
    public static function getAllPublicCible()
    {
        return [
            static::PUBLIC_CIBLE_ELEVE,
            static::PUBLIC_CIBLE_ENSEIGNANT,
            static::PUBLIC_CIBLE_DOCUMENTALISTE,
            static::PUBLIC_CIBLE_AUTRE_PERSONNEL,
        ];
    }

    /**
     * Abonnement constructor
     *
     * @param ServiceProvider|null $serviceProvider Prefill related fields if provide
     */
    public function __construct(?ServiceProvider $serviceProvider = null)
    {
        $this
            ->setIdAbonnement(preg_replace_callback(
                '/[xy]/',
                function ($matches) {
                    return dechex('x' == $matches[0] ? mt_rand(0, 15) : (mt_rand(0, 15) & 0x3 | 0x8));
                },
                'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'
            ))
            ->setPublicCible(static::getAllPublicCible())
            ->setUaiEtab([])
        ;
        
        if ($serviceProvider) {
            $this
                ->setIdDistributeurCom(
                    sprintf(
                        '%s_%s',
                        $serviceProvider->getSiret(),
                        $serviceProvider->getIsni()
                    )
                )
                ->setIdRessource($serviceProvider->getIdRessource())
                ->setTypeIdRessource(Abonnement::TYPE_ID_RESSOURCE_ARK)
            ;
        }
    }

    /**
     * Required
     * Default to an uuid v4 (recommended)
     * 
     * Identifiant de l’abonnement
     * L’idAbonnement DOIT être
     * unique
     * 
     * @var string|null Max length 45
     */
    protected $idAbonnement;

    /**
     * Optional
     * 
     * Détail de l’abonnement
     * Libellé libre pour le DCR
     * 
     * @var string|null Max length 255
     */
    protected $commentaireAbonnement;

    /**
     * Required RG3
     *
     * Identifiant du distributeur
     * commercial pour le GAR. Il est
     * composé à partir des données
     * SIREN et ISNI du DCR.
     *
     * @var string|null length 26
     */
    protected $idDistributeurCom;

    /**
     * Required
     * 
     * Identifiant de la ressource d’un
     * éditeur donné par l’autorité de
     * nommage (identifiant figurant
     * dans la notice ScoLOMFR).
     * 
     * @var string|null max length 1024
     */
    protected $idRessource;

    /**
     * Required
     * 
     * Type d’identifiant de la ressource
     * 
     * @var string|null max length 50
     */
    protected $typeIdRessource;

    /**
     * Required
     * 
     * Titre de la ressource d’un éditeur objet de l’abonnement
     * (élément title de la notice Scolomfr)
     * 
     * @var string|null max length 255
     */
    protected $libelleRessource;

    /**
     * Required RG7
     * 
     * Date de début de validité de la licence.
     * 
     * @var string|null Date ISO 8601 AAAA-MM-DD
     */
    protected $debutValidite;

    /**
     * Optional RG7, RG9
     * 
     * Date de début de validité de la licence.
     * 
     * @var string|null Date ISO 8601 AAAA-MM-DD
     */
    protected $finValidite;

    /**
     * Optional RG7, RG9
     * 
     * Année scolaire de fin de validité Chaîne de la licence
     * 
     * @var string|null max length 45
     */
    protected $anneeFinValidite;

    /**
     * Optional RG2
     * Multiple
     * 
     * UAI de l’établissement ou de l’école.
     * Dans le cas d’une liste d’établissements/écoles, l’élément uaiEtab est répété.
     * 
     * @var array|string[]|null max length 45 
     */
    protected $uaiEtab;

    /**
     * Optional RG2
     * Multiple
     * 
     * Code de la nature de l’UAI (nomenclature N_NATURE_UAI). Valeurs séparées par des « , »
     * 
     * @var string|null
     */
    protected $codeNatureUAI;

    /**
     * Required
     * 
     * Catégorie d'affectation dans le GAR : "transferable"
     * 
     * @var string|null max length 45
     */
    protected $categorieAffectation;

    /**
     * Required
     * 
     * Type d’affectation dans le GAR
     * ETABL : pour Établissement/école
     * INDIV : pour Individuelle (a privilégier)
     * 
     * @var string|null
     */
    protected $typeAffectation;

    /**
     * Optional RG1
     * 
     * Nombre de licences enseignants.
     * Valeurs possibles : Nombre ou « ILLIMITE »
     * 
     * @var string|int|null
     */
    protected $nbLicenceEnseignant;

    /**
     * Optional RG1
     *
     * Nombre de licences élèves.
     * Valeurs possibles : Nombre ou « ILLIMITE »
     *
     * @var string|int|null
     */
    protected $nbLicenceEleve;

    /**
     * Optional RG1
     *
     * Nombre de licences enseignants-documentalistes.
     * Valeurs possibles : Nombre ou « ILLIMITE »
     *
     * @var string|int|null
     */
    protected $nbLicenceProfDoc;

    /**
     * Optional RG1
     *
     * Nombre de licences autre personnels.
     * Valeurs possibles : Nombre ou « ILLIMITE »
     *
     * @var string|int|null
     */
    protected $nbLicenceAutrePersonnel;

    /**
     * Optional RG1
     *
     * Nombre de licences globales.
     * Valeurs possibles : Nombre ou « ILLIMITE »
     *
     * @var string|int|null
     */
    protected $nbLicenceGlobale;

    /**
     * Required
     * Multiple
     * 
     * Pubic cible de l’affectation
     * Valeurs possibles :
     * - ENSEIGNANT
     * - ELEVE
     * - DOCUMENTALISTE
     * - AUTRE PERSONNEL
     * 
     * @var string[]|array
     */
    protected $publicCible;

    /**
     * Optional
     * 
     * Code de projet ressources
     * 
     * @var string|null max length 50
     */
    protected $codeProjetRessource;

    /**
     * @return string|null
     */
    public function getIdAbonnement(): ?string
    {
        return $this->idAbonnement;
    }

    /**
     * @param string|null $idAbonnement
     *
     * @return $this
     */
    public function setIdAbonnement(?string $idAbonnement): Abonnement
    {
        $this->idAbonnement = $idAbonnement;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommentaireAbonnement(): ?string
    {
        return $this->commentaireAbonnement;
    }

    /**
     * @param string|null $commentaireAbonnement
     *
     * @return $this
     */
    public function setCommentaireAbonnement(?string $commentaireAbonnement): Abonnement
    {
        $this->commentaireAbonnement = $commentaireAbonnement;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIdDistributeurCom(): ?string
    {
        return $this->idDistributeurCom;
    }

    /**
     * @param string|null $idDistributeurCom
     *
     * @return $this
     */
    public function setIdDistributeurCom(?string $idDistributeurCom): Abonnement
    {
        $this->idDistributeurCom = $idDistributeurCom;

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
    public function setIdRessource(?string $idRessource): Abonnement
    {
        $this->idRessource = $idRessource;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeIdRessource(): ?string
    {
        return $this->typeIdRessource;
    }

    /**
     * @param string|null $typeIdRessource
     *
     * @return $this
     */
    public function setTypeIdRessource(?string $typeIdRessource): Abonnement
    {
        $this->typeIdRessource = $typeIdRessource;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLibelleRessource(): ?string
    {
        return $this->libelleRessource;
    }

    /**
     * @param string|null $libelleRessource
     *
     * @return $this
     */
    public function setLibelleRessource(?string $libelleRessource): Abonnement
    {
        $this->libelleRessource = $libelleRessource;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDebutValidite(): ?string
    {
        return $this->debutValidite;
    }

    /**
     * @param string|null $debutValidite
     *
     * @return $this
     */
    public function setDebutValidite(?string $debutValidite): Abonnement
    {
        $this->debutValidite = $debutValidite;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFinValidite(): ?string
    {
        return $this->finValidite;
    }

    /**
     * @param string|null $finValidite
     *
     * @return $this
     */
    public function setFinValidite(?string $finValidite): Abonnement
    {
        $this->finValidite = $finValidite;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnneeFinValidite(): ?string
    {
        return $this->anneeFinValidite;
    }

    /**
     * @param string|null $anneeFinValidite
     *
     * @return $this
     */
    public function setAnneeFinValidite(?string $anneeFinValidite): Abonnement
    {
        $this->anneeFinValidite = $anneeFinValidite;

        return $this;
    }

    /**
     * @return array|string[]|null
     */
    public function getUaiEtab(): array
    {
        return $this->uaiEtab;
    }

    /**
     * @param array|string[]|null $uaiEtab
     *
     * @return $this
     */
    public function setUaiEtab(array $uaiEtab): Abonnement
    {
        $this->uaiEtab = $uaiEtab;

        return $this;
    }

    /**
     * @param string $uaiEtab
     *
     * @return false|int|string
     */
    public function hasUaiEtab(string $uaiEtab)
    {
        return false !== array_search($uaiEtab, $this->uaiEtab);
    }

    /**
     * @param string $uaiEtab
     *
     * @return $this
     */
    public function addUaiEtab(string $uaiEtab)
    {
        if (!$this->hasUaiEtab($uaiEtab)) {
            $this->uaiEtab[] = $uaiEtab;
        }

        return $this;
    }

    /**
     * @param string $uaiEtab
     *
     * @return $this
     */
    public function removeUaiEtab(string $uaiEtab)
    {
        if ($this->hasUaiEtab($uaiEtab)) {
            $flipped = array_flip($this->uaiEtab);
            array_splice($this->uaiEtab, $flipped[$uaiEtab], 1);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodeNatureUAI(): ?string
    {
        return $this->codeNatureUAI;
    }

    /**
     * @param string|null $codeNatureUAI
     *
     * @return $this
     */
    public function setCodeNatureUAI(?string $codeNatureUAI): Abonnement
    {
        $this->codeNatureUAI = $codeNatureUAI;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategorieAffectation(): ?string
    {
        return $this->categorieAffectation;
    }

    /**
     * @param string|null $categorieAffectation
     *
     * @return $this
     */
    public function setCategorieAffectation(?string $categorieAffectation): Abonnement
    {
        $this->categorieAffectation = $categorieAffectation;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeAffectation(): ?string
    {
        return $this->typeAffectation;
    }

    /**
     * @param string|null $typeAffectation
     *
     * @return $this
     */
    public function setTypeAffectation(?string $typeAffectation): Abonnement
    {
        $this->typeAffectation = $typeAffectation;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getNbLicenceEnseignant()
    {
        return $this->nbLicenceEnseignant;
    }

    /**
     * @param int|string|null $nbLicenceEnseignant
     *
     * @return $this
     */
    public function setNbLicenceEnseignant($nbLicenceEnseignant): Abonnement
    {
        $this->nbLicenceEnseignant = $nbLicenceEnseignant;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getNbLicenceEleve()
    {
        return $this->nbLicenceEleve;
    }

    /**
     * @param int|string|null $nbLicenceEleve
     *
     * @return $this
     */
    public function setNbLicenceEleve($nbLicenceEleve): Abonnement
    {
        $this->nbLicenceEleve = $nbLicenceEleve;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getNbLicenceProfDoc()
    {
        return $this->nbLicenceProfDoc;
    }

    /**
     * @param int|string|null $nbLicenceProfDoc
     *
     * @return $this
     */
    public function setNbLicenceProfDoc($nbLicenceProfDoc): Abonnement
    {
        $this->nbLicenceProfDoc = $nbLicenceProfDoc;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getNbLicenceAutrePersonnel()
    {
        return $this->nbLicenceAutrePersonnel;
    }

    /**
     * @param int|string|null $nbLicenceAutrePersonnel
     *
     * @return $this
     */
    public function setNbLicenceAutrePersonnel($nbLicenceAutrePersonnel): Abonnement
    {
        $this->nbLicenceAutrePersonnel = $nbLicenceAutrePersonnel;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getNbLicenceGlobale()
    {
        return $this->nbLicenceGlobale;
    }

    /**
     * @param int|string|null $nbLicenceGlobale
     *
     * @return $this
     */
    public function setNbLicenceGlobale($nbLicenceGlobale): Abonnement
    {
        $this->nbLicenceGlobale = $nbLicenceGlobale;

        return $this;
    }

    /**
     * @return string[]|array
     */
    public function getPublicCible(): array
    {
        return $this->publicCible;
    }

    /**
     * @param string[]|array $publicCible
     *
     * @return $this
     */
    public function setPublicCible(array $publicCible): Abonnement
    {
        $this->publicCible = $publicCible;

        return $this;
    }

    /**
     * @param string $publicCible
     *
     * @return false|int|string
     */
    public function hasPublicCible(string $publicCible)
    {
        return false !== array_search($publicCible, $this->publicCible);
    }

    /**
     * @param string $publicCible
     *
     * @return $this
     */
    public function addPublicCible(string $publicCible)
    {
        if (!$this->hasPublicCible($publicCible)) {
            $this->publicCible[] = $publicCible;
        }
        
        return $this;
    }

    /**
     * @param string $publicCible
     *
     * @return $this
     */
    public function removePublicCible(string $publicCible)
    {
        if ($this->hasPublicCible($publicCible)) {
            $flipped = array_flip($this->publicCible);
            array_splice($this->publicCible, $flipped[$publicCible], 1);
        }
        
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodeProjetRessource(): ?string
    {
        return $this->codeProjetRessource;
    }

    /**
     * @param string|null $codeProjetRessource
     *
     * @return $this
     */
    public function setCodeProjetRessource(?string $codeProjetRessource): Abonnement
    {
        $this->codeProjetRessource = $codeProjetRessource;

        return $this;
    }
}
