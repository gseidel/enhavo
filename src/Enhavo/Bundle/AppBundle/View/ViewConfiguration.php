<?php
/**
 * Created by PhpStorm.
 * User: gseidel
 * Date: 03.01.19
 * Time: 13:58
 */

namespace Enhavo\Bundle\AppBundle\View;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class ViewConfiguration
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ParameterBag
     */
    private $parameters;

    /**
     * ViewConfiguration constructor.
     *
     * @param Request $request
     * @param ParameterBag $parameters
     */
    public function __construct(Request $request, ParameterBag $parameters)
    {
        $this->request = $request;
        $this->parameters = $parameters;
    }

    public function getType()
    {
        return $this->parameters->get('type');
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getParameters(): ParameterBag
    {
        return $this->parameters;
    }

    public function get(string $path, array $defaults = [])
    {
        $value = $this->getParameterValue($path, $this->getParameters()->all());
        $defaults[] = $value;
        $value = $this->mergeConfig($defaults);
        return $value;
    }

    public function getArray(string $path, array $defaults = [])
    {
        $value = $this->getParameterValue($path, $this->getParameters()->all());
        $defaults[] = $value;
        $value = $this->mergeParameterArray($defaults);
        return $value;
    }

    private function getParameterValue($path, array $config)
    {
        $keyArray = preg_split('/\./', $path);
        $value = $this->getByKeyArray($config, $keyArray);
        return $value;
    }

    private function getByKeyArray(array $config, array $keyArray)
    {
        if(empty($keyArray)) {
            return null;
        }

        if(is_array($keyArray)) {
            $key = array_shift($keyArray);
            if(isset($config[$key])) {
                if(count($keyArray) == 0) {
                    return $config[$key];
                } else {
                    return $this->getByKeyArray($config[$key], $keyArray);
                }
            }
        }

        return null;
    }

    private function mergeConfig($configs)
    {
        $data = null;
        foreach($configs as $config) {
            if($config != null) {
                $data = $config;
            }
        }
        return $data;
    }

    private function mergeParameterArray($configs)
    {
        $data = [];
        foreach($configs as $config) {
            if(is_array($config)) {
                $data = $this->mergeArray($data, $config);
            }

        }
        return $data;
    }

    private function mergeArray(array $default, array $config)
    {
        $mergedArray = array();

        foreach($config as $key => $value) {
            $mergedArray[$key] = $value;
        }

        foreach($default as $key => $value) {
            if(array_key_exists($key, $config)) {
                if(is_array($config[$key]) && is_array($value)) {
                    $mergedArray[$key] = $this->mergeArray($value, $config[$key]);
                } else {
                    $mergedArray[$key] = $config[$key];
                }
            } else {
                $mergedArray[$key] = $value;
            }
        }

        return $mergedArray;
    }
}