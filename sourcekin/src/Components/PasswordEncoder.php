<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace Sourcekin\Components;

interface PasswordEncoder
{
    public function encode($plainPassword);
}