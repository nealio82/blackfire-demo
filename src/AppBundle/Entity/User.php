<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Comment",
     *      mappedBy="author",
     *      orphanRemoval=true
     * )
     * @ORM\OrderBy({"publishedAt" = "DESC"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Kitty",
     *      mappedBy="owner",
     *      orphanRemoval=true
     * )
     */
    private $kitties;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return mixed
     */
    public function getKitties()
    {
        return $this->kitties;
    }

}