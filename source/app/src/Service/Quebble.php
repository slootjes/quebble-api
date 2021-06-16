<?php

namespace App\Service;

use Goutte\Client;
use App\VO\Workday;

class Quebble
{
    const URL_BASE = 'https://weekplanning.quebble.com/';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->client = new Client();
        $this->login();
    }

    /**
     * Logs in the current user
     */
    private function login(): void
    {
        $crawler = $this->client->request('GET', self::URL_BASE.'Home/Login');
        $form = $crawler->selectButton('Login')->form();
        $this->client->submit(
            $form,
            ['EmailAddress' => $this->username, 'Password' => $this->password]
        );
    }

    /**
     * Get planning
     *
     * @return Workday[]
     */
    public function getPlanning(): array
    {
        $crawler = $this->client->request('GET', self::URL_BASE.'EmployeeSelfService/MyTasks');

        $workdays = $crawler->filterXPath('//*[@id="collapseOne"]/div/div[2]/div/div[*]/div/div[1]')->each(
            function ($node) {
                return Workday::fromString($node->text());
            }
        );

        $i = 0;
        $crawler->filterXPath('//*[@id="collapseOne"]/div/div[2]/div/div[*]/div/div[2]/div')->each(
            function ($node) use ($workdays, &$i) {
                $node->filterXPath('//div[contains(@class, "colleague-plannedHours")]')->each(
                    function ($child) use ($workdays, &$i) {
                        $workday = $workdays[$i];
                        $workday->addColleagueFromString($child->text());
                    }
                );
                $i++;
            }
        );

        return $workdays;
    }
}
