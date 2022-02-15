<?php namespace Controller;

function getEndpoints($url, $fileBaseName)
{
    $baseNamePos = strpos($url, $fileBaseName);
    $baseNameLen = strlen($fileBaseName);
    $endPos = strrpos($url, '?');
    if (!$endPos) $endPos = strlen($url);
    $endOfUrl = substr($url, $baseNamePos + $baseNameLen + 1, $endPos - $baseNamePos - $baseNameLen - 1);

    for ($i = 0; $i < 10; $i++)
    {
        $slashPos = strpos($endOfUrl, '/');
        if (!$slashPos)
        {
            $endpoints[$i] = substr($endOfUrl, 0, strlen($endOfUrl));
            break;
        }
        else
        {
            $endpoints[$i] = substr($endOfUrl, 0, $slashPos);
            $endOfUrl = substr($endOfUrl, $slashPos + 1);
        }
    }

    return $endpoints;
}