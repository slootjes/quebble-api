<?php

namespace App\VO;

class Colleague
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $start;

    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $end;

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return explode(' ', $this->name)[0];
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
