<?php

namespace XSolveSecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use XSolveSecurityBundle\Entity\Resource;

/**
 * Video
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="XSolveSecurityBundle\Entity\VideoRepository")
 */
class Video extends Resource {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   /**
     * @var string
     *
     * @ORM\Column(name="video_url", type="text")
     */
    protected $video_url;

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
     * Set video_url
     *
     * @param string $videoUrl
     * @return Video
     */
    public function setVideoUrl($videoUrl)
    {
        $this->video_url = $videoUrl;

        return $this;
    }

    /**
     * Get video_url
     *
     * @return string 
     */
    public function getVideoUrl()
    {
        return $this->video_url;
    }



}
