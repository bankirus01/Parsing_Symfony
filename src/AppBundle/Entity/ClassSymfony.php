<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ClassSymfony
 *

 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="class_symfony")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 *
 */
class ClassSymfony implements PageItemInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="left_key", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="right_key", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="level", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="NamespaceSymfony", inversedBy="classes")
     * @ORM\JoinColumn(name="namespace_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    private $namespace;

    /**
     * Get id
     */
    public function getNamespace(): NamespaceSymfony
    {
        return $this->namespace;
    }
    /**
     * Set namespace
     *
     * @param mixed $namespace
     *
     * @return ClassSymfony
     *
     */
    public function setNamespace($namespace): ClassSymfony
    {
        $this->namespace = $namespace;
        return $this;
    }
    /**
     * Get id
     *
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->name;
    }
    /**
     * Set name
     *
     * @param string $name
     *
     * @return ClassSymfony
     */
    public function setName($name): CLassSymfony
    {
        $this->name = $name;
        return $this;
    }
    /**
     * Get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
    /**
     * Set url
     *
     * @param string $url
     *
     * @return ClassSymfony
     */
    public function setUrl($url): ClassSymfony
    {
        $this->url = $url;
        return $this;
    }
}