## Feedback Integration By Kajal

#### Installation

+ Manual
```php
Step I     : Add The Extension Package In Directory :  <magento-root>/app/code/Kajal/Feedback

After successfully uploading the contents into the directory, Run the following upgrade command in cmd

php -d memory_limit=5G bin/magento setup:upgrade
php -d memory_limit=5G bin/magento setup:di:compile
php -d memory_limit=5G bin/magento setup:static-content:deploy -f
php -d memory_limit=5G bin/magento index:reindex
php -d memory_limit=5G bin/magento cache:flush
```

#### How To Use :

- **In the footer of the website, you will find an item named Feedback. On clicking it, you will get the Feedback Send Form through which you can send feedback.** 

- **In admin you will get feedback module in which you can set up reciever email by clicking on configuration.** 

- **When you will click on the feedback menu , you'll be able to see feedbacks grid where you can inline edit and delete feedback.**

- **When customers send feedback, a mail will also be sent to you at the time if you'll  configured your SMTP settings.** 
