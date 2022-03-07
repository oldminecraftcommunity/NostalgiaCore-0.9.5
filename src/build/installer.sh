#!/bin/bash
echo "==================================="
echo "NostalgiaCore Installer"
echo "==================================="
echo "["$(date +%k:%M)"] Downloading NostalgiaCore..."
wget https://owouwu.ru/master.zip > /dev/null
echo "["$(date +%k:%M)"] Extracting..."
unzip master.zip > /dev/null
cd NostalgiaCore-master
mv * ../
cd ../
rm -r NostalgiaCore-master
rm master.zip
rm bin.7z
echo "["$(date +%k:%M)"] Downloading PHP..."
wget https://owouwu.ru/NC_bin.tar.gz > /dev/null
tar -xvf NC_bin.tar.gz
rm NC_bin.tar.gz
if [ $(./bin/php5/bin/php -r 'echo "yes";' 2>/dev/null) == "yes" ]; then
    OPCACHE_PATH="$(find $(pwd) -name opcache.so)"
    XDEBUG_PATH="$(find $(pwd) -name xdebug.so)"
    echo "" > "./bin/php5/bin/php.ini"
    #UOPZ_PATH="$(find $(pwd) -name uopz.so)"
    #echo "zend_extension=\"$UOPZ_PATH\"" >> "./bin/php5/bin/php.ini"
    echo "zend_extension=\"$OPCACHE_PATH\"" >> "./bin/php5/bin/php.ini"
    echo "zend_extension=\"$XDEBUG_PATH\"" >> "./bin/php5/bin/php.ini"
    echo "opcache.enable=1" >> "./bin/php5/bin/php.ini"
    echo "opcache.enable_cli=1" >> "./bin/php5/bin/php.ini"
    echo "opcache.save_comments=0" >> "./bin/php5/bin/php.ini"
    echo "opcache.fast_shutdown=1" >> "./bin/php5/bin/php.ini"
    echo "opcache.max_accelerated_files=4096" >> "./bin/php5/bin/php.ini"
    echo "opcache.interned_strings_buffer=8" >> "./bin/php5/bin/php.ini"
    echo "opcache.memory_consumption=128" >> "./bin/php5/bin/php.ini"
    echo "opcache.optimization_level=0xffffffff" >> "./bin/php5/bin/php.ini"
    echo "date.timezone=$TIMEZONE" >> "./bin/php5/bin/php.ini"
    echo "short_open_tag=0" >> "./bin/php5/bin/php.ini"
    echo "asp_tags=0" >> "./bin/php5/bin/php.ini"
    echo "phar.readonly=0" >> "./bin/php5/bin/php.ini"
    echo "phar.require_hash=1" >> "./bin/php5/bin/php.ini"
    echo "done"
    alldone=yes
else
    echo "Invalid PHP build detected"
fi
echo "Done, starting..."
echo "Wait >15 seconds..."
chmod +x start.sh
bash start.sh
