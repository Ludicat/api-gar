<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Model;

/**
 * Class Etablissement
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Etablissement
{
    /**
     * @var string|null
     * 
     * unité administrative immatriculée. Identifiant de l’établissement
     */
    protected $uai;

    /**
     * @var string|null
     * 
     * Nature codifiée de l’établissement
     */
    protected $nature_uai;

    /**
     * @var string|null
     * 
     * Nature de l’établissement au format texte
     */
    protected $nature_uai_libe;

    /**
     * @var string|null
     * 
     * Type codifié de l’établissement
     */
    protected $type_uai;

    /**
     * @var string|null
     * 
     * Type de l’établissement au format texte
     */
    protected $type_uai_libe;

    /**
     * @var string|null
     * 
     * Code postal de la commune de l’établissement
     */
    protected $commune;

    /**
     * @var string|null
     * 
     * Dénomination de la commune de l’établissement
     */
    protected $commune_libe;

    /**
     * @var string|null
     * 
     * Identifiant de l’académie
     */
    protected $academie;

    /**
     * @var string|null
     * 
     * Dénomination de l’académie
     */
    protected $academie_libe;

    /**
     * @var string|null
     * 
     * Numéro du département
     */
    protected $departement_insee_3;

    /**
     * @var string|null
     * 
     * Dénomination du département
     */
    protected $departement_insee_3_libe;

    /**
     * @var string|null
     * 
     * Dénomination de l’établissement
     */
    protected $appellation_officielle;

    /**
     * @var string|null
     * 
     * Patronyme de l’établissement
     */
    protected $patronyme_uai;

    /**
     * @var string|null
     * 
     * Code postal de la commune d’acheminement postale de l’établissement
     */
    protected $code_postal_uai;

    /**
     * @var string|null
     * 
     * Commune d’acheminement postale de l’établissement
     */
    protected $localite_acheminement_uai;

    /**
     * @var string|null
     * 
     * Identifiant de l’ENT auquel est rattaché l’établissement encodé en base 64
     */
    protected $idENT;

    /**
     * @return string|null
     */
    public function getUai(): ?string
    {
        return $this->uai;
    }

    /**
     * @param string $uai
     *
     * @return $this
     */
    public function setUai(?string $uai): Etablissement
    {
        $this->uai = $uai;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNatureUai(): ?string
    {
        return $this->nature_uai;
    }

    /**
     * @param string $nature_uai
     *
     * @return $this
     */
    public function setNatureUai(?string $nature_uai): Etablissement
    {
        $this->nature_uai = $nature_uai;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNatureUaiLibe(): ?string
    {
        return $this->nature_uai_libe;
    }

    /**
     * @param string $nature_uai_libe
     *
     * @return $this
     */
    public function setNatureUaiLibe(?string $nature_uai_libe): Etablissement
    {
        $this->nature_uai_libe = $nature_uai_libe;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeUai(): ?string
    {
        return $this->type_uai;
    }

    /**
     * @param string $type_uai
     *
     * @return $this
     */
    public function setTypeUai(?string $type_uai): Etablissement
    {
        $this->type_uai = $type_uai;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeUaiLibe(): ?string
    {
        return $this->type_uai_libe;
    }

    /**
     * @param string $type_uai_libe
     *
     * @return $this
     */
    public function setTypeUaiLibe(?string $type_uai_libe): Etablissement
    {
        $this->type_uai_libe = $type_uai_libe;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommune(): ?string
    {
        return $this->commune;
    }

    /**
     * @param string $commune
     *
     * @return $this
     */
    public function setCommune(?string $commune): Etablissement
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommuneLibe(): ?string
    {
        return $this->commune_libe;
    }

    /**
     * @param string $commune_libe
     *
     * @return $this
     */
    public function setCommuneLibe(?string $commune_libe): Etablissement
    {
        $this->commune_libe = $commune_libe;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAcademie(): ?string
    {
        return $this->academie;
    }

    /**
     * @param string $academie
     *
     * @return $this
     */
    public function setAcademie(?string $academie): Etablissement
    {
        $this->academie = $academie;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAcademieLibe(): ?string
    {
        return $this->academie_libe;
    }

    /**
     * @param string $academie_libe
     *
     * @return $this
     */
    public function setAcademieLibe(?string $academie_libe): Etablissement
    {
        $this->academie_libe = $academie_libe;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepartementInsee3(): ?string
    {
        return $this->departement_insee_3;
    }

    /**
     * @param string $departement_insee_3
     *
     * @return $this
     */
    public function setDepartementInsee3(?string $departement_insee_3): Etablissement
    {
        $this->departement_insee_3 = $departement_insee_3;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepartementInsee3Libe(): ?string
    {
        return $this->departement_insee_3_libe;
    }

    /**
     * @param string $departement_insee_3_libe
     *
     * @return $this
     */
    public function setDepartementInsee3Libe(?string $departement_insee_3_libe): Etablissement
    {
        $this->departement_insee_3_libe = $departement_insee_3_libe;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAppellationOfficielle(): ?string
    {
        return $this->appellation_officielle;
    }

    /**
     * @param string $appellation_officielle
     *
     * @return $this
     */
    public function setAppellationOfficielle(?string $appellation_officielle): Etablissement
    {
        $this->appellation_officielle = $appellation_officielle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPatronymeUai(): ?string
    {
        return $this->patronyme_uai;
    }

    /**
     * @param string $patronyme_uai
     *
     * @return $this
     */
    public function setPatronymeUai(?string $patronyme_uai): Etablissement
    {
        $this->patronyme_uai = $patronyme_uai;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodePostalUai(): ?string
    {
        return $this->code_postal_uai;
    }

    /**
     * @param string $code_postal_uai
     *
     * @return $this
     */
    public function setCodePostalUai(?string $code_postal_uai): Etablissement
    {
        $this->code_postal_uai = $code_postal_uai;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocaliteAcheminementUai(): ?string
    {
        return $this->localite_acheminement_uai;
    }

    /**
     * @param string $localite_acheminement_uai
     *
     * @return $this
     */
    public function setLocaliteAcheminementUai(?string $localite_acheminement_uai): Etablissement
    {
        $this->localite_acheminement_uai = $localite_acheminement_uai;

        return $this;
    }

    /**
     * @return string|null|null
     */
    public function getIdENT(): ?string
    {
        return $this->idENT;
    }

    /**
     * @param string|null $idENT
     *
     * @return $this
     */
    public function setIdENT(?string $idENT): Etablissement
    {
        $this->idENT = $idENT;

        return $this;
    }
}
