<?php

class AccessAnalyzer
{

    public $filePath;
    public $viewLines;
    public $allUrls;
    public $uniqueUrls;
    public $allStatuses;
    public $statusesCount;
    public $trafficCount;
    public $crawlers;

    public function __construct($filePath)
    {
        $this->viewLines = file($filePath);
        $this->allUrls = $this->allUrls();
    }

    private function splitData($viewLine)
    {
        return explode(" ", $viewLine);
    }

    public function viewsCount()
    {
        return count($this->viewLines);
    }

    public function allUrls()
    {
        $allUrls = [];
        foreach ($this->viewLines as $viewLine) {
            $splitViewLine = $this->splitData($viewLine);
            array_push($allUrls, $splitViewLine[6]);
        }
        return $allUrls;
    }

    public function urlsCount()
    {
        $this->urlsCount = count($this->uniqueUrls());
        return $this->urlsCount;
    }

    public function uniqueUrls()
    {
        $this->uniqueUrls = array_unique($this->allUrls);
        return $this->uniqueUrls;
    }

    public function statusesCount()
    {
        $statuses = $this->statuses();
        $uniqueStatuses = array_unique($statuses);
        $result = [];

        foreach ($uniqueStatuses as $uniqueStatus) {
            $count = 0;
            foreach ($statuses as $status) {
                if ($status == $uniqueStatus) {
                    $count++;
                }
            }
            if ($count > 0) {
                $result[$uniqueStatus] = $count;
            }
        }
        return $result;
    }

    public function statuses()
    {
        $statuses = [];
        foreach ($this->viewLines as $viewLine) {
            $splitViewLine = $this->splitData($viewLine);
            array_push($statuses, $splitViewLine[8]);
        }
        $this->allStatuses = $statuses;
        return $statuses;
    }

    public function trafficCount()
    {
        $traffic = 0;
        foreach ($this->viewLines as $viewLine) {
            $splitViewLine = $this->splitData($viewLine);
            $traffic += $splitViewLine[9];
        }
        $this->trafficCount = $traffic;
        return $traffic;
    }

    public function crawlersCount()
    {
        $crawlers = [];
        $bots = ["Googlebot" => "Google", "Bingbot" => "Bing", "Baiduspider" => "Baidu", "YandexBot" => "Yandex"];
        foreach ($bots as $bot) {
            $tempBotCount = 0;
            foreach ($this->viewLines as $viewLine) {

                if (strpos($viewLine, $bot) !== false) {
                    $tempBotCount++;
                }
            }
            $crawlers[$bot] = $tempBotCount;
        }
        $this->crawlers = $crawlers;
        return $crawlers;
    }
}
