<?php
namespace evolun\kid\helpers;

class StringHelper extends \yii\helpers\StringHelper
{
    /**
    * Replace links to html <a> tags in the given $text
    *
    * @see https://www.experts-exchange.com/questions/21878567/preg-replace-URL's.html
    * @param  string $text
    * @return string
    */
    public static function urlToLink(string $text) : string
    {
        // html ,or http/s link
        $text = preg_replace_callback('/(?(?=<a[^>]*>.+<\/a>)(?:<a[^>]*>.+<\/a>)|([^="\']?)((?:https?|ftp|bf2|):\/\/[^<> \n\r]+))/ix', function($matches) {
            if (!filter_var(@$matches[2], FILTER_VALIDATE_URL)) {
                return @$matches[0];
            }

            return stripslashes((strlen(@$matches[2]) > 0 ? @$matches[1] . '<a href="' . @$matches[2] . '" target="_blank" rel="nofollow">' . @$matches[2] . '</a>' : @$matches[0]));
        }, $text);

        // www link
        $text = preg_replace_callback('/(^|\s)(www.[^<> \n\r]+)/', function($matches) {
            if (!filter_var('http://' . @$matches[2], FILTER_VALIDATE_URL)) {
                return @$matches[0];
            }

            return stripslashes((strlen(@$matches[2]) > 0 ? @$matches[1] . '<a rel="nofollow" target="_blank" href="http://' . @$matches[2] . '">' . @$matches[2] . '</a>' . @$matches[3] : @$matches[0]));
        }, $text);

        // email address -> mailto
        $text = preg_replace_callback('/(([_A-Za-z0-9-]+)(\\.[_A-Za-z0-9-]+)*@([A-Za-z0-9-]+)(\\.[A-Za-z0-9-]+)*)/', function($matches) {
            return stripslashes((strlen(@$matches[2]) > 0 ? '<a href="mailto:' . @$matches[0] . '">' . @$matches[0] . '</a>' : @$matches[0]));
        }, $text);

        return $text;
    }
}