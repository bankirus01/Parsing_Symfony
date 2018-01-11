<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 1/11/18
 * Time: 11:39 PM
 */
namespace AppBundle\Command;

use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\InterfaceSymfony;
use AppBundle\Entity\NamespaceSymfony;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class ParseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:parse')
            ->setDescription('Creates a new parse API.symfony.com.')
            ->setHelp('This command allows you to create a user...');
    }

    /**
     * @param InputInterface $input
     *
     * @param OutputInterface $output
     *
     */

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getNamespaceRecursion('http://api.symfony.com/3.4/Symfony.html');
    }

    public function getNamespaceRecursion(string $url, $parent = null): int
    {
        $html = file_get_contents($url);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $crawler = new Crawler($html);
        $forNamespace = $crawler->filter('div.namespace-list > a');
        $forClass = $crawler->filter('div.row > div.col-md-6 > a');
        $forInterface = $crawler->filter('div.col-md-6 > em > a');

        foreach ($forNamespace as $item) {
            $urlSymf = 'http://api.symfony.com/3.4/' . str_replace('../', '', $item->getAttribute("href"));
            $urlName = $item->textContent;
            $namespace = new NamespaceSymfony();
            $namespace->setUrl($urlSymf);
            $namespace->setName($urlName);
            $namespace->setParent($parent);
            $em->persist($namespace);
            $this->getNamespaceRecursion($urlSymf, $namespace);
        }
        if ($forClass->count() > 0) {
            foreach ($forClass as $item) {
                $classUrl = 'http://api.symfony.com/3.4/' . str_replace("../", "", $item->getAttribute('href'));
                $className = $item->textContent;
                $class = new ClassSymfony();
                $class->setUrl($classUrl);
                $class->setName($className);
                $em->persist($class);
            }
        }
        if ($forInterface->count() > 0) {
            foreach ($forInterface as $item) {
                $interUrl = 'http://api.symfony.com/3.4/' . str_replace("../", "", $item->getAttribute('href'));
                $interName = $item->textContent;
                $interface = new InterfaceSymfony();
                $interface->setUrl($interUrl);
                $interface->setName($interName);
                $em->persist($interface);
            }
        }
        $em->flush();
    }
}
