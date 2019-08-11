<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class CommonController
 * @package App\Controller
 */
class CommonController
{
    /**
     * @param Request $request
     * @return Request
     */
    protected function parseJson(Request $request): Request
    {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }

        return $request;
    }
}