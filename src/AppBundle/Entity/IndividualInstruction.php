<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Instruction;

/**
 * IndividualInstruction
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IndividualInstruction extends Instruction
{

    /**
     * @var string
     *
     * @ORM\Column(name="client", type="string", length=75)
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="interaction", type="string", length=255)
     */
    private $interaction;

    /**
     * Set client
     *
     * @param string $client
     *
     * @return IndividualInstruction
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set interaction
     *
     * @param string $interaction
     *
     * @return IndividualInstruction
     */
    public function setInteraction($interaction)
    {
        $this->interaction = $interaction;

        return $this;
    }

    /**
     * Get interaction
     *
     * @return string
     */
    public function getInteraction()
    {
        return $this->interaction;
    }
}

