<?php

declare(strict_types=1);

namespace App\Security;

use App\Model\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    private UserPasswordEncoderInterface $encoder;

    private UserRepository $rep;

    public function __construct(UserPasswordEncoderInterface $encoder, UserRepository $rep)
    {
        $this->encoder = $encoder;
        $this->rep = $rep;
    }

    public function loadUserByUsername(string $username)
    {
        if (!$user = $this->rep->findUserByEmail($username)) {
            throw new UsernameNotFoundException;
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        return $user; // @todo add checks
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class)
    {
        return User::class === $class;
    }
}
