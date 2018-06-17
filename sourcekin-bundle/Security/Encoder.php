<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace SourcekinBundle\Security;

use Sourcekin\Components\PasswordEncoder;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class Encoder implements PasswordEncoder
{
    /**
     * @var PasswordEncoderInterface
     */
    protected $encoder;

    /**
     * Encoder constructor.
     *
     * @param PasswordEncoderInterface $encoder
     */
    public function __construct(PasswordEncoderInterface $encoder) { $this->encoder = $encoder; }

    public function encode($plainPassword)
    {
        return $this->encoder->encodePassword($plainPassword, null);
    }


}