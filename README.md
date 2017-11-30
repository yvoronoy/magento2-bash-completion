# Magento2 Bash Completion [![Build Status](https://travis-ci.org/yvoronoy/magento2-bash-completion.svg?branch=master)](https://travis-ci.org/yvoronoy/magento2-bash-completion)
This plugin adds autocompletion for Magento 2 CLI Sub Commands and their Options.

## Example

![Magento2 Bash Completion Screenshot](https://raw.githubusercontent.com/yvoronoy/ReadmeMedia/master/magento2-bash-completion.gif)

```
user@host:~$ bin/magento[TAB][TAB]
admin:user:create                        info:dependencies:show-modules-circular
admin:user:unlock                        info:language:list
bash:completion:generate                 info:timezone:list

...
```

```
user@host:~$ bin/magento setup:install --[TAB][TAB]
--admin-email                   --db-password
--admin-firstname               --db-prefix
--admin-lastname                --db-user
```

## Prerequisities
To use magento2 bash completion you should have installed Bash Completion.
If you don't have installed bash-completion follow guides:
 * [How to install bash-completion in Debian](https://www.howtoforge.com/how-to-add-bash-completion-in-debian)
 * [How to install bash-completion in MacOSX](http://davidalger.com/development/bash-completion-on-os-x-with-brew)


## Installation Bash Completion
New completion commands may be placed inside the directory /etc/bash_completion.d or inside /usr/local/etc/bash_completion.d/magento2-bash-completion on MacOSX.

Mac OSX
```
curl -o /usr/local/etc/bash_completion.d/magento2-bash-completion https://raw.githubusercontent.com/yvoronoy/magento2-bash-completion/master/magento2-bash-completion
```


Linux
```
sudo curl -o /etc/bash_completion.d/magento2-bash-completion https://raw.githubusercontent.com/yvoronoy/magento2-bash-completion/master/magento2-bash-completion
```

Don't forget reload shell or you can load new complition by next command: `user@host:~$ .  /etc/bash_completion.d/magento2-bash-completion`

## Installation Magento2 Bash Completion Extension
Magento2 Bash Completion Extension allows you generate your own bash completion list. It collects all available commands and generates a bash completion.

You can install the extension by the composer
```
composer require yvoronoy/magento2-bash-completion
```
