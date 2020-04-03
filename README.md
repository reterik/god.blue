God.blue RSS Search Engine
God.blue research and development

1. Install redis-server mysql-server php7.2 packages
2. Run to load RSS urls into redis server: php predis/examples/file_redis_copy_csv.php
3. Run import script scraper.sql and create scraper database: mysql -u root -p scraper << scraper.sql
4. Add crontab from crontab file into your cronjobs using crontab -e
5. Run create table script for today: php create_table.php
6. Crontab should auto load the crawler scripts. You can edit the predis/examples/csv_xml_import.sh script according to how many times you want script to load the predis/examples/csv_xml_import.php script can also be edited in frequency at the bottom of the do while loop.

Question Article Answering System QaaS AI 2.0

1. Install pip with sudo apt install python3-pip
2. Install AllenNLP with pip3 install allennlp
3. Test qaas.php page with question

Also you can run php easy-deep-learning-with-AllenNLP/question.php test for unsupervised learning questions.
