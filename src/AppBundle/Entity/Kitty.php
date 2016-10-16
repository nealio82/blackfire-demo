<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KittyRepository")
 * @ORM\Table(indexes={@ORM\Index(name="birthday_idx", columns={"birthday"})})
 */
class Kitty
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
     * @Gedmo\Slug(fields={"id", "name"}, updatable=false, separator="-")
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min = "10", minMessage = "kitty.missing_bio")
     */
    private $bio;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $birthday;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Comment",
     *      mappedBy="kitty",
     *      orphanRemoval=true
     * )
     * @ORM\OrderBy({"publishedAt" = "DESC"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="Breed",
     *      inversedBy="kitties",
     * )
     */
    private $breed;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="User",
     *      inversedBy="kitties",
     * )
     */
    private $owner;

    public function __construct()
    {
        $this->publishedAt = new \DateTime();
        $this->comments = new ArrayCollection();
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
     * @param mixed $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
        $comment->setPost($this);
    }

    /**
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
        $comment->setPost(null);
    }

    /**
     * @param mixed $breed
     */
    public function setBreed($breed)
    {
        $this->breed = $breed;
    }

    /**
     * @return mixed
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

}