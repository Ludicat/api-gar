<?php
/**
 * @licence Proprietary
 */
namespace Ludicat\ApiGar\Tool;

/**
 * Class ArrayConverter
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class ArrayConverter
{
    /** @var string[]|array */
    protected static $classAliasMap = [
        \DateTimeInterface::class => \DateTime::class,
    ];

    /**
     * Data can be incomplete, object will use mutator to assign values.
     * Array keys must be SNAKE_CASE, mutator setCamelCase()
     *
     * @param string $class
     * @param array $data
     *
     * @return mixed an instance of $class with mapped values
     * @throws \ReflectionException
     */
    public static function fromArray(string $class, array $data)
    {
        $entity = new $class();

        foreach ($data as $column => $value) {
            // Convert column name to mutator name
            $method = sprintf('set%s', NameConverter::snakeCaseToCamelCase($column, true));
            // Skip unused methods
            if (method_exists($entity, $method)) {
                // Maybe have to convert value
                // We use method reflexion to introspect class type.
                // You should always strong type the setter with class type to use this method.
                if ($value !== null) {
                    $reflectionParameter = new \ReflectionParameter([$class, $method], 0);
                    // Have to split in two tests as instanceOf doesn't work with function calls
                    if ($reflectionParameter->getClass()) {
                        $className = $reflectionParameter->getClass()->getName();
                        if (!$value instanceof $className) {
                            $className = $reflectionParameter->getClass()->getName();
                            $className = static::getClassAlias($className);
                            $value = new $className($value);
                        }
                    }
                }

                $entity->{$method}($value);
            }
        }

        return $entity;
    }

    /**
     * @param $instance
     * @param bool $keyUppercase
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function toArray($instance)
    {
        $data = [];
        $reflection = new \ReflectionClass($instance);
        foreach ($reflection->getProperties() as $property) {
            if (
                $property->isPublic()
                || $property->isStatic()
            ) {
                continue;
            }

            $methodName = 'get' . ucfirst($property->getName());
            // If Method don't exist, remove _ and retry
            if (!$reflection->hasMethod($methodName)) {
                $methodName = str_replace('_', '', $methodName);
            }

            // Can't guess name !
            if (!$reflection->hasMethod($methodName)) {
                continue;
            }

            // Use getter to fetch data
            $data[$property->getName()] = $instance->{$methodName}();
            
            if (is_object($data[$property->getName()])) {
                $data[$property->getName()] = static::toArray($data[$property->getName()]);
            }
            
            if (is_array($data[$property->getName()])) {
                foreach ($data[$property->getName()] as $key => $value) {
                    if (is_object($data[$property->getName()][$key])) {
                        $data[$property->getName()][$key] = static::toArray($value);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param string $class
     *
     * @return string
     */
    protected static function getClassAlias($class)
    {
        if (isset(static::$classAliasMap[$class])) {
            return static::$classAliasMap[$class];
        }

        return $class;
    }
}
