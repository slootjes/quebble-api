<?php

namespace App\VO;

class Colleague
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTimeImmutable
     */
    private $start;

    /**
     * @var \DateTimeImmutable
     */
    private $end;

    /**
     * @param string $name
     * @param \DateTimeImmutable $start
     * @param \DateTimeImmutable $end
     */
    public function __construct(string $name, \DateTimeImmutable $start, \DateTimeImmutable $end)
    {
        $this->name = $name;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'start' => $this->start->format(DATE_ISO8601),
            'end' => $this->end->format(DATE_ISO8601),
        ];
    }
}
