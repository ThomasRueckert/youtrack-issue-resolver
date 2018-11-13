<?php
/**
 * unifysell GbR
 * Zschopauer Str. 159
 * 09126 Chemnitz
 * Germany
 *
 * Web: https://unifysell.de
 * Phone: +49 176 270 68 7 68
 * Mail: info@unifysell.de
 * USt-IdNr.: DE315094601
 *
 * @author Christian Staude <c.staude@nepda.eu>
 * @author Nepomuk Fraedrich <info@nepda.eu>
 * @author Thomas Rueckert <t.rueckert@nepda.eu>
 * @copyright 2018 unifysell - Christian Staude, Nepomuk Frädrich, Thomas Rückert GbR
 */

require __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config.php';

if (count($argv) < 2) {
    throw new \InvalidArgumentException('You need to give a filter string as argument.');
}

$youtrack = new YouTrack\Connection(
    $config['url'],
    $config['token'],
    null
);

$issues = $youtrack->getIssuesByFilter($argv[1], null, 500);

$issueIds = [];
foreach ($issues as $issue) {
    $issueIds[] = $issue->getId();
}

$nrIssues = count($issueIds);
echo "Found $nrIssues issues." . PHP_EOL;

$c = 1;
$modCnt = (int) ($nrIssues / 10);

if ($modCnt < 1) {
    $modCnt = 1;
}

echo '(0/' . $nrIssues . ')';
foreach ($issueIds as $issueId) {
    echo "$c % $modCnt";
    if ($c % $modCnt === 0) {
        echo PHP_EOL;
        echo '(' . $c . '/' . $nrIssues . ')';
    }
    echo '.';
    $youtrack->executeCommand($issueId, 'Fixed', 'Automatically resolved via issue-resolver. ts: ' . time());
    $c++;
}
