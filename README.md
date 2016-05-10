Accolade's Docker LEMP Stack for Magento
=============================

To get started, first [download and install Docker](https://docs.docker.com/engine/installation/).

Once you have that out of the way, you'll first need to delete the default machine, and replace it with one that has a bit more RAM. You shouldn't allocate more than half oif your total RAM to the machine. Since I have 8GB of RAM, I'll allocate 4GB to Docker, so I still have a bit for my host machine:

Remove the existing machine:

`docker-machine rm default`

Replace it with a new one:

`docker-machine create -d virtualbox --virtualbox-memory "4096" default`

You can replace `default` with whatever you like. It's not very important.

With your new machine set up, cd into the directory where these files are located. Docker will start you at your home by default, so for me it's just

`cd Documents/docker-lemp`

*Reminder to Windows devs:* This is a bash shell, so capitalization counts.

From the docker-lemp directory, you can run

`docker-compose up -d`

This will take some time because Docker will have to fetch and configure all of the containers required to run the LEMP stack. As per the Docker philosophy, each process is run in its own container.

Once the installation is complete, run

`docker-machine ip default`

to get the IP address of your Docker machine. Drop that into the address bar of your favorite browser and you should see a screen very much like this one!

You can also use that same IP address to set up MySQL Workbench with it, if you prefer, or you can use PHPMyAdmin, by visiting your machine's IP address on port 8080. In my case, this would be [http://192.168.99.100:8080](http://192.168.99.100:8080).

The default root password is 123123, and comes with a starter DB called magento, with access granted to a magento user with the password magento. These values can be changed from the environment variables in the MySQL Dockerfile. Feel free to add other databases as well.

Once you have your Docker machine running, you can place your files in the public_html folder. The other folders contain configuration files, so it's not recommended to add files to them or modify them in any way.

To get shell access to your machine, there are a couple of things you have to take into consideration. The most important being that the process are each run in their own containers, so you cannot access multiple processes from the same shell. This means that you will need to open a different shell process for each running process you wish to connect to. To see a list of all of your running containers, use the following command:

`docker ps`

this will give you an output that looks something like this:

```bash
$ docker ps
 CONTAINER ID        IMAGE                   COMMAND                  CREATED             STATUS              PORTS                         NAMES
 50d61f2b31cb        dockerlemp_nginx        "nginx -g 'daemon off"   About an hour ago   Up About an hour    0.0.0.0:80->80/tcp, 443/tcp   dockerlemp_nginx_1
 190bc213fe3a        dockerlemp_php          "php-fpm"                About an hour ago   Up About an hour    9000/tcp                      dockerlemp_php_1
 fe0d4632c300        phpmyadmin/phpmyadmin   "/run.sh"                About an hour ago   Up About an hour    0.0.0.0:8080->80/tcp          dockerlemp_phpmyadmin_1
 509ab5917034        dockerlemp_mysql        "docker-entrypoint.sh"   About an hour ago   Up About an hour    0.0.0.0:3306->3306/tcp        dockerlemp_mysql_1
 ```

 By using either the container id or its name, you can connect to them with the following command:

 `docker exec -it CONTAINER_NAME/ID /bin/bash`

 Replace CONTAINER_NAME/ID with the name or id of the container you'd like to connect to, and you will be dropped into a bash environment where you can run commands like importing a large database into MySQL or running composer or magerun (both of which are already installed and ready to use.)

 So, to run a composer installation, you would need to first run

 `docker exec -it dockerlemp_php_1 /bin/bash`

 to gain access to the shell, and then you could cd into the correct directory and run your composer install command.

As stated earlier, you will not have access to the mysql process from this shell. To gain that, you'll have to press `Ctrl + D` to exit the current shell, and then run

 `docker exec -it dockerlemp_mysql_1 /bin/bash`

to enter a shell with access to the mysql process.

**DISCLAIMER:**

This Docker machine should under NO circumstances, be used in a production environment. This is solely intended for local development, and has numerous security concerns that would need to be addressed prior to being a feasible production candidate. You have been warned.
