<?php

namespace Mobileia\Expressive\Mail\Factory;

use Psr\Container\ContainerInterface;

/**
 * Description of SendinBlueFactory
 *
 * @author matiascamiletti
 */
class SendinBlueFactory
{
    public function __invoke(ContainerInterface $container) : \Mobileia\Expressive\Mail\Service\SendinBlue
    {
        // Obtenemos configuracion
        $config = $container->get('config')['sendinblue'];
        // creamos libreria
        return new \Mobileia\Expressive\Mail\Service\SendinBlue($config);
    }
}
