<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class                   => ['all' => true],
    Symfony\Bundle\WebServerBundle\WebServerBundle::class                   => ['dev' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class                           => ['dev' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class    => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class                             => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class               => ['dev' => true, 'test' => true],
];
