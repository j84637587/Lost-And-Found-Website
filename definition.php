<?php
@session_start();
$_SITENAME = "失物招領";

class Utility
{
    /**
     * Undocumented function
     *
     * @param string $url
     * @param Array $params
     */
    public static function RedirectPost(string $url, array $params)
    {
        $html = "";
        $html .= '<!doctype html>
                <html>
                <head>
                </head>
                <body>
                <form id="redirect_form" method="post" action="' . $url . '" >
                ';

        foreach ($params as $k => $v) {
            $html .= "<input name='$k' id='$k' value='$v' />";
        }

        $html .= '</form></body></html>
                <script type="text/javascript">
                    function submitForm() {
                        document.getElementById("redirect_form").submit();
                    }
                    window.onload = submitForm;
                </script>';

        echo $html;
        die();
    }

    /**
     * 重新導向到網址
     *
     * @param string $url
     * @param integer $statusCode
     */
    public static function RedirectGet(string $url, int $statusCode = 303)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }

    /**
     * This small helper function generates RFC 4122 compliant Version 4 UUIDs.
     *
     * @param [type] $data
     * @return void
     */
    public static function guidv4($data = null) {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
    
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}

class Asset
{
    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public static function Image(string $path)
    {
        return ($_SERVER['DOCUMENT_ROOT'] . "/assets/img/$path");
    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @return string
     */
    public static function File(string $path)
    {
        return ($_SERVER['DOCUMENT_ROOT'] . $path);
    }
}

class Path
{
    /**
     * Undocumented function
     *
     * @param string $var
     */
    public static function Include(string $var)
    {
        global $_DEF;
        if ($var != "")
            include($_SERVER['DOCUMENT_ROOT'] . $var);
    }

    /**
     * Undocumented function
     *
     * @param string $var
     */
    public static function IncludeOnce(string $var)
    {
        global $_DEF;
        if ($var != "")
            include_once($_SERVER['DOCUMENT_ROOT'] . $var);
    }

    /**
     * Undocumented function
     *
     * @param string $var
     */
    public static function Require(string $var)
    {
        global $_DEF;
        if ($var != "")
            require($_SERVER['DOCUMENT_ROOT'] . $var);
    }

    /**
     * Undocumented function
     *
     * @param string $var
     */
    public static function RequireOnce(string $var)
    {
        global $_DEF;
        if ($var != "")
            require_once($_SERVER['DOCUMENT_ROOT'] . $var);
    }

    /**
     * Undocumented function
     *
     * @param [type] $file
     * @param string $Protocol
     * @return string
     */
    public static function Path2Url($file, $Protocol = 'http://')
    {
        return $Protocol . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
    }
}
