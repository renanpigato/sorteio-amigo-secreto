# Projeto para sorteio de amigo secreto

```bash
docker-compose up
```

```bash
docker exec -it sorteio-amigo-secreto_php56_sorteio_amigo_secreto_1 bash

./composer.phar update
exit
```

Configure a rota de conexao para base de dados no arquivo propel.yml, por padrao deve ser algo como:
- sorteio-amigo-secreto_mysql_sorteio_amigo_secreto_1

```bash
docker exec -it sorteio-amigo-secreto_php56_sorteio_amigo_secreto_1 bash

vendor/bin/propel config:convert
vendor/bin/propel model:build
exit
```

```bash
docker exec -it sorteio-amigo-secreto_mysql_sorteio_amigo_secreto_1 bash

mysql -u root -p
create database sorteio_amigo_secreto;
use sorteio_amigo_secreto;
\. /home/default.sql
exit
exit
```

```bash
docker exec -it sorteio-amigo-secreto_php56_sorteio_amigo_secreto_1 bash

vendor/bin/propel migration:migrate
exit
```

Renomeie o arquivo conf/application.php.dist para conf/application.php, nesse arquivo deve ser configurada no mínimo a diretiva do domínio e do path que se o projeto não for movido para nenhuma pasta deixar o valor null
