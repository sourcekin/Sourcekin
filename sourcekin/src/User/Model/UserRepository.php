<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Model;


interface UserRepository {
    public function save(User $user): void;
    public function get(string $id): ?User;
}