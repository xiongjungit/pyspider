#!/bin/bash
host=localhost
username=root
password=root
#database=pyspider
#table=xmpic

mysql --local-infile -u$username -p$password -h$host --database pyspider << EOF
load data local infile '/home/www/pri/python/xmpic/data/wallpaperlog1-2310.txt' into table xmpic(turl,wurl,size,title);
EOF
