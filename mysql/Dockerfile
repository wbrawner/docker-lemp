FROM mysql:latest
RUN apt-get update -y && apt-get install -y vim
COPY ./my.cnf /etc/mysql/my.cnf
COPY ./mage-dbdump.sh /opt/mage-dbdump.sh
RUN chmod 644 /etc/mysql/my.cnf