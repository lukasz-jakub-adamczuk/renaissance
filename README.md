# renaissance
public code for squarezone.pl


## Directories

Need after installation

* app/logs
* app/cache
* app/templates_c

* web/tmp


## Dependencies

### Internal

*aya
*dao
*ivy (optional)

### External

* smarty
> smarty-3.1.30

* GD

'''sudo apt-get install php7.0-gd'''

* pdo

'''sudo apt-get install php7.0-mysql'''

* gulp
`npm install -g gulp`

### run localhost

* download source code from github
* could be necessary to update source code with production config or code
* configure apache2 with vhosts, /etc/hosts, and apache.conf, php.ini, etc.
* download db backup from prod
    create db on localhost (mysql)
    disable ONLY_FULL_GROUP_MODE if mysql 5.7+
* copy dependecies (lib/smarty)
* setup project with directories like logs, tmp, templates_c, etc. available to write
    run `npm install` inside project
    run `sh ./scripts/init-project.sh`