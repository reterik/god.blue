import aqgFunction
import sys
import pymysql

db = pymysql.connect(
host="127.0.0.1",
user="root",
password="gh3tt0b1tch!@#",
database="scraper",
port=3306
)



# Main Function
def main():
    # Create AQG object
    aqg = aqgFunction.AutomaticQuestionGenerator()

#    inputTextPath = '/home/reterik/Automatic-Question-Generator/AutomaticQuestionGenerator/DB/db.txt'
#    inputTextPath = '/var/lib/mysql-files/2019_09_30.sql'
#    readFile = open(inputTextPath, 'r+', encoding="utf8")
#    readFile = open(inputTextPath, 'r+', encoding="utf8", errors = 'ignore')

    inputText = (sys.argv[2])
#    inputText = readFile.read()
#    inputText = '''I really am happy that this actually works I need to input a bunch of text to see what the output is.'''
#    print(inputText)

    questionList = aqg.aqgParse(inputText)
    aqg.display(questionList)
    f = ''
    aqg.DisNormal(questionList)
    return 0

"""
    my = db.cursor()
    my.execute('select * from 2019_09_24 limit 1000')
    result = my.fetchall()
    f = "intro"
    for x in result:
        a = x[0]
        b = x[1]
        c = x[2]
        d = x[3]
        e = x[4]
        print(a, b, c, d, e)
        #print(x)
        inputText = b + e

        print(inputText)

        questionList = aqg.aqgParse(inputText)
        aqg.display(questionList)
        f = ''
        f += aqg.DisNormal(questionList)
        print(f)
        my.execute('INSERT IGNORE into 2019_09_24_q (counter, url, timestamp, question) VALUES (%s, %s, %s, %s)', (a, b, d, f))
        db.commit()
    #result = my.fetchall()
"""


# Call Main Function
if __name__ == "__main__":
    main()

