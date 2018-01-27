<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 1/26/18
 * Time: 8:55 PM
 */
namespace AppBundle\Listener;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
class DoctrineExtensionListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function onConsoleCommand()
    {
        $this->container->get('gedmo.listener.translatable')
            ->setTranslatableLocale($this->container->get('translator')->getLocale());
    }
}