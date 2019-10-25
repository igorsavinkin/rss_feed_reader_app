# A simple RSS reader web application

## The app concept
The app lets new users to register and after successful login a user might read an RSS feed.

### The app has the following views:
1. User registration - the form with e-mail and password fields + e-mail verification using ajax.
Existence of already registered e-mail should be checked “on the fly” via ajax call when writing e-mail
address and before submitting form.
2. Login form with e-mail address and password.
3. RSS feed view, [the feed source](https://www.theregister.co.uk/software/headlines.atom).

### The RSS feed view consists of 2 sections:
 1. The top section displayed 10 most frequent words with their respective counts in the feed excluding top 50 English common words; the later are taken from [Most common words in English](https://en.wikipedia.org/wiki/Most_common_words_in_English).
 2. The lower section displays the list of the feed items.
 
## Installation
1. Clone the repository into an existing **PHP** enviroment. 
2. Get the content of the ``user.sql`` file and run it at the **MySQL** server console or at the *phpMyAdmin*. 
3. Set up the **MySQL** database credentials inside of the ``db_config.php`` file.
4. Start the app by visiting ``index.php`` file.
