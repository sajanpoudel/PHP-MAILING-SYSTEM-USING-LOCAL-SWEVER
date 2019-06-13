<?php
// The message is sent as HTML, so only a few harmless tags are kept.

const ALLOWED_TAGS = '<b><strong><i><em><u><p><br><ul><ol><li><a>';

/** Removes scripts and event handlers, keeps the tags in ALLOWED_TAGS. */
function cleanHtmlBody($html)
{
	$html = preg_replace('#<(script|style)\b.*?</\1>#is', '', (string) $html);
	$html = strip_tags($html, ALLOWED_TAGS);
	$html = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
	$html = preg_replace('/href\s*=\s*(["\']?)\s*javascript:[^"\'>\s]*\1/i', 'href="#"', $html);
	return $html;
}

/** The same message as plain text for mail programs that do not show HTML. */
function plainTextBody($html)
{
	$text = preg_replace('#<br\s*/?>|</?p>|</li>#i', "\n", (string) $html);
	return trim(html_entity_decode(strip_tags($text), ENT_QUOTES, 'UTF-8'));
}
