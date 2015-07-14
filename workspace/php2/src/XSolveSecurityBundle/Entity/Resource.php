<?php

namespace XSolveSecurityBundle\Entity;
use XSolveSecurityBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;




/**
 * Resource
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="XSolveSecurityBundle\Entity\ResourceRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"resource" = "Resource", "video" = "Video", "image" = "Image"})

 */
class Resource
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
    * @ORM\ManyToOne(targetEntity="User")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    * */
   protected $user;

   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \XSolveSecurityBundle\Entity\User $user
     * @return Resource
     */
    public function setUser(\XSolveSecurityBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \XSolveSecurityBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }



}
