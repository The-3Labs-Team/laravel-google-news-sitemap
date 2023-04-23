<?php

namespace The3LabsTeam\GoogleNewsFeed\Helpers;

class Cdata
{
    public static function out(string $data): string
    {
        // See https://www.w3.org/TR/REC-xml/#dt-cdsection
        $replace = [
            '<!CDATA[' => '', // CDATA cannot be nested.
            ']]>' => ']]&gt;', // CDEnd needs to be escaped.
        ];

        // Trim the data to avoid leading/trailing whitespace.
        $data = trim($data);

        return str_replace(array_keys($replace), array_values($replace), $data);
    }
}
