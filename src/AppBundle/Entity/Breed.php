<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BreedRepository")
 */
class Breed
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min = "10", minMessage = "breed.missing_characteristics")
     */
    private $characteristics;

    /**
     * @ORM\OneToMany(targetEntity="Kitty", mappedBy="breed")
     */
    private $kitties;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false, separator="-")
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    protected $count;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $characteristics
     */
    public function setCharacteristics($characteristics)
    {
        $this->characteristics = $characteristics;
    }

    /**
     * @return mixed
     */
    public function getCharacteristics()
    {
        return $this->characteristics;
    }

    /**
     * @return ArrayCollection
     */
    public function getKitties()
    {
        return $this->kitties;
    }

    /**
     * @param Kitty $kitty
     */
    public function addKitty(Kitty $kitty)
    {
        $this->kitties->add($kitty);
        $kitty->setBreed($this);
    }

    /**
     * @param Kitty $kitty
     */
    public function removeComment(Kitty $kitty)
    {
        $this->kitties->removeElement($kitty);
        $kitty->setBreed(null);
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

}