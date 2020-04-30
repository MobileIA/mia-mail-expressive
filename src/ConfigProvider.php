<?php

declare(strict_types=1);

namespace Mobileia\Expressive\Mail;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
                
            ],
            'factories'  => [
                \Mobileia\Expressive\Mail\Service\Sendgrid::class => \Mobileia\Expressive\Mail\Factory\SendgridFactory::class,
                \Mobileia\Expressive\Mail\Handler\SendgridHandler::class => \Mobileia\Expressive\Mail\Factory\SendgridHandlerFactory::class,
                \Mobileia\Expressive\Mail\Service\SendinBlue::class => \Mobileia\Expressive\Mail\Factory\SendinBlueFactory::class,
                \Mobileia\Expressive\Mail\Handler\SendinBlueHandler::class => \Mobileia\Expressive\Mail\Factory\SendinBlueHandlerFactory::class,
            ],
        ];
    }
}
