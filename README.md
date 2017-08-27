# Search Modified Files
This is a small PHP script file which can be used as standalone application to get list of modified files.
This file is used to find modified files in a source code in any PHP based source code. Mainly created to be used in Magento setups to find list of updated/modified files over FTP. It can be used in any PHP based setup like Magento, Wordpress, Laravel, CodeIgniter, CakePHP, etc.

How to use?<br />
Put modified.php file in your system's root folder and access it with URL<br />
http:://yourhostname.com/modified.php

It asks for 3 input, <br />
Days (compulsory) <br />
Name of Directory (Optional)<br />
File Extension (Optional)

![ScreenShot](https://jsutariya.files.wordpress.com/2017/08/modified-script.png?w=800)

Days field accepts the number of days for which you want to get the list of modified files in your filesystem

Name of Directory will be the name of the directory in which you want to search the keyword. If not specified, it will search in all directories of root folder in which the file is placed. It is recommeded to use directory name, if you know the location of the file. You can add sub directory with its path like, app/code/local

File Extension will be the extension of the file in which you want to seach a specific keyword. It accepts multiple values with comma separated like, "php,phtml,xml" It will search through only those files with specified extension.

When you click on search button, it will search from all files as per criteria and will display you the results with the files modified in specified number of days.

![ScreenShot](https://jsutariya.files.wordpress.com/2017/08/modified-script-list.png?w=800)
