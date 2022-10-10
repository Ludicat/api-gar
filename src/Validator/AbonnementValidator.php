<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Validator;

use Ludicat\ApiGar\Model\Abonnement;

/**
 * Class AbonnementValidator
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class AbonnementValidator
{
    protected $requiredProperties = [
        'idAbonnement',
        'idRessource',
        'typeIdRessource',
        'libelleRessource',
        'categorieAffectation',
        'typeAffectation',
        'publicCible',
    ];
    
    public function validate(Abonnement $abonnement)
    {
        $validationResult = new ValidationResult();
        
        // Mandatory fields
        foreach ($this->requiredProperties as $property) {
            if (empty($abonnement->{'get'.ucfirst($property)}())) {
                $validationResult->addViolation(new Violation(
                    $property,
                    sprintf('Property %s is empty', $property)
                ));
            }
        }
        
        $this->rg1($abonnement, $validationResult);
        $this->rg2($abonnement, $validationResult);
        $this->rg3($abonnement, $validationResult);
        $this->rg4($abonnement, $validationResult);
        $this->rg5($abonnement, $validationResult);
        $this->rg6($abonnement, $validationResult);
        $this->rg7($abonnement, $validationResult);
        $this->rg8($abonnement, $validationResult);
        $this->rg9($abonnement, $validationResult);
        $this->rg10($abonnement, $validationResult);
        $this->rg11($abonnement, $validationResult);
        $this->rg12($abonnement, $validationResult);
        $this->rg13($abonnement, $validationResult);
        
        return $validationResult;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg1(Abonnement $abonnement, ValidationResult $validationResult)
    {
        if (
            !($abonnement->getNbLicenceGlobale()
                xor ($abonnement->getNbLicenceEleve() ||
                    $abonnement->getNbLicenceAutrePersonnel() ||
                    $abonnement->getNbLicenceEnseignant() ||
                    $abonnement->getNbLicenceProfDoc()
                ))
        ) {
            $validationResult->addViolation(
                new Violation(
                    'nbLicenceGlobale',
                    'RG1 :Must set nbLicenceGlobale XOR at least 1 licence for any other type'
                )
            );
        }
        
        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg2(Abonnement $abonnement, ValidationResult $validationResult)
    {
        if (!($abonnement->getUaiEtab() xor $abonnement->getCodeNatureUAI())) {
            $validationResult->addViolation(
                new Violation(
                    'uaiEtab',
                    'RG2: Must set uaiEtab XOR codeNatureUAI'
                )
            );
        }

        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg3(Abonnement $abonnement, ValidationResult $validationResult)
    {
        if (!preg_match('/[0-9]{9}_[0-9]{16}/', $abonnement->getIdDistributeurCom())) {
            $validationResult->addViolation(
                new Violation(
                    'idDistributeurCom',
                    'RG3: Must be SIREN_ISNI, matching expression /[0-9]{9}_[0-9]{16}/'
                )
            );
        }

        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg4(Abonnement $abonnement, ValidationResult $validationResult)
    {
        if ($abonnement->getCategorieAffectation() !== Abonnement::CATEGORY_TRANSFERABLE) {
            $validationResult->addViolation(
                new Violation(
                    'categorieAffectation',
                    'RG4: Value must be "transferable"'
                )
            );
        }
        
        if (
            !in_array($abonnement->getTypeAffectation(), [
                Abonnement::TYPE_INDIV,
                Abonnement::TYPE_ETABL,
            ])
        ) {
            $validationResult->addViolation(
                new Violation(
                    'typeAffectation',
                    sprintf(
                        'RG4: Value must one of the following: %s',
                        implode(', ', [
                            Abonnement::TYPE_INDIV,
                            Abonnement::TYPE_ETABL,
                        ])
                    )
                )
            );
        }

        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg5(Abonnement $abonnement, ValidationResult $validationResult)
    {
        $list = [
            'nbLicenceEnseignant' => Abonnement::PUBLIC_CIBLE_ENSEIGNANT,
            'nbLicenceEleve' => Abonnement::PUBLIC_CIBLE_ELEVE,
            'nbLicenceProfDoc' => Abonnement::PUBLIC_CIBLE_DOCUMENTALISTE,
            'nbLicenceAutrePersonnel' => Abonnement::PUBLIC_CIBLE_AUTRE_PERSONNEL,
        ];
        
        foreach ($list as $key => $value) {
            if (!$abonnement->{'get' . ucfirst($key)}()) {
                continue;
            }

            if (!$abonnement->hasPublicCible($value)) {
                $validationResult->addViolation(
                    new Violation(
                        $key,
                        sprintf(
                            'RG5: Setting %s required to add public cible value "%s"',
                            $key,
                            $value
                        )
                    )
                );
            }
        }

        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg6(Abonnement $abonnement, ValidationResult $validationResult)
    {
        // Apply only on ETABL type
        if (Abonnement::TYPE_ETABL !== $abonnement->getTypeAffectation()) {
            return $this;
        }
        
        $haveNbLicence = false;
        foreach (
            [
                'nbLicenceEnseignant' => Abonnement::PUBLIC_CIBLE_ENSEIGNANT,
                'nbLicenceEleve' => Abonnement::PUBLIC_CIBLE_ELEVE,
                'nbLicenceProfDoc' => Abonnement::PUBLIC_CIBLE_DOCUMENTALISTE,
                'nbLicenceAutrePersonnel' => Abonnement::PUBLIC_CIBLE_AUTRE_PERSONNEL,
            ] as $key => $value
        ) {
            if ($abonnement->{'get' . ucfirst($key)}()) {
                $haveNbLicence = true;
                break;
            }
        }
    
        if ($haveNbLicence || !$abonnement->getNbLicenceGlobale()) {
            $validationResult->addViolation(
                new Violation(
                    'nbLicenceGlobale',
                    'RG6: Affectation type "ETABL" must define a number of global licences and NO other ones.'
                )
            );
        }
        
        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     * @throws \Exception
     */
    public function rg7(Abonnement $abonnement, ValidationResult $validationResult)
    {
        // only applies on explicit end date
        if (!$abonnement->getAnneeFinValidite()
            || !preg_match('/[0-9]{4}-[0-9]{4}/', $abonnement->getAnneeFinValidite())
        ) {
            return $this;
        }

        $dates = explode('-', $abonnement->getAnneeFinValidite());
        if ($dates[1] - $dates[0] > 10) {
            $validationResult->addViolation(new Violation(
                'anneeFinValidite',
                'RG7: Can\'t be more than 10 school years'
            ));
        }
        if ($dates[0] >= $dates[1]) {
            $validationResult->addViolation(new Violation(
                'anneeFinValidite',
                'RG7: Second year can\'t be before or equal to the first one'
            ));
        }
        
        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     * @throws \Exception
     */
    public function rg8(Abonnement $abonnement, ValidationResult $validationResult)
    {
        // only applies on explicit end date
        if (!$abonnement->getFinValidite() || !$abonnement->getDebutValidite()) {
            return $this;
        }

        $beginAt = new \DateTime($abonnement->getDebutValidite());
        $endAt = new \DateTime($abonnement->getFinValidite());
        if ($beginAt->diff($endAt)->y >= 10) {
            $validationResult->addViolation(
                new Violation(
                    'finValidite',
                    'RG8: Can\'t be more than 10 school years from creation date'
                )
            );
        }

        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg9(Abonnement $abonnement, ValidationResult $validationResult)
    {
        if (!(
            $abonnement->getAnneeFinValidite()
            xor $abonnement->getFinValidite()
        )) {
            $validationResult->addViolation(
                new Violation(
                    'anneeFinValidite',
                    'RG9: There must be either anneeFinValidite or either finValidate filled, not both.'
                )
            );
        }
        
        return $this;
    }

    public function rg10(Abonnement $abonnement, ValidationResult $validationResult)
    {
        if (!$abonnement->getFinValidite()
            && $abonnement->getAnneeFinValidite()
            && !preg_match('/[0-9]{4}-[0-9]{4}/', $abonnement->getAnneeFinValidite())
        ) {
            $validationResult->addViolation(
                new Violation(
                    'anneeFinValidite',
                    'RG10: Must match /[0-9]{4}-[0-9]{4}/, ex: 2020-2021'
                )
            );
        }
            
        return $this;
    }

    /**
     * This rule is kept empty as we can't validate it on our side.
     * 
     * "Une vérification sur le degré de l’établissement/école (1r degré, 2e degré, …) est effectuée
     * lors de la création ou la modification d’un abonnement. Si l’abonnement porte sur un
     * établissement/école de premier degré, le public cible ne doit pas inclure les enseignants-
     * documentalistes et le nombre de licences pour les enseignants-documentalistes ne doit
     * pas être renseigné ou avoir la valeur 0."
     * 
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg11(Abonnement $abonnement, ValidationResult $validationResult)
    {
        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg12(Abonnement $abonnement, ValidationResult $validationResult)
    {
        if (in_array($abonnement->getIdAbonnement(), [
            'abonnements',
            'categorie'
        ])) {
            $validationResult->addViolation(
                new Violation(
                    'idAbonnement',
                    'RG12: Value is forbidden'
                )
            );
        }
        
        return $this;
    }

    /**
     * @param Abonnement $abonnement
     * @param ValidationResult $validationResult
     *
     * @return $this
     */
    public function rg13(Abonnement $abonnement, ValidationResult $validationResult)
    {
        if (0 === strpos($abonnement->getIdAbonnement(), '_')) {
            $validationResult->addViolation(
                new Violation(
                    'idAbonnement',
                    'RG13: Can\'t use _ as first char (reserved for deleted ones)'
                )
            );
        }
        
        return $this;
    }
}
