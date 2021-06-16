<?php

namespace App\VO;

class Workday
{
    /**
     * @var \DateTimeInterface
     */
    private $start;

    /**
     * @var \DateTimeInterface
     */
    private $end;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $group;

    /**
     * @var \DateTimeInterface|null
     */
    private $breakStart;

    /**
     * @var \DateTimeInterface|null
     */
    private $breakEnd;

    /**
     * @var Colleague[]
     */
    private $colleagues = [];

    /**
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @param string $location
     * @param string $group
     * @param \DateTimeInterface|null $breakStart
     * @param \DateTimeInterface|null $breakEnd
     * @param array $colleagues
     */
    public function __construct(
        \DateTimeInterface $start,
        \DateTimeInterface $end,
        string $location,
        string $group,
        ?\DateTimeInterface $breakStart = null,
        ?\DateTimeInterface $breakEnd = null,
        array $colleagues = []
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->location = $location;
        $this->group = $group;
        $this->breakStart = $breakStart;
        $this->breakEnd = $breakEnd;
        $this->colleagues = $colleagues;
    }

    /**
     * @param string $text
     * @return WorkDay
     */
    public static function fromString(string $text): WorkDay
    {
        $text = str_replace('[Gewerkte uren] op ', '', $text);
        preg_match(
            '/([0-9]{2}-[0-9]{2}-[0-9]{4})\s+(.*),\s+(.*)\s+van\s+([0-9]{2}:[0-9]{2})\s+tot\s+([0-9]{2}:[0-9]{2})(\s+\(pauzes:\s([0-9]{2}:[0-9]{2})\s+tot\s+([0-9]{2}:[0-9]{2})\))?/',
            $text,
            $matches
        );

        $breakStart = null;
        $breakEnd = null;
        if (!empty($matches[7]) && !empty($matches[8])) {
            $breakStart = \DateTimeImmutable::createFromFormat(
                'd-m-Y H:i:s',
                sprintf('%s %s:00', $matches[1], $matches[7])
            );
            $breakEnd = \DateTimeImmutable::createFromFormat(
                'd-m-Y H:i:s',
                sprintf('%s %s:00', $matches[1], $matches[8])
            );
        }

        return new WorkDay(
            \DateTimeImmutable::createFromFormat('d-m-Y H:i:s', sprintf('%s %s:00', $matches[1], $matches[4])),
            \DateTimeImmutable::createFromFormat('d-m-Y H:i:s', sprintf('%s %s:00', $matches[1], $matches[5])),
            $matches[2],
            $matches[3],
            $breakStart,
            $breakEnd
        );
    }

    /**
     * @param Colleague $colleague
     */
    public function addColleague(Colleague $colleague)
    {
        $this->colleagues[] = $colleague;
    }

    /**
     * @param string $text
     */
    public function addColleagueFromString(string $text)
    {
        preg_match(
            '/(.*)\s+van\s+([0-9]{2}:[0-9]{2})\s+tot\s+([0-9]{2}:[0-9]{2})/',
            $text,
            $matches
        );

        $this->addColleague(
            new Colleague(
                $matches[1],
                \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i:s',
                    sprintf('%s %s:00', $this->start->format('Y-m-d'), $matches[2])
                ),
                \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i:s',
                    sprintf('%s %s:00', $this->start->format('Y-m-d'), $matches[3])
                )
            )
        );
    }

    public function __toString(): string
    {
        return sprintf(
            '%s - %s, %s: %s - %s',
            $this->start->format('Y-m-d'),
            $this->location,
            $this->group,
            $this->start->format('H:i'),
            $this->end->format('H:i')
        );
    }

    public function toArray(): array
    {
        $break = null;
        if (!empty($this->breakStart)) {
            $break = [
                'start' => $this->breakStart->format(DATE_ISO8601),
                'end' => $this->breakEnd->format(DATE_ISO8601),
            ];
        }
        $colleagues = [];
        foreach ($this->colleagues as $colleague) {
            $colleagues[] = $colleague->toArray();
        }

        return [
            'text' => (string)$this,
            'start' => $this->start->format(DATE_ISO8601),
            'end' => $this->end->format(DATE_ISO8601),
            'location' => $this->location,
            'group' => $this->group,
            'break' => $break,
            'colleagues' => $colleagues
        ];
    }
}
