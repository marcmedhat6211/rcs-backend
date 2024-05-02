<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServiceRepository;
use JMS\Serializer\Annotation as JMS;

#[ORM\Table(name: "service")]
#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[JMS\ExclusionPolicy("all")]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[JMS\Expose]
    #[JMS\Groups(["services_list"])]
    private int $id;

    #[ORM\Column(name: "name", type: Types::STRING, length: 180)]
    #[JMS\Expose]
    #[JMS\Groups(["services_list"])]
    private string $name = "";

    #[ORM\Column(name: "description", type: Types::TEXT)]
    #[JMS\Expose]
    #[JMS\Groups(["services_list"])]
    private string $description = "";

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
