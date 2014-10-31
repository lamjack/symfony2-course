<?php

namespace Acme\WechatSDKBundle\SDK;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Wechat
 * @package Acme\WechatSDKBundle\SDK
 */
final class Wechat implements ContainerAwareInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $appid;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var ContainerInterface|null
     */
    private $container;

    /**
     * @param $token
     * @param $appid
     * @param $secret
     * @param bool $debug
     */
    function __construct($token, $appid, $secret, $debug = false)
    {
        $this->token = $token;
        $this->appid = $appid;
        $this->secret = $secret;
        $this->debug = $debug;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}