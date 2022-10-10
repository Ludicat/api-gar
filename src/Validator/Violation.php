<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Validator;

/**
 * Class Violation
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Violation
{
    /**
     * Violation constructor
     *
     * @param string $property
     * @param string $message
     */
    public function __construct(
        string $property,
        string $message
    ) {
        $this->property = $property;
        $this->message = $message;
    }

    /**
     * @var string|null
     */
    protected $property;

    /**
     * @var string|null
     */
    protected $message;

    /**
     * @return string|null
     */
    public function getProperty(): ?string
    {
        return $this->property;
    }

    /**
     * @param string|null $property
     *
     * @return $this
     */
    public function setProperty(?string $property): Violation
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     *
     * @return $this
     */
    public function setMessage(?string $message): Violation
    {
        $this->message = $message;

        return $this;
    }
}
