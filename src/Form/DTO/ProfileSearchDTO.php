<?php

declare(strict_types=1);

namespace App\Form\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class ProfileSearchDTO
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $firstName = null;

    /**
     * @Assert\NotBlank()
     */
    public ?string $lastName = null;
}
