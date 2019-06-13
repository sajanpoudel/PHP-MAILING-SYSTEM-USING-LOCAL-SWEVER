<?php
require_once __DIR__ . '/../sajanmailer/HtmlBody.php';

check('allowed tags stay', cleanHtmlBody('<b>Hi</b> <i>there</i>') === '<b>Hi</b> <i>there</i>');
check('scripts are removed with their content', cleanHtmlBody('A<script>alert(1)</script>B') === 'AB');
check('other tags are stripped', cleanHtmlBody('<iframe src="x"></iframe>Text') === 'Text');
check('event handlers are removed', strpos(cleanHtmlBody('<a href="http://x.io" onclick="steal()">x</a>'), 'onclick') === false);
check('javascript links are neutralised', strpos(cleanHtmlBody('<a href="javascript:alert(1)">x</a>'), 'javascript') === false);
check('plain text keeps line breaks', plainTextBody('One<br>Two<p>Three</p>') === "One\nTwo\nThree");
check('entities are decoded in plain text', plainTextBody('Fish &amp; chips') === 'Fish & chips');
