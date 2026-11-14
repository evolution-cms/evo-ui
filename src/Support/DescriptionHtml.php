<?php

namespace EvoUI\Support;

/**
 * Render administrator-authored field descriptions with basic formatting and safe links.
 *
 * @since 1.3.0
 */
final class DescriptionHtml
{
    /**
     * Rebuild an HTML fragment without executable elements or event attributes.
     *
     * @since 1.3.0
     * @param string $html A translated field description.
     * @return string Safe HTML for a field hint.
     */
    public static function render(string $html): string
    {
        if ($html === '') {
            return '';
        }
        $document = new \DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        try {
            $document->loadHTML('<?xml encoding="UTF-8"><html><body>' . $html . '</body></html>', LIBXML_NONET);
            $body = $document->getElementsByTagName('body')->item(0);
            return $body ? self::children($body) : htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
    }

    /**
     * Serialize approved inline elements and discard unsafe attributes and embedded content.
     *
     * @since 1.3.0
     * @param \DOMNode $parent Parsed fragment node.
     * @return string Sanitized child markup.
     */
    private static function children(\DOMNode $parent): string
    {
        $result = '';
        foreach ($parent->childNodes as $node) {
            if ($node instanceof \DOMText) {
                $result .= htmlspecialchars($node->data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                continue;
            }
            if (!$node instanceof \DOMElement) {
                continue;
            }
            $tag = strtolower($node->tagName);
            if (in_array($tag, ['script', 'style', 'iframe', 'object', 'svg', 'math'], true)) {
                continue;
            }
            $content = self::children($node);
            if ($tag === 'br') {
                $result .= '<br>';
            } elseif (in_array($tag, ['strong', 'b', 'em', 'i', 'code', 'small'], true)) {
                $result .= '<' . $tag . '>' . $content . '</' . $tag . '>';
            } elseif ($tag === 'a') {
                $href = trim($node->getAttribute('href'));
                $scheme = parse_url($href, PHP_URL_SCHEME);
                $safe = $href !== '' && !preg_match('/[\x00-\x20\\\\]/', $href)
                    && ($scheme === null || in_array(strtolower((string) $scheme), ['https', 'http', 'mailto', 'tel'], true));
                $result .= $safe
                    ? '<a href="' . htmlspecialchars($href, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '">' . $content . '</a>'
                    : $content;
            } else {
                $result .= $content;
            }
        }
        return $result;
    }
}
