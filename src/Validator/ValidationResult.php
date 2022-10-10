<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Validator;

/**
 * Class ValidationResult
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ValidationResult
{
    /** @var array|Violation[] */
    protected $violations;

    /**
     * ValidationResult constructor
     */
    public function __construct()
    {
        $this->setViolations([]);
    }

    /**
     * @return array|Violation[]
     */
    public function getViolations(): array
    {
        return $this->violations;
    }

    /**
     * @param array|Violation[] $violations
     *
     * @return $this
     */
    public function setViolations(array $violations): ValidationResult
    {
        $this->violations = $violations;

        return $this;
    }

    /**
     * @param Violation $violation
     *
     * @return void
     */
    public function addViolation(Violation $violation)
    {
        $this->violations[] = $violation;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return count($this->getViolations()) === 0;
    }
}
