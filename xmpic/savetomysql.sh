#!/bin/bash
host=localhost
username=root
password=root
#database=pyspider
#table=xmpic

mysql --local-infile -u$username -p$password -h$host --database pyspider << EOF
load data local infile 'data.txt' into table xmpic(url,dir,size,title);
EOF
