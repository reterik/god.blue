1. Install redis-server mysql-server php7.2 packages
2. Run to load RSS urls into redis server: php predis/examples/file_redis_copy_csv.php
3. Run import script scraper.sql and create scraper database: mysql -u root -p scraper << scraper.sql
4. Add crontab from crontab file into your cronjobs using crontab -e
5. Run create table script for today: php create_table.php

Crontab should auto load the crawler scripts.  You can edit the predis/examples/csv_xml_import.sh script according to how many times you want script to load the predis/examples/csv_xml_import.php script can also be edited in frequency at the bottom of the do while loop.




God.blue RSS Search Engine
God.blue research and development

Install redis-server mysql-server php7.2 packages
Run to load RSS urls into redis server: php predis/examples/file_redis_copy_csv.php
Run import script scraper.sql and create scraper database: mysql -u root -p scraper << scraper.sql
Add crontab from crontab file into your cronjobs using crontab -e
Run create table script for today: php create_table.php
Crontab should auto load the crawler scripts. You can edit the predis/examples/csv_xml_import.sh script according to how many times you want script to load the predis/examples/csv_xml_import.php script can also be edited in frequency at the bottom of the do while loop.

Question Article Answering System QaaS AI 2.0

Install pip with sudo apt install python3-pip
Install AllenNLP with pip3 install allennlp
Test qaas.php page with question
