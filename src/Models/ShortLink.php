<?php declare(strict_types=1);

namespace App\Models;

use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="short_links",indexes={@Index(name="hash_idx", columns={"hash"})})
 */
class ShortLink {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /** @ORM\Column(type="string") */
    public $hash;

    /** @ORM\Column(type="string") */
    public $url;

    /** @ORM\Column(type="integer", options={"default" : 0}) */
    public $clicks = 0;
}
