<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Request;

use Spiral\Filters\Filter;

class PlayRequest extends Filter
{
    public const SCHEMA = [
        'id'    => 'query:id',
        'audio' => 'query:audio',
    ];

    /**
     * @return string
     */
    public function getID(): string
    {
        return (string)$this->getField('id');
    }

    /**
     * @return string|null
     */
    public function getAudio(): ?string
    {
        return $this->getField('audio');
    }
}