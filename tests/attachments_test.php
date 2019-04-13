<?php
require_once __DIR__ . '/../sajanmailer/Attachments.php';

function fakeFiles($entries)
{
	$files = array('name' => array(), 'error' => array(), 'size' => array());
	foreach ($entries as $entry) {
		$files['name'][] = $entry[0];
		$files['error'][] = isset($entry[2]) ? $entry[2] : UPLOAD_ERR_OK;
		$files['size'][] = $entry[1];
	}
	return $files;
}

check('extensions are lower cased', attachmentExtension('Report.PDF') === 'pdf');
check('a name without extension has none', attachmentExtension('README') === '');
check('executables are blocked', isBlockedAttachment('setup.EXE'));
check('documents are allowed', !isBlockedAttachment('notes.pdf'));
check('no file chosen gives no error', attachmentErrors(fakeFiles(array(array('', 0, UPLOAD_ERR_NO_FILE)))) === array());
check('a small file passes', attachmentErrors(fakeFiles(array(array('a.txt', 1000)))) === array());
check('a big file is reported', count(attachmentErrors(fakeFiles(array(array('big.zip', MAX_ATTACHMENT_BYTES + 1))))) === 1);
check('a blocked type is reported', count(attachmentErrors(fakeFiles(array(array('run.bat', 10))))) === 1);
check('a failed upload is reported', count(attachmentErrors(fakeFiles(array(array('a.txt', 0, UPLOAD_ERR_PARTIAL))))) === 1);
check('the total size is limited', count(attachmentErrors(fakeFiles(array(
	array('a.zip', 5000000), array('b.zip', 5000000), array('c.zip', 5000000), array('d.zip', 1000000)
)))) === 1);
