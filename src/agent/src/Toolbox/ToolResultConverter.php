<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\Agent\Toolbox;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Christopher Hertel <mail@christopher-hertel.de>
 */
final readonly class ToolResultConverter
{
    public function __construct(
        private SerializerInterface $serializer = new Serializer([new JsonSerializableNormalizer(), new DateTimeNormalizer(), new ObjectNormalizer()], [new JsonEncoder()]),
    ) {
    }

    public function convert(mixed $result): ?string
    {
        if (null === $result || \is_string($result)) {
            return $result;
        }

        if ($result instanceof \Stringable) {
            return (string) $result;
        }

        return $this->serializer->serialize($result, 'json');
    }
}
