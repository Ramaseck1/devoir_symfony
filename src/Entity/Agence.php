<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity()]
class Agence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)] // Rend le champ unique au niveau de la base
    #[Assert\NotBlank(message: 'Le numéro de l\'agence est obligatoire.')]
    private ?string $numero = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: 'L\'adresse de l\'agence est obligatoire.')]
    private ?string $adresse = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: 'Le téléphone de l\'agence est obligatoire.')]
    #[Assert\Regex(
        pattern: '/^77|78|76|70\d{7}$/',
        message: 'Le numéro de téléphone doit être valide et commencer par 77, 78, 76 ou 70.'
    )]
    private ?string $telephone = null;

    // Getters et setters...
}
