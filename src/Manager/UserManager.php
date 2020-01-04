<?php

declare(strict_types=1);

namespace App\Manager;

use App\Form\DTO\RegisterUserDTO;
use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserManager
{
    private UserRepository $user;

    private ProfileRepository $profile;

    private UserPasswordEncoderInterface $encoder;

    private Connection $conn;

    public function __construct(
        UserRepository $user,
        ProfileRepository $profile,
        UserPasswordEncoderInterface $encoder,
        Connection $conn
    )
    {
        $this->user = $user;
        $this->profile = $profile;
        $this->encoder = $encoder;
        $this->conn = $conn;
    }

    public function createFromDTO(RegisterUserDTO $dto)
    {
        $user = $this->user->findUserByLogin($dto->login);

        if (null !== $user) {
            throw new \Exception('User is already exists');
        }

        $this->conn->beginTransaction();

        $profile = $this->profile->createFromDto($dto);

        $user = $this->user->create([
            'login' => $this->conn->quote($dto->login),
            'profile_id' => $profile->getId(),
            'password' => '',
        ]);

        $this->user->update($user->getId(), [
            'password' => $this->encoder->encodePassword($user, $dto->password),
        ]);

        try {
            $this->conn->commit();
        } catch (\Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
}
