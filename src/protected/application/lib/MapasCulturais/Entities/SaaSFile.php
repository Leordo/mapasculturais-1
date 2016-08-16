<?php
namespace MapasCulturais\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\entity(repositoryClass="MapasCulturais\Repository")
 */
class SaaSFile extends File {

    /**
     * @var \MapasCulturais\Entities\SaaS
     *
     * @ORM\ManyToOne(targetEntity="MapasCulturais\Entities\SaaS")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var \MapasCulturais\Entities\SaaSFile
     *
     * @ORM\ManyToOne(targetEntity="MapasCulturais\Entities\SaaSFile", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    protected $parent;
}
