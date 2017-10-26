<?php

namespace FreddieGar\DeclarationApi\Examples;

use FreddieGar\DeclarationApi\Contracts\ActionInterface;
use FreddieGar\DeclarationApi\Models\Service;

/**
 * Class InformationRequest
 * @package app\Examples
 */
class GetPdfRequest extends Service
{
    /**
     * @return string
     */
    public function action()
    {
        return ActionInterface::ACTION_GET_PDF_REQUEST;
    }

    /**
     * @return array
     */
    public function data()
    {
        $file = __DIR__ . '/../../tmp/request.log';

        return [
            'payload' => [
                'locale' => 'es',
                'requestId' => (file_exists($file)) ? file_get_contents($file) : '',
            ]
        ];
    }
}