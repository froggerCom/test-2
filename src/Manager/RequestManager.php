<?php


namespace App\Manager;

use App\Modifier\ModifierInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestManager
 * @package App\Manager
 */
class RequestManager
{
    /**
     * @param $request
     * @param object $object $object
     * @param ModifierInterface|null $modifier
     *
     * @throws ReflectionException
     */
    public function parsePostDataIntoEntity(
        $request,
        object $object,
        ModifierInterface $modifier = null
    ): void
    {
        if ($request instanceof Request) {
            $request = $request->request->all();
        }

        $reflection = new ReflectionClass(get_class($object));

        foreach ($request as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if ($reflection->hasMethod($setter)) {
                if (!is_array($value) && !is_object($value)) {
                    $value = trim($value);
                }

                if ($modifier instanceof ModifierInterface) {
                    $value = $modifier->modify($key, $value, $object);
                }

                $object->{$setter}($value);
            }
        }
    }
}