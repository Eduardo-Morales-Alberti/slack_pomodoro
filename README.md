# Pomodoro slack
Easy php application to change your slack status.

## How to install
* Clone this repo
* Run ```composer install```
* Add your slack OAuth user token to the app.ini file
* You can configure the status message, the icon and the duration.

## How to get a slack user token
* You need a user on slack
* Go to [Your apps](https://api.slack.com/apps)
* Click on "Create New App"
* Then create the application, go to "Features/OAuth & Permissions" on the left sidebar.
* Go to "User Token Scopes" and add "users.profile:write" clicking on "Add an OAuth Scope"
* Then click on "Settings/Install App" and choose a workspace to install it.
* Then install the application copy the "OAuth Access Token" and add it to the app.ini file.
```
user_token = 'xoxp-XXXX-XXXX-XXXX-XXXX'
```

## How to use
* Start a new pomodoro (25 minutes by default but is configurable) ```php [repository_folder]/index.php start```
* Stop pomodoro ```php [repository_folder]/index.php stop```

## Add a shortcut
* Edit/add a bash file ~/.bashrc
* Add the following lines to the file
```
alias pomodoro="php [repository_folder]/index.php"
```
* Registry the new alias
```
source ~/.bashrc
```
* Try your command
```
pomodoro start

pomodoro stop
```
