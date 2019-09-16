#!/usr/bin/env fish

echo
echo
echo "TESTING 1000 files"
time php test.php json 1000
time php test.php pw-json 1000
time php test.php spyc 1000
time php test.php symf 1000
time php test.php radham 1000


echo
echo
echo "TESTING 2000 files"
time php test.php json 2000
time php test.php pw-json 2000
time php test.php spyc 2000
time php test.php symf 2000
time php test.php radham 2000

echo
echo
echo "TESTING 5000 files"
time php test.php json 5000
time php test.php pw-json 5000
time php test.php spyc 5000
time php test.php symf 5000
time php test.php radham 5000

echo
echo
echo "TESTING 10000 files"
time php test.php json 10000
time php test.php pw-json 10000
time php test.php spyc 10000
time php test.php symf 10000
time php test.php radham 10000
