Telegram Bot Application using PHP Simple Attendance

Telegram bots can be used as a fairly efficient alternative for recording attendance. Here's how to create a simple attendance record using a Telegram bot using PHP.

1. Create a Telegram Bot via BotFather
2. Create a Webhook:
https://api.telegram.org/bot<tokenbot>/setwebhook?url=https://<domain>/<file_webhook>.php
3. Create a Database
The created database is used to store user contacts and user-to-bot history. Here's an ERD for a simple database that can be used for attendance:
4. Create Logic for webhook
5. Create a Telegram Chat Group
6. Simple Attendance Telegram Bot Results
When a user records attendance through the bot and if the attendance entered is for sickness/annual leave/marriage leave/maternity leave, the bot will send a notification to the Attendance Group Chat. 
