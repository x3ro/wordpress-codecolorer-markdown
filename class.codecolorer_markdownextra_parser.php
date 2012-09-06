<?php

/**
 * The purpose of this class is to overwrite the code blocks generation method of
 * MarkdownExtra_Parser to inject the CodeColorer functionality.
 *
 * @author Lucas Jenss <public@x3ro.de>
 */
class CodeColorer_MarkdownExtra_Parser extends MarkdownExtra_Parser  {

    function _doCodeBlocks_callback($matches) {
        // If codecolorer is not installed, call the default callback
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if(!is_plugin_active('codecolorer/codecolorer.php')) {
            return parent::_doCodeBlocks_callback($matches);
        }

        $codeblock = $matches[1];
        $codeblock = $this->outdent($codeblock);

        # trim leading newlines and trailing newlines
        $codeblock = preg_replace('/\A\n+|\n+\z/', '', $codeblock);

        // Extract the first line from the code-block if it is enclosed in colons
        $matched = preg_match('/^[ \t]*:([a-z0-9]*):(.*)/ims', $codeblock, $out);
        $language = $out[1];
        $code = $out[2];

        if($matched) {
            $codeblock = "[cc_$language]".$code."[/cc_$language]";
        } else {
            $codeblock = "[cc]{$codeblock}[/cc]";
        }

        $codeblock = CodeColorerLoader::Highlight($codeblock);

        return "\n\n".$this->hashBlock($codeblock)."\n\n";
    }
}
