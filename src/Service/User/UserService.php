<?php

namespace App\Service\User;

use App\Repository\User\UserRepositoryInterface;

class UserService implements UserServiceInterface
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * getAllUsers
     *
     * @return array
     */
    public function getAllUsers(): array
    {
        return $this->userRepository->getAll();
    }
}
