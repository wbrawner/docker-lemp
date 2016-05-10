<?php
/**
 * Created by PhpStorm.
 * User: Billy
 * Date: 5/10/2016
 * Time: 2:15 PM
 */

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Accolade Docker - LEMP Stack</title>
    </head>
    <body>
        <style scoped>
            body {font-family: sans-serif;}
            h1, h2 {text-align: center;}
            .content {
                max-width: 1000px; 
                margin: auto;
                text-align: justify;
            }
            pre {
                background-color: #012456;
                color: #f1f1f1;
                overflow-x: scroll;
                padding: 5px 10px;
            }
            .info {
                border: 1px solid #FFDE73;
                border-top: 3px solid #FFDE73;
                padding: 15px 10px;
                background: #FFF6D9;
            }
            .info span {
                border: 1px solid #E4E4E4;
                padding: 1px;
                border-radius: 2px;
                background: #ffffff;
            }
        </style>
        <div class="content">
            <h1>Accolade's Docker LEMP Stack for Magento</h1>
            <p>To get started, first <a href="https://docs.docker.com/engine/installation/" target="_blank">download and install Docker</a>.</p>

            <p>Once you have that out of the way, you'll first need to delete the default machine, and replace it with one that has a bit more RAM. You shouldn't allocate more than half of your total RAM to the machine. Since I have 8GB of RAM, I'll allocate 4GB to Docker, so I still have a bit for my host machine:</p>

            <p>Remove the existing machine:</p>

            <pre>docker-machine rm default</pre>

            <p>Replace it with a new one:</p>

            <pre>docker-machine create -d virtualbox --virtualbox-memory "4096" default</pre>

            <p>You can replace</p>
            <pre>default</pre>
            <p>with whatever you like. It's not very important.</p>

            <p>With your new machine set up, cd into the directory where these files are located. Docker will start you at your home by default, so for me it's just</p>

            <pre>cd Documents/docker-lemp</pre>

            <p><i>Reminder to Windows devs:</i> This is a bash shell, so capitalization counts.</p>

            <p>From the docker-lemp directory, you can run</p>

            <pre>docker-compose up -d</pre>

            <p>This will take some time because Docker will have to fetch and configure all of the containers required to run the LEMP stack. As per the Docker philosophy, each process is run in it's own container.</p>

            <p>Once the installation is complete, run</p>

            <pre>docker-machine ip default</pre>

            <p>to get the IP address of your Docker machine. Drop that into the address bar of your favorite browser and you should see a screen very much like this one!</p>

            <p>You can also use that same IP address to set up MySQL Workbench with it, if you prefer, or you can use PHPMyAdmin, by visiting your machine's IP address on port 8080. In my case, this would be <a href="http://192.168.99.100:8080" target="_blank">http://192.168.99.100:8080</a>.</p>

            <p>The default root password is 123123, and comes with a starter DB called magento, with access granted to a magento user with the password magento. These values can be changed from the environment variables in the MySQL Dockerfile. Feel free to add other databases as well.</p>

            <p>Once you have your Docker machine running, you can place your files in the public_html folder. The other folders contain configuration files, so it's not recommended to add files to them or modify them in any way.</p>

            <p>To get shell access to your machine, there are a couple of things you have to take into consideration. The most important being that the process are each run in their own containers, so you cannot access multiple processes from the same shell. This means that you will need to open a different shell process for each running process you wish to connect to. To see a list of all of your running containers, use the following command:</p>

            <pre>docker ps</pre>

            <p>this will give you an output that looks something like this:</p>

            <pre>$ docker ps
CONTAINER ID        IMAGE                   COMMAND                  CREATED             STATUS              PORTS                         NAMES
50d61f2b31cb        dockerlemp_nginx        "nginx -g 'daemon off"   About an hour ago   Up About an hour    0.0.0.0:80->80/tcp, 443/tcp   dockerlemp_nginx_1
190bc213fe3a        dockerlemp_php          "php-fpm"                About an hour ago   Up About an hour    9000/tcp                      dockerlemp_php_1
fe0d4632c300        phpmyadmin/phpmyadmin   "/run.sh"                About an hour ago   Up About an hour    0.0.0.0:8080->80/tcp          dockerlemp_phpmyadmin_1
509ab5917034        dockerlemp_mysql        "docker-entrypoint.sh"   About an hour ago   Up About an hour    0.0.0.0:3306->3306/tcp        dockerlemp_mysql_1
            </pre>

            <p>By using either the container id or its name, you can connect to them with the following command:</p>

            <pre>docker exec -it CONTAINER_NAME/ID /bin/bash</pre>

            <p>Replace CONTAINER_NAME/ID with the name or id of the container you'd like to connect to, and you will be dropped into a bash environment where you can run commands like importing a large database into MySQL or running composer or magerun (both of which are already installed and ready to use.)</p>

            <p>So, to run a composer installation, you would need to first run</p>

            <pre>docker exec -it dockerlemp_php_1 /bin/bash</pre>

            <p>to gain access to the shell, and then you could cd into the correct directory and run your composer install command.</p>

            <p>As stated earlier, you will not have access to the mysql process from this shell. To gain that, you'll have to press</p>
            <pre>Ctrl + D</pre>
            <p>to exit the current shell, and then run</p>

            <pre>docker exec -it dockerlemp_mysql_1 /bin/bash</pre>

            <p>to enter a shell with access to the mysql process.</p>

            <p class="info">For all questions and concerns, ping <span>@Billy</span> in Flowdock</p>

            <h2>DISCLAIMER:</h2>

            <p>This Docker machine should under NO circumstances, be used in a production environment. This is solely intended for local development, and has numerous security concerns that would need to be addressed prior to being a feasible production candidate. You have been warned.</p>
        </div>
    </body>
</html>
